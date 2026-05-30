<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();               // IBR-2024-001 (ID Pelanggan)
            $table->string('nama');
            $table->foreignId('desa_id')->constrained('desas');
            $table->string('wilayah')->nullable();          // Dusun Tengah, dll
            $table->string('kategori')->default('Rumah Tangga'); // Rumah Tangga / Usaha Kecil
            $table->string('hp')->nullable();
            $table->string('no_meter')->nullable();         // dari form pendaftaran
            $table->string('email')->nullable();
            $table->decimal('pemakaian', 8, 2)->default(0); // m3 bulan ini
            $table->string('status')->default('Aktif');     // Aktif / Nonaktif / Tunggakan
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
