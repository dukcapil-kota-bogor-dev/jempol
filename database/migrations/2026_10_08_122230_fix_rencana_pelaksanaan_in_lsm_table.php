<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('lsm', 'rencana_pelaksanaan')) {
            Schema::table('lsm', function (Blueprint $table) {
                $table->date('rencana_pelaksanaan')
                    ->nullable()
                    ->after('jumlah_sasaran');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('lsm', 'rencana_pelaksanaan')) {
            Schema::table('lsm', function (Blueprint $table) {
                $table->dropColumn('rencana_pelaksanaan');
            });
        }
    }
};