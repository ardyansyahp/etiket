<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';

    protected $connection = 'simmwt';

    protected $fillable = [
        'id_departemen',
        'username',
        'password',
        'nama_lengkap',
        'email',
        'plant',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'id_departemen');
    }
}
