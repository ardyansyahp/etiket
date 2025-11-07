<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'nama_lengkap',
        'nik',
        'tanggal_lahir',
        'tempat_lahir',
        'jabatan',
        'umur',
        'alamat',
        'email',
        'no_telp',
        'tanggal_masuk_kerja',
        'status_karyawan',
        'id_departemen',
        'id_plant',
    ];

    protected $casts = [
        'tanggal_lahir' => 'datetime',
        'tanggal_masuk_kerja' => 'datetime',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'id_departemen');
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'id_plant');
    }

    public function absen()
    {
        return $this->hasMany(Absen::class, 'id_karyawan');
    }
}
