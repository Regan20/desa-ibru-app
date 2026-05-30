<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->nullOnDelete();
            $table->foreignId('tagihan_id')->nullable()->constrained('tagihans')->nullOnDelete();
            $table->unsignedBigInteger('jumlah');           // Rp
            $table->string('metode');                       // QRIS / Transfer BRI / Transfer Mandiri ...
            $table->string('status')->default('Menunggu');  // Menunggu / Diverifikasi / Ditolak
            $table->string('bukti')->nullable();            // path bukti transfer (opsional)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
