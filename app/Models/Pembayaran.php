<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'pelanggan_id', 'tagihan_id', 'jumlah', 'metode', 'status', 'bukti',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}
