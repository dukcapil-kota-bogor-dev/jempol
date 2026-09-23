<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
         Schema::create('lsm', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->integer('jumlah_sasaran')->default(0);
            $table->date('tanggal_pelaksanaan')->nullable();
            $table->integer('terekam')->default(0);
            $table->integer('gagal_rekam')->default(0);
            $table->integer('sudah_memiliki_ktp')->default(0);
            $table->integer('tidak_hadir')->default(0);
            $table->string('foto_1')->nullable();
            $table->string('foto_2')->nullable();
            $table->enum('status_progress', ['proses','selesai'])->default('proses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lsm');
    }
};