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
        Schema::table('employee_client_schedules', function (Blueprint $table) {
            $table->boolean('enabled')->after('no_of_hours')->default(false);
            $table->boolean('repeat')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_client_schedules', function (Blueprint $table) {
            $table->boolean('enabled')->after('no_of_hours')->default(false);
            $table->boolean('repeat')->default(false);
        });
    }
};
