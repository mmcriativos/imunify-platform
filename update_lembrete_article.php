<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tenants = \App\Models\Tenant::all();

echo "🔄 Atualizando artigo de lembretes automáticos...\n\n";

foreach ($tenants as $tenant) {
    echo "Tenant: {$tenant->id}\n";
    
    tenancy()->initialize($tenant);
    
    try {
        $artigo = \App\Models\HelpArticle::where('slug', 'lembrete-automatico-vacinacao')->first();
        
        if ($artigo) {
            $conteudoNovo = '<h2>🤖 Sistema Totalmente Automático</h2>
                <p>O Imunify analisa diariamente todos os pacientes e identifica doses de vacinas que estão:</p>
                <ul>
                    <li>✅ <strong>Atrasadas</strong>: já passou do prazo recomendado</li>
                    <li>⏰ <strong>Próximas</strong>: faltam poucos dias para aplicar</li>
                    <li>📅 <strong>Dentro de campanhas</strong>: período de campanha sazonal ativo</li>
                </ul>
                
                <h2>📅 Quando os Lembretes São Enviados?</h2>
                <p>O sistema roda <strong>automaticamente todo dia às 9h da manhã</strong>. Ele:</p>
                <ol>
                    <li>Verifica todos os pacientes cadastrados</li>
                    <li>Cruza com esquemas vacinais e campanhas ativas</li>
                    <li>Identifica doses pendentes</li>
                    <li>Envia mensagens personalizadas via WhatsApp</li>
                </ol>
                
                <h2>💬 Exemplo de Mensagem</h2>
                <pre>Olá Maria Silva! 👋

A vacina *Tríplice Viral* da Sofia está com a 2ª dose atrasada.

📅 Data recomendada: 15/10/2024
⚠️ Status: 15 dias de atraso

📍 Agende em {{ nome_da_clinica }}
📞 {{ telefone_clinica }}</pre>
                
                <h2>🎯 Personalizando Mensagens</h2>
                <p>As mensagens são automaticamente personalizadas com:</p>
                <ul>
                    <li>Nome do paciente e/ou responsável</li>
                    <li>Nome da vacina e número da dose</li>
                    <li>Data recomendada para aplicação</li>
                    <li>Nome e telefone da sua clínica</li>
                </ul>
                
                <blockquote>💡 <strong>Dica</strong>: Quanto mais completo o cadastro do paciente, melhores serão os lembretes!</blockquote>';
            
            $artigo->update([
                'conteudo_html' => $conteudoNovo,
            ]);
            
            echo "  ✅ Artigo atualizado com sucesso\n";
        } else {
            echo "  ⚠️ Artigo não encontrado\n";
        }
        
    } catch (\Exception $e) {
        echo "  ❌ Erro: {$e->getMessage()}\n";
    }
    
    tenancy()->end();
    echo "\n";
}

echo "✅ Processo concluído!\n";
