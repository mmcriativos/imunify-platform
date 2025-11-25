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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Básico, Profissional, Enterprise
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price_monthly', 10, 2);
            $table->decimal('price_yearly', 10, 2)->nullable();
            
            // Limites do plano
            $table->integer('max_users')->nullable()->comment('null = ilimitado');
            $table->integer('max_patients')->nullable()->comment('null = ilimitado');
            $table->integer('max_monthly_appointments')->nullable()->comment('null = ilimitado');
            $table->integer('storage_gb')->default(5);
            
            // Features
            $table->boolean('whatsapp_enabled')->default(false);
            $table->boolean('whatsapp_own_number')->default(false)->comment('Número próprio da clínica');
            $table->boolean('analytics_enabled')->default(false);
            $table->boolean('multi_unit_enabled')->default(false);
            $table->boolean('api_access')->default(false);
            $table->boolean('priority_support')->default(false);
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
