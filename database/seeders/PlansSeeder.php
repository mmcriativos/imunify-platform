<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Ideal para clínicas pequenas começando a digitalização',
                'price_monthly' => 49.00,
                'price_yearly' => 490.00,
                'max_users' => 2,
                'max_patients' => 500,
                'max_monthly_appointments' => 100,
                'storage_gb' => 5,
                'whatsapp_enabled' => true,
                'whatsapp_own_number' => false,
                'whatsapp_mode' => 'shared',
                'whatsapp_quota' => 50,
                'whatsapp_unlimited' => false,
                'analytics_enabled' => false,
                'multi_unit_enabled' => false,
                'api_access' => false,
                'priority_support' => false,
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'description' => 'Para clínicas em crescimento que precisam de mais recursos',
                'price_monthly' => 99.00,
                'price_yearly' => 990.00,
                'max_users' => 5,
                'max_patients' => 2000,
                'max_monthly_appointments' => 500,
                'storage_gb' => 20,
                'whatsapp_enabled' => true,
                'whatsapp_own_number' => false,
                'whatsapp_mode' => 'shared',
                'whatsapp_quota' => 250,
                'whatsapp_unlimited' => false,
                'analytics_enabled' => true,
                'multi_unit_enabled' => false,
                'api_access' => false,
                'priority_support' => false,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => 'Solução completa com número próprio e recursos avançados',
                'price_monthly' => 149.00,
                'price_yearly' => 1490.00,
                'max_users' => 15,
                'max_patients' => 10000,
                'max_monthly_appointments' => 2000,
                'storage_gb' => 50,
                'whatsapp_enabled' => true,
                'whatsapp_own_number' => true,
                'whatsapp_mode' => 'own',
                'whatsapp_quota' => 2000,
                'whatsapp_unlimited' => false,
                'analytics_enabled' => true,
                'multi_unit_enabled' => true,
                'api_access' => true,
                'priority_support' => false,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Para redes e grandes clínicas com necessidades customizadas',
                'price_monthly' => 299.00,
                'price_yearly' => 2990.00,
                'max_users' => 999,
                'max_patients' => 999999,
                'max_monthly_appointments' => 999999,
                'storage_gb' => 200,
                'whatsapp_enabled' => true,
                'whatsapp_own_number' => true,
                'whatsapp_mode' => 'own',
                'whatsapp_quota' => 0,
                'whatsapp_unlimited' => true,
                'analytics_enabled' => true,
                'multi_unit_enabled' => true,
                'api_access' => true,
                'priority_support' => true,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::updateOrCreate(
                ['slug' => $planData['slug']],
                $planData
            );
        }

        $this->command->info('✅ Planos criados/atualizados:');
        $this->command->info('   - Starter: R$ 49/mês (50 msgs WhatsApp compartilhado)');
        $this->command->info('   - Pro: R$ 99/mês (250 msgs WhatsApp compartilhado)');
        $this->command->info('   - Premium: R$ 149/mês (2000 msgs WhatsApp próprio)');
        $this->command->info('   - Enterprise: R$ 299/mês (WhatsApp ilimitado próprio)');
    }
}
