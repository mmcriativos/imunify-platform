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
        Schema::create('database_pool', function (Blueprint $table) {
            $table->id();
            $table->string('database_name')->unique();
            $table->boolean('in_use')->default(false)->index();
            $table->string('tenant_id')->nullable()->index();
            $table->timestamp('allocated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('database_pool');
    }
};
