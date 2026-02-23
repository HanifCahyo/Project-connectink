<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nama',
        'kelas_id',
        'orang_tua_id'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function orang_tua()
    {
        return $this->belongsTo(OrangTua::class);
    }
}
