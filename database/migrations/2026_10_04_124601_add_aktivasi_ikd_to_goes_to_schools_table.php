<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('goes_to_schools', function (Blueprint $table) {
            $table->integer('aktivasi_ikd')->default(0)->after('tidak_hadir');
        });
    }

    public function down(): void
    {
        Schema::table('goes_to_schools', function (Blueprint $table) {
            $table->dropColumn('aktivasi_ikd');
        });
    }
};