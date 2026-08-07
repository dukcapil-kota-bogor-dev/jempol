<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemohon extends Model
{
    protected $fillable = [
        'jenis_input', 
        'no_pemohon', 
        'tanggal_permohonan', 
        'nik', 
        'nama_lengkap', 
        'kecamatan', 
        'kelurahan', 
        'rt', 
        'rw', 
        'status_pemohon', 
        'keterangan', // <--- Tambahkan ini agar data bisa disimpan
        'tanggal_pelaksanaan', 
        'lokasi_perekaman', 
        'foto_1', 
        'foto_2', 
        'status_progress'
    ];
}