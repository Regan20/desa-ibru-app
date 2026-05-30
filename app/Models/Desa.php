<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $fillable = ['nama', 'tarif_per_m3'];

    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class);
    }
}
