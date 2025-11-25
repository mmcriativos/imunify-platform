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
        Schema::table('vacinas', function (Blueprint $table) {
            $table->string('lote_atual')->nullable()->after('estoque_ideal')->comment('Lote atual em uso');
            $table->date('validade_lote')->nullable()->after('lote_atual')->comment('Data de validade do lote atual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacinas', function (Blueprint $table) {
            $table->dropColumn(['lote_atual', 'validade_lote']);
        });
    }
};
