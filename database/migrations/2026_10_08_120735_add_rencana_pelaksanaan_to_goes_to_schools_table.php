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
        Schema::table('goes_to_schools', function (Blueprint $table) {
            $table->renameColumn(
                'jadwal_pelaksanaan',
                'rencana_pelaksanaan'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goes_to_schools', function (Blueprint $table) {
            $table->renameColumn(
                'rencana_pelaksanaan',
                'jadwal_pelaksanaan'
            );
        });
    }
};