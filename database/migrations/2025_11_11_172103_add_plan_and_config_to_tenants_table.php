<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->foreignId('plan_id')->nullable()->after('id')->constrained('plans')->nullOnDelete();
            
            // Informações da clínica
            $table->string('clinic_name')->nullable()->after('plan_id');
            $table->string('cnpj')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('zip_code', 10)->nullable();
            
            // Configurações WhatsApp (próprio da clínica)
            $table->string('whatsapp_api_url')->nullable();
            $table->string('whatsapp_instance')->nullable();
            $table->text('whatsapp_token')->nullable();
            $table->text('whatsapp_client_token')->nullable();
            $table->boolean('whatsapp_enabled')->default(false);
            
            // Configurações gerais
            $table->string('logo_url')->nullable();
            $table->string('primary_color', 7)->default('#3B82F6');
            $table->string('timezone')->default('America/Sao_Paulo');
            
            // Status e limites
            $table->enum('status', ['active', 'suspended', 'cancelled'])->default('active');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('subscription_ends_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn([
                'plan_id', 'clinic_name', 'cnpj', 'phone', 'email', 'address',
                'city', 'state', 'zip_code', 'whatsapp_api_url', 'whatsapp_instance',
                'whatsapp_token', 'whatsapp_client_token', 'whatsapp_enabled',
                'logo_url', 'primary_color', 'timezone', 'status',
                'trial_ends_at', 'subscription_ends_at'
            ]);
        });
    }
};
