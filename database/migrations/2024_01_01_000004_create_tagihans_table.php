<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->string('no_tagihan')->unique();         // TGH-241001
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->cascadeOnDelete();
            $table->string('periode');                      // Oktober 2024
            $table->decimal('pemakaian', 8, 2);             // m3
            $table->unsignedBigInteger('jumlah');           // total tagihan (Rp), dihitung pemakaian x tarif
            $table->string('jatuh_tempo');                  // 20 Okt 2024
            $table->string('status')->default('Belum Bayar'); // Belum Bayar / Lunas / Terlambat
            $table->string('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
