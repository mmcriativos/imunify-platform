<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

echo "🔍 VERIFICANDO MODELO TENANT\n";
echo "==============================\n\n";

try {
    // Buscar tenant usando o model
    $tenant = Tenant::find('multiimune');
    
    if ($tenant) {
        echo "✅ Tenant encontrado via Model!\n\n";
        
        echo "📊 Propriedades do Model:\n";
        echo str_repeat("-", 50) . "\n";
        echo "  • ID: {$tenant->id}\n";
        echo "  • Clinic Name: {$tenant->clinic_name}\n";
        echo "  • Email: {$tenant->email}\n";
        echo "  • Created: {$tenant->created_at}\n";
        
        // Verificar se tem método para pegar database
        echo "\n🗄️ Informações de Database:\n";
        echo str_repeat("-", 50) . "\n";
        
        // Tentar métodos do trait HasDatabase
        if (method_exists($tenant, 'database')) {
            try {
                $db = $tenant->database();
                echo "  • database(): " . print_r($db, true) . "\n";
            } catch (\Exception $e) {
                echo "  • database(): ERRO - {$e->getMessage()}\n";
            }
        }
        
        if (method_exists($tenant, 'getInternal')) {
            try {
                $internal = $tenant->getInternal('tenancy_db_name');
                echo "  • getInternal('tenancy_db_name'): {$internal}\n";
            } catch (\Exception $e) {
                echo "  • getInternal(): ERRO - {$e->getMessage()}\n";
            }
        }
        
        // Verificar coluna data (JSON)
        echo "\n📝 Conteúdo da coluna 'data':\n";
        echo str_repeat("-", 50) . "\n";
        
        $dataJson = DB::connection('central')
            ->table('tenants')
            ->where('id', 'multiimune')
            ->value('data');
        
        if ($dataJson) {
            $data = json_decode($dataJson, true);
            echo json_encode($data, JSON_PRETTY_PRINT) . "\n";
            
            if (isset($data['tenancy_db_name'])) {
                echo "\n✅ tenancy_db_name encontrado no JSON!\n";
                echo "   Valor: {$data['tenancy_db_name']}\n";
            } else {
                echo "\n❌ tenancy_db_name NÃO está no JSON!\n";
                echo "   Chaves disponíveis: " . implode(', ', array_keys($data)) . "\n";
            }
        } else {
            echo "  • data está vazio/null\n";
        }
        
        // Listar todos os atributos do model
        echo "\n📋 Todos os atributos do Model:\n";
        echo str_repeat("-", 50) . "\n";
        $attributes = $tenant->getAttributes();
        foreach ($attributes as $key => $value) {
            if (is_string($value) && strlen($value) > 100) {
                $value = substr($value, 0, 100) . '...';
            }
            echo "  • {$key}: {$value}\n";
        }
        
    } else {
        echo "❌ Tenant não encontrado!\n";
    }
    
} catch (\Exception $e) {
    echo "\n❌ ERRO: " . $e->getMessage() . "\n";
    echo "📍 Arquivo: " . $e->getFile() . "\n";
    echo "📍 Linha: " . $e->getLine() . "\n";
    echo "\nStack trace:\n";
    echo $e->getTraceAsString() . "\n";
}
