<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoesToSchool extends Model
{
    protected $table = 'goes_to_schools';

    protected $fillable = [
        'nama_sekolah',
        'rencana_pelaksanaan',
        'jumlah_target',
        'kecamatan',
        'kelurahan',
        'tanggal_pelaksanaan',
        'terekam',
        'terekam_gagal',
        'kurang_dari_16_tahun',
        'sudah_punya',
        'tidak_hadir',
        'foto_1',
        'foto_2',
        'aktivasi_ikd',
        'status_progress',
    ];
}