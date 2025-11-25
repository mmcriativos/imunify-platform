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
        Schema::create('tenant_modules', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            
            // Módulo
            $table->enum('module_name', [
                'sipni_integration',
                'advanced_reports',
                'whatsapp_premium',
                'multi_user',
                'api_integration'
            ]);
            
            // Status
            $table->boolean('active')->default(false);
            $table->date('activated_at')->nullable();
            $table->date('expires_at')->nullable();
            
            // Financeiro
            $table->decimal('monthly_fee', 10, 2)->default(0);
            $table->enum('billing_status', ['active', 'suspended', 'canceled'])->default('active');
            
            // Configurações específicas do módulo
            $table->json('settings')->nullable()
                ->comment('Configurações específicas de cada módulo');
            
            $table->timestamps();
            
            // Único por tenant+módulo
            $table->unique(['tenant_id', 'module_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_modules');
    }
};
