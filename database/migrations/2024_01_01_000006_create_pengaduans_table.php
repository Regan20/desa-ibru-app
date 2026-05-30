<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();               // ADU-001
            $table->string('nama');
            $table->string('telp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('id_pelanggan')->nullable();     // contoh: IBR-2024-003 (boleh kosong utk tamu)
            $table->string('kategori');                     // Air Mati, Kebocoran Pipa, dll
            $table->text('deskripsi');
            $table->string('status')->default('Pending');   // Pending / Proses / Ditanggapi / Selesai
            $table->timestamps();
        });

        Schema::create('pengaduan_balasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduans')->cascadeOnDelete();
            $table->text('isi');
            $table->string('oleh')->default('Admin BUMDes'); // siapa yang membalas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan_balasans');
        Schema::dropIfExists('pengaduans');
    }
};
