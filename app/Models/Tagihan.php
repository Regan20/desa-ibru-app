<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = [
        'no_tagihan', 'pelanggan_id', 'periode', 'pemakaian',
        'jumlah', 'jatuh_tempo', 'status', 'tanggal_bayar',
    ];

    protected $casts = [
        'pemakaian' => 'decimal:2',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
