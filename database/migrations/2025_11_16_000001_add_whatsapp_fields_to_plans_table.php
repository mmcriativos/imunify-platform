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
        Schema::table('plans', function (Blueprint $table) {
            $table->enum('whatsapp_mode', ['none', 'shared', 'own'])
                ->default('none')
                ->after('max_users')
                ->comment('none=sem WhatsApp, shared=número Imunify, own=número próprio');
            
            $table->integer('whatsapp_quota')
                ->default(0)
                ->after('whatsapp_mode')
                ->comment('Mensagens WhatsApp por mês (0 = sem WhatsApp)');
            
            $table->boolean('whatsapp_unlimited')
                ->default(false)
                ->after('whatsapp_quota')
                ->comment('WhatsApp ilimitado (para planos Enterprise)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_mode', 'whatsapp_quota', 'whatsapp_unlimited']);
        });
    }
};
