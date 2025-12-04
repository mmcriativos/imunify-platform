<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alterar enum da coluna role
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('master', 'admin', 'user') DEFAULT 'user' COMMENT 'master=Administrador master, admin=Administrador, user=Usuário comum'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Voltar para enum antigo
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manager', 'operator', 'viewer') DEFAULT 'operator'");
    }
};
