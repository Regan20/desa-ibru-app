<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'judul', 'kategori', 'badge', 'sub', 'isi',
        'gambar', 'status', 'views', 'tanggal',
    ];

    /** Hanya berita yang sudah dipublikasi (tampil sebagai Pengumuman ke pengguna). */
    public function scopeDipublikasi($query)
    {
        return $query->where('status', 'Dipublikasi');
    }
}
