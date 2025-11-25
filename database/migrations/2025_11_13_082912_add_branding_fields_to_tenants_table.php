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
            $table->string('clinic_name')->nullable()->after('id');
            $table->string('clinic_subtitle')->nullable()->after('clinic_name');
            $table->text('clinic_description')->nullable()->after('clinic_subtitle');
            $table->string('clinic_logo')->nullable()->after('clinic_description');
            $table->string('primary_color', 7)->nullable()->default('#3b82f6')->after('clinic_logo');
            $table->text('contact_info')->nullable()->after('primary_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'clinic_name',
                'clinic_subtitle', 
                'clinic_description',
                'clinic_logo',
                'primary_color',
                'contact_info'
            ]);
        });
    }
};
