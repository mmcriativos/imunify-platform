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
        Schema::table('tenants', function (Blueprint $table) {
            $table->timestamp('grace_period_ends_at')->nullable()->after('trial_ends_at');
            $table->timestamp('suspended_at')->nullable()->after('grace_period_ends_at');
            $table->timestamp('archived_at')->nullable()->after('suspended_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['grace_period_ends_at', 'suspended_at', 'archived_at']);
        });
    }
};
