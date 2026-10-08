<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lsm', function (Blueprint $table) {
            $table->integer('kurang_dari_16_tahun')
                ->default(0)
                ->after('gagal_rekam');
        });
    }

    public function down(): void
    {
        Schema::table('lsm', function (Blueprint $table) {
            $table->dropColumn('kurang_dari_16_tahun');
        });
    }
};