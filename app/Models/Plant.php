<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $table = 'plant';

    protected $fillable = [
        'nama',
        'kota',
        'area',
        'kode_area',
        'nomor',
        'kode',
        'alamat',
    ];
}
