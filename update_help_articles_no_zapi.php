<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tenants = \App\Models\Tenant::all();

echo "🔄 Atualizando artigos para remover menções a Z-API...\n\n";

foreach ($tenants as $tenant) {
    echo "Tenant: {$tenant->id}\n";
    
    tenancy()->initialize($tenant);
    
    try {
        // Atualizar artigo de configuração WhatsApp
        $artigo = \App\Models\HelpArticle::where('slug', 'como-configurar-whatsapp-business')->first();
        
        if ($artigo) {
            $conteudoAtualizado = str_replace(
                'Insira as credenciais Z-API (Instance ID, Token, Client Token)',
                'Insira as credenciais de conexão fornecidas pela Imunify',
                $artigo->conteudo_html
            );
            
            $tagsAtualizadas = array_filter($artigo->tags ?? [], function($tag) {
                return !in_array(strtolower($tag), ['z-api', 'zapi']);
            });
            
            if (!in_array('api', $tagsAtualizadas)) {
                $tagsAtualizadas[] = 'api';
            }
            
            $artigo->update([
                'conteudo_html' => $conteudoAtualizado,
                'tags' => $tagsAtualizadas,
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
