<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel ini menggabungkan "Berita" (yang dikelola admin) dan
     * "Pengumuman" (yang tampil di sisi pengguna). Pengumuman = berita
     * yang status-nya "Dipublikasi" dan punya gambar.
     */
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori')->default('Info');    // Info / Pemeliharaan / Penting / Kegiatan
            $table->string('badge')->nullable();            // badge-red / badge-blue / badge-orange (untuk warna label)
            $table->string('sub')->nullable();              // sub-kategori, mis. "Pembayaran & Denda"
            $table->text('isi')->nullable();
            $table->string('gambar')->nullable();           // assets/ann-pemeliharaan.jpg
            $table->string('status')->default('Draft');     // Draft / Dipublikasi
            $table->unsignedInteger('views')->default(0);
            $table->string('tanggal')->nullable();          // teks tanggal tampil, mis. "Sabtu, 23 Oktober 2024"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
