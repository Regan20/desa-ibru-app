<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'kode', 'nama', 'telp', 'alamat', 'id_pelanggan',
        'kategori', 'deskripsi', 'status',
    ];

    public function balasans()
    {
        return $this->hasMany(PengaduanBalasan::class);
    }
}
