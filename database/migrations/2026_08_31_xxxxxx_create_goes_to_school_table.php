<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goes_to_schools', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah');
            $table->string('jadwal_pelaksanaan')->nullable();
            $table->integer('jumlah_target')->default(0);
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->date('tanggal_pelaksanaan')->nullable();
            $table->integer('terekam')->default(0);
            $table->integer('terekam_gagal')->default(0);
            $table->integer('kurang_dari_16_tahun')->default(0);
            $table->integer('sudah_punya')->default(0);
            $table->integer('tidak_hadir')->default(0);
            $table->string('foto_1')->nullable();
            $table->string('foto_2')->nullable();
            $table->enum('status_ikd', ['sudah_aktivasi', 'belum_aktivasi'])->default('belum_aktivasi');
            $table->enum('status_progress', ['proses', 'selesai'])->default('proses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goes_to_schools');
    }
};