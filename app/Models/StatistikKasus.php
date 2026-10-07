<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistikKasus extends Model
{
    protected $fillable = [
        'nama_dataset',
        'tahun',
        'kelompok_umur',
        'jenis_kelamin',
        'jenis_narkotika',
        'pekerjaan',
        'jumlah_kasus',
    ];
}
