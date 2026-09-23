<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('goes_to_schools', function (Blueprint $table) {
            $table->enum('status_ikd', [
                'sudah_aktivasi',
                'belum_aktivasi'
            ])->default('belum_aktivasi')->after('foto_2');
        });
    }

    public function down(): void
    {
        Schema::table('goes_to_schools', function (Blueprint $table) {
            $table->dropColumn('status_ikd');
        });
    }
};