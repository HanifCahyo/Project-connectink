<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas'
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function gurus()
    {
        return $this->HasMany(Guru::class);
    }
}
