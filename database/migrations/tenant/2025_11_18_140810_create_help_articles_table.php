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
        Schema::create('help_articles', function (Blueprint $table) {
            $table->id();
            
            // Organização
            $table->string('categoria_slug')->index()->comment('whatsapp, agendamentos, vacinas, pacientes, relatorios, configuracoes');
            $table->string('titulo');
            $table->string('slug')->unique();
            
            // Conteúdo
            $table->longText('conteudo_html')->comment('HTML renderizado com formatação');
            $table->text('resumo')->nullable()->comment('Descrição curta para listagens');
            $table->json('tags')->nullable()->comment('Array de tags para busca');
            
            // Métricas e ordenação
            $table->integer('visualizacoes')->default(0);
            $table->integer('ordem')->default(0)->comment('Ordem de exibição na categoria');
            $table->boolean('destaque')->default(false)->comment('Artigo em destaque na home');
            
            // Status
            $table->boolean('ativo')->default(true);
            
            $table->timestamps();
            
            // Índices compostos para performance
            $table->index(['categoria_slug', 'ativo', 'ordem']);
            $table->index(['ativo', 'destaque']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_articles');
    }
};
