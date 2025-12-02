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
        Schema::create('whatsapp_connections', function (Blueprint $table) {
            $table->id();
            
            // Modo de operação
            $table->enum('mode', ['shared', 'own'])
                ->default('shared')
                ->comment('shared=número Imunify, own=número próprio');
            
            // Credenciais Z-API (apenas para modo 'own')
            $table->string('zapi_instance_id')->nullable();
            $table->string('zapi_token')->nullable();
            $table->string('zapi_client_token')->nullable();
            
            // Status da conexão
            $table->enum('status', ['disconnected', 'qrcode', 'connected'])
                ->default('disconnected');
            $table->string('phone_number')->nullable();
            $table->text('qrcode_base64')->nullable()->comment('QR Code em base64 para conexão');
            $table->timestamp('connected_at')->nullable();
            $table->timestamp('last_check_at')->nullable();
            
            // Controle de quota de mensagens
            $table->integer('messages_sent_month')->default(0);
            $table->integer('messages_quota')->default(0)->comment('Limite de mensagens/mês');
            $table->boolean('quota_unlimited')->default(false);
            $table->date('quota_reset_date')->nullable()->comment('Data de reset do contador mensal');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_connections');
    }
};
