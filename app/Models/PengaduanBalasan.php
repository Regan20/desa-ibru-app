<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaduanBalasan extends Model
{
    protected $fillable = ['pengaduan_id', 'isi', 'oleh'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
