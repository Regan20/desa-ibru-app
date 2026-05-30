<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'kode', 'nama', 'desa_id', 'wilayah', 'kategori',
        'hp', 'no_meter', 'email', 'pemakaian', 'status', 'user_id',
    ];

    protected $casts = [
        'pemakaian' => 'decimal:2',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Tarif per m3 mengikuti desa pelanggan. */
    public function tarif(): int
    {
        return $this->desa?->tarif_per_m3 ?? 3000;
    }
}
