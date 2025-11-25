<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('caixas', function (Blueprint $table) {
            if (!Schema::hasColumn('caixas', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('conciliacoes_cartao', function (Blueprint $table) {
            if (!Schema::hasColumn('conciliacoes_cartao', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('caixas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('conciliacoes_cartao', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
