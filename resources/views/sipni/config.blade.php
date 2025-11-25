@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Cabeçalho -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Integração RIA (RNDS)</h1>
                <p class="text-gray-600">Configure a exportação automática via Rede Nacional de Dados em Saúde</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <p class="text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Status do Módulo -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold mb-2">Status do Módulo</h2>
                @if($module && $module->isActive())
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Ativo
                    </span>
                    <p class="text-sm text-gray-600 mt-2">Exportações automáticas habilitadas</p>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                        <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                        Inativo
                    </span>
                    <p class="text-sm text-gray-600 mt-2">Configure e ative para começar</p>
                @endif
            </div>

            <div class="flex gap-2">
                @if($module && !$module->isActive())
                    <form action="{{ route('sipni.activate') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Ativar Módulo
                        </button>
                    </form>
                @elseif($module && $module->isActive())
                    <form action="{{ route('sipni.suspend') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                            Desativar
                        </button>
                    </form>
                    <a href="{{ route('sipni.dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Ver Dashboard
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Estatísticas (se ativo) -->
    @if($stats)
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm text-gray-600 mb-1">Total de Exportações</div>
            <div class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-6">
            <div class="text-sm text-green-600 mb-1">Enviadas</div>
            <div class="text-3xl font-bold text-green-700">{{ $stats['enviados'] }}</div>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow p-6">
            <div class="text-sm text-yellow-600 mb-1">Pendentes</div>
            <div class="text-3xl font-bold text-yellow-700">{{ $stats['pendentes'] }}</div>
        </div>
        <div class="bg-red-50 rounded-lg shadow p-6">
            <div class="text-sm text-red-600 mb-1">Com Erro</div>
            <div class="text-3xl font-bold text-red-700">{{ $stats['erros'] }}</div>
        </div>
    </div>
    @endif

    <!-- Formulário de Configuração -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold mb-6">Configurações do SIPNI</h2>

        <form action="{{ route('sipni.config.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- CNES -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        CNES do Estabelecimento *
                    </label>
                    <input type="text" name="cnes" 
                           value="{{ old('cnes', tenant('cnes')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required maxlength="15"
                           placeholder="0000000">
                    <p class="text-xs text-gray-500 mt-1">Cadastro Nacional de Estabelecimentos de Saúde</p>
                </div>

                <!-- Ambiente -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ambiente *
                    </label>
                    <select name="ambiente" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="homologacao" {{ old('ambiente', $config['ambiente'] ?? '') == 'homologacao' ? 'selected' : '' }}>
                            Homologação (Testes)
                        </option>
                        <option value="producao" {{ old('ambiente', $config['ambiente'] ?? '') == 'producao' ? 'selected' : '' }}>
                            Produção
                        </option>
                    </select>
                </div>

                <!-- URL da API -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        URL da API RNDS (RIA) *
                    </label>
                    <input type="url" name="api_url" 
                           value="{{ old('api_url', $config['api_url'] ?? 'https://ehr-services.hmg.rnds.saude.gov.br') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required
                           placeholder="https://ehr-services.hmg.rnds.saude.gov.br">
                    <p class="text-xs text-gray-500 mt-1">RIA - Registro de Imunobiológico Administrado (versão RIA-R 1.8)</p>
                </div>

                <!-- Usuário -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Usuário SIPNI *
                    </label>
                    <input type="text" name="usuario" 
                           value="{{ old('usuario', $config['usuario'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required
                           placeholder="usuario@estabelecimento">
                </div>

                <!-- Senha -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Senha SIPNI *
                    </label>
                    <input type="password" name="senha" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required
                           placeholder="••••••••">
                    <p class="text-xs text-gray-500 mt-1">A senha será armazenada de forma criptografada</p>
                </div>
            </div>

            <div class="flex items-center justify-between mt-8 pt-6 border-t">
                <div class="text-sm text-gray-600">
                    <strong>Investimento:</strong> R$ {{ number_format($module->monthly_fee ?? 397, 2, ',', '.') }}/mês
                </div>
                <div class="flex gap-3">
                    <button type="button" 
                            onclick="testConnection()"
                            class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                        Testar Conexão
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Salvar Configurações
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Informações Adicionais -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
        <h3 class="text-blue-800 font-semibold mb-2">ℹ️ Informações Importantes</h3>
        <ul class="text-sm text-blue-700 space-y-1">
            <li>✓ Todas as vacinações serão exportadas automaticamente após a ativação</li>
            <li>✓ Certifique-se de cadastrar o CNS dos profissionais e pacientes</li>
            <li>✓ Configure os códigos SIPNI de cada vacina antes de usar</li>
            <li>✓ Mantenha os dados de lote sempre atualizados</li>
        </ul>
    </div>

    <!-- Como Obter Acesso -->
    <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
        <h3 class="text-yellow-800 font-semibold mb-2">🔑 Como Obter Acesso à API RIA (RNDS)</h3>
        <ol class="text-sm text-yellow-700 space-y-2 list-decimal list-inside">
            <li>Acesse o <a href="https://servicos-datasus.saude.gov.br/" target="_blank" class="underline font-semibold">Portal de Serviços do DataSUS</a></li>
            <li>Procure por <strong>"RIA - Registro de Imunobiológico Administrado"</strong> (versão RIA-R 1.8)</li>
            <li>Solicite acesso à API RNDS para integração</li>
            <li>Aguarde aprovação da equipe do DataSUS</li>
            <li>Teste no ambiente de homologação: <code class="bg-yellow-100 px-1">ehr-services.hmg.rnds.saude.gov.br</code></li>
            <li>Após validação, use produção: <code class="bg-yellow-100 px-1">ehr-services.rnds.saude.gov.br</code></li>
        </ol>
        <p class="text-xs text-yellow-600 mt-3">
            <strong>Importante:</strong> Use a API RIA (RNDS) para envio individual de vacinações. O SI-PNI Web legado foi descontinuado.
        </p>
    </div>
</div>

<script>
function testConnection() {
    fetch('{{ route('sipni.test-connection') }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✓ ' + data.message);
            } else {
                alert('✗ ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro ao testar conexão: ' + error);
        });
}
</script>
@endsection
