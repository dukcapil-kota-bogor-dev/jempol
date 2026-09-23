<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lsm extends Model
{
    use HasFactory;

    protected $table = 'lsm';

    protected $fillable = [
        'kecamatan',
        'kelurahan',
        'jumlah_sasaran',
        'tanggal_pelaksanaan',
        'terekam',
        'gagal_rekam',
        'sudah_memiliki_ktp',
        'tidak_hadir',
        'foto_1',
        'foto_2',
        'status_progress',
    ];
}
