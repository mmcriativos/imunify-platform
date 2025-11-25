<?php

namespace App\Services;

use App\Models\Atendimento;
use App\Models\AtendimentoVacina;
use App\Models\SipniExport;
use App\Models\TenantModule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SipniExportService
{
    protected $baseUrl;
    protected $credentials;
    protected $cnes;
    
    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * Carrega configurações do tenant
     */
    protected function loadConfig(): void
    {
        // Verificar se módulo SIPNI está ativo
        $module = TenantModule::sipni()
            ->where('tenant_id', tenant('id'))
            ->active()
            ->first();

        if (!$module) {
            throw new \Exception('Módulo SIPNI não está ativo para este tenant');
        }

        $config = $module->getSipniConfig();
        
        $this->baseUrl = $config['api_url'] ?? config('services.sipni.url');
        $this->credentials = [
            'usuario' => $config['usuario'] ?? null,
            'senha' => $config['senha'] ?? null,
            'certificado' => $config['certificado_path'] ?? null,
        ];
        $this->cnes = tenant('cnes');
    }

    /**
     * Verifica se módulo SIPNI está ativo
     */
    public static function isEnabled(): bool
    {
        try {
            $module = TenantModule::sipni()
                ->where('tenant_id', tenant('id'))
                ->active()
                ->first();
                
            return $module && $module->isActive();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Exporta vacinação para SIPNI automaticamente
     */
    public function exportarVacinacao(AtendimentoVacina $atendimentoVacina): ?SipniExport
    {
        if (!self::isEnabled()) {
            return null;
        }

        // Criar registro de exportação
        $export = SipniExport::create([
            'atendimento_id' => $atendimentoVacina->atendimento_id,
            'atendimento_vacina_id' => $atendimentoVacina->id,
            'paciente_id' => $atendimentoVacina->atendimento->paciente_id,
            'vacina_id' => $atendimentoVacina->vacina_id,
            'usuario_id' => $atendimentoVacina->atendimento->usuario_id,
            'status' => 'pendente',
        ]);

        // Tentar enviar imediatamente
        $this->processar($export);

        return $export;
    }

    /**
     * Processa exportação para SIPNI
     */
    public function processar(SipniExport $export): bool
    {
        try {
            // Validar dados obrigatórios
            $this->validarDados($export);

            // Montar payload
            $payload = $this->montarPayload($export);
            
            // Salvar payload
            $export->update(['payload' => $payload]);

            // Enviar para SIPNI
            $resposta = $this->enviarParaSipni($payload);

            // Processar resposta
            if ($resposta['sucesso']) {
                $export->marcarComoEnviado(
                    $resposta['protocolo'],
                    $resposta['dados']
                );
                
                Log::info("SIPNI: Vacinação exportada com sucesso", [
                    'export_id' => $export->id,
                    'protocolo' => $resposta['protocolo']
                ]);
                
                return true;
            } else {
                $export->marcarComoErro($resposta['erro']);
                
                Log::warning("SIPNI: Erro ao exportar vacinação", [
                    'export_id' => $export->id,
                    'erro' => $resposta['erro']
                ]);
                
                return false;
            }

        } catch (\Exception $e) {
            $export->marcarComoErro($e->getMessage());
            
            Log::error("SIPNI: Exceção ao processar exportação", [
                'export_id' => $export->id,
                'erro' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Valida dados obrigatórios do SIPNI
     */
    protected function validarDados(SipniExport $export): void
    {
        $paciente = $export->paciente;
        $vacina = $export->vacina;
        $atendimentoVacina = $export->atendimentoVacina;
        $usuario = $export->usuario;

        $erros = [];

        // Paciente
        if (!$paciente->cpf && !$paciente->cns) {
            $erros[] = 'Paciente sem CPF ou CNS';
        }
        if (!$paciente->data_nascimento) {
            $erros[] = 'Paciente sem data de nascimento';
        }
        if (!$paciente->nome_mae) {
            $erros[] = 'Paciente sem nome da mãe';
        }
        if (!$paciente->sexo) {
            $erros[] = 'Paciente sem sexo definido';
        }

        // Vacina
        if (!$vacina->codigo_sipni) {
            $erros[] = 'Vacina sem código SIPNI configurado';
        }

        // Atendimento
        if (!$atendimentoVacina->lote) {
            $erros[] = 'Atendimento sem número do lote';
        }

        // Profissional
        if (!$usuario || !$usuario->cns) {
            $erros[] = 'Profissional sem CNS cadastrado';
        }

        // CNES
        if (!$this->cnes) {
            $erros[] = 'Estabelecimento sem CNES configurado';
        }

        if (count($erros) > 0) {
            throw new \Exception('Dados incompletos: ' . implode(', ', $erros));
        }
    }

    /**
     * Monta payload no formato SIPNI
     */
    protected function montarPayload(SipniExport $export): array
    {
        $paciente = $export->paciente;
        $vacina = $export->vacina;
        $atendimentoVacina = $export->atendimentoVacina;
        $atendimento = $export->atendimento;
        $usuario = $export->usuario;

        return [
            // Identificação do estabelecimento
            'estabelecimento' => [
                'cnes' => $this->cnes,
            ],
            
            // Dados do paciente
            'paciente' => [
                'cpf' => $this->limparCpf($paciente->cpf),
                'cns' => $paciente->cns,
                'nome' => $paciente->nome,
                'data_nascimento' => $paciente->data_nascimento->format('Y-m-d'),
                'sexo' => $paciente->sexo,
                'nome_mae' => $paciente->nome_mae,
                'municipio_residencia' => $paciente->cidade?->codigo_ibge,
            ],
            
            // Dados da vacinação
            'vacinacao' => [
                'vacina_codigo' => $vacina->codigo_sipni,
                'estrategia' => $vacina->estrategia_vacinacao ?? 'Rotina',
                'dose' => $this->determinarDose($atendimentoVacina),
                'lote' => $atendimentoVacina->lote,
                'fabricante' => $vacina->fabricante,
                'data_aplicacao' => $atendimento->data->format('Y-m-d'),
                'via_administracao' => 'IM', // Intramuscular - pode ser configurável
            ],
            
            // Dados do profissional
            'profissional' => [
                'cns' => $usuario->cns,
                'nome' => $usuario->name,
            ],
            
            // Metadados
            'sistema_origem' => 'Imunify',
            'versao' => '1.0',
            'timestamp' => now()->toIso8601String(),
        ];
    }

    /**
     * Envia dados para API do e-SUS VE / RNDS
     * 
     * IMPORTANTE: Esta é uma implementação de referência.
     * A integração real requer:
     * - Certificado digital ICP-Brasil
     * - Credenciais fornecidas pelo DataSUS
     * - Solicitação via Portal de Serviços: https://servicos-datasus.saude.gov.br/
     * - Homologação em ambiente de testes
     * - Documentação oficial da RNDS ou e-SUS VE
     */
    protected function enviarParaSipni(array $payload): array
    {
        try {
            // NOTA: Implementação simulada para demonstração
            // A API real do e-SUS VE/RNDS requer certificado digital e autenticação específica
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Api-Key' => $this->credentials['usuario'] ?? '',
                    // TODO: Adicionar autenticação com certificado digital
                    // 'X-Authorization-Timestamp' => now()->toIso8601String(),
                ])
                ->post($this->baseUrl . '/vacinacao', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'sucesso' => true,
                    'protocolo' => $data['protocolo'] ?? 'SEM_PROTOCOLO',
                    'dados' => $data,
                ];
            } else {
                return [
                    'sucesso' => false,
                    'erro' => 'HTTP ' . $response->status() . ': ' . $response->body(),
                ];
            }

        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'erro' => $e->getMessage(),
            ];
        }
    }

    /**
     * Reprocessa exportações com erro
     */
    public function reprocessarErros(int $limite = 50): array
    {
        $exports = SipniExport::comErro()
            ->where('tentativas', '<', 3)
            ->limit($limite)
            ->get();

        $resultados = [
            'processados' => 0,
            'sucesso' => 0,
            'erro' => 0,
        ];

        foreach ($exports as $export) {
            $resultados['processados']++;
            
            if ($this->processar($export)) {
                $resultados['sucesso']++;
            } else {
                $resultados['erro']++;
            }
        }

        return $resultados;
    }

    /**
     * Auxiliares
     */
    protected function limparCpf(?string $cpf): ?string
    {
        return $cpf ? preg_replace('/\D/', '', $cpf) : null;
    }

    protected function determinarDose(AtendimentoVacina $atendimentoVacina): string
    {
        // Lógica para determinar qual dose (1ª, 2ª, Reforço, etc)
        // Pode ser melhorado com histórico do paciente
        return '1ª Dose';
    }

    /**
     * Estatísticas de exportação
     */
    public function estatisticas(): array
    {
        return [
            'total' => SipniExport::count(),
            'pendentes' => SipniExport::pendentes()->count(),
            'enviados' => SipniExport::enviados()->count(),
            'erros' => SipniExport::comErro()->count(),
            'ultima_exportacao' => SipniExport::enviados()
                ->latest('data_envio')
                ->first()
                ?->data_envio,
        ];
    }
}
