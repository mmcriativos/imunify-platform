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
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->foreignId('paciente_id')->constrained('pacientes');
            $table->enum('tipo', ['clinica', 'domiciliar'])->default('clinica');
            $table->foreignId('cidade_id')->nullable()->constrained('cidades')->comment('Cidade do atendimento domiciliar');
            $table->string('endereco_atendimento')->nullable()->comment('Endereço do atendimento domiciliar');
            $table->decimal('valor_total', 10, 2)->default(0);
            $table->text('observacoes')->nullable();
            $table->foreignId('usuario_id')->constrained('users')->comment('Usuário que registrou');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendimentos');
    }
};
