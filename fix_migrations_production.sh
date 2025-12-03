#!/bin/bash

# Script para corrigir migration problemática em produção
# Execute: bash fix_migrations_production.sh

echo "🔧 Corrigindo migrations problemáticas..."

# 1. Remover migration duplicada da pasta errada
echo "📝 Removendo migration 2025_11_13_082912_add_branding_fields_to_tenants_table.php..."
rm -f database/migrations/2025_11_13_082912_add_branding_fields_to_tenants_table.php

# 2. Marcar migrations já aplicadas como executadas
echo "✅ Marcando migrations já aplicadas..."
php artisan tinker --execute="
\$tenants = App\Models\Tenant::all();
foreach (\$tenants as \$tenant) {
    echo \"Tenant: {\$tenant->id}\n\";
    tenancy()->initialize(\$tenant);
    
    \$migrations = [
        '2025_11_13_082912_add_branding_fields_to_tenants_table',
        '2025_11_13_095840_create_sessions_table',
    ];
    
    foreach (\$migrations as \$migration) {
        \$exists = DB::table('migrations')->where('migration', \$migration)->exists();
        if (!\$exists) {
            DB::table('migrations')->insert([
                'migration' => \$migration,
                'batch' => 1
            ]);
            echo \"  ✓ Marcada: \$migration\n\";
        }
    }
    
    tenancy()->end();
}
echo \"Concluído!\n\";
"

echo ""
echo "✅ Correção completa!"
echo ""
echo "Agora execute: php artisan tenants:run migrate"
