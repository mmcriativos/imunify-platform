<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('vacinas', 'lote_atual')) {
            Schema::table('vacinas', function (Blueprint $table) {
                $table->string('lote_atual')->nullable()->after('estoque_ideal');
            });
        }
        
        if (!Schema::hasColumn('vacinas', 'validade_lote')) {
            Schema::table('vacinas', function (Blueprint $table) {
                $table->date('validade_lote')->nullable()->after('lote_atual');
            });
        }
    }

    public function down(): void
    {
        Schema::table('vacinas', function (Blueprint $table) {
            if (Schema::hasColumn('vacinas', 'lote_atual')) {
                $table->dropColumn('lote_atual');
            }
            if (Schema::hasColumn('vacinas', 'validade_lote')) {
                $table->dropColumn('validade_lote');
            }
        });
    }
};