<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $fillable = [
        'nama_lengkap',
        'no_peserta',
        'email',
        'no_hp',
        'status_kirim_email',
        'status_kirim_whatsapp',
    ];

    protected $casts = [
        'status_kirim_email' => 'boolean',
        'status_kirim_whatsapp' => 'boolean',
    ];

    public function absen()
    {
        return $this->hasMany(Absen::class, 'id_peserta');
    }
}
