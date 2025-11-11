<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'departemen';

    protected $fillable = [
        'nama',
        'kode',
        'nomor',
    ];

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'id_departemen');
    }
}
