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
        Schema::table('users', function (Blueprint $table) {
            // Papel do usuário no sistema
            $table->enum('role', ['master', 'admin', 'user'])
                ->default('user')
                ->after('email')
                ->comment('master=Administrador master, admin=Administrador, user=Usuário comum');
            
            // Status do usuário
            $table->boolean('is_active')->default(true)->after('role');
            
            // Informações adicionais
            $table->string('phone')->nullable()->after('is_active');
            $table->timestamp('last_login_at')->nullable()->after('phone');
            $table->ipAddress('last_login_ip')->nullable()->after('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_active', 'phone', 'last_login_at', 'last_login_ip']);
        });
    }
};
