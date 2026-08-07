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
        Schema::create('pemohons', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_input', ['kelurahan', 'non_kelurahan']);
            $table->string('no_pemohon')->nullable();
            $table->date('tanggal_permohonan')->nullable();
            $table->string('nik', 16)->nullable();;
            $table->string('nama_lengkap');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->enum('status_pemohon', ['lansia', 'sakit', 'ODGJ', 'disabilitas', 'lainnya']);
            $table->text('keterangan')->nullable();
            $table->date('tanggal_pelaksanaan')->nullable();
            $table->string('lokasi_perekaman')->nullable(); 
            $table->string('foto_1')->nullable();
            $table->string('foto_2')->nullable();
            $table->enum('status_progress', ['proses', 'selesai'])->default('proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemohons');
    }
};
