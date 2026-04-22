<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
    $table->id();
    $table->string('kode_voucher')->unique(); // Contoh: DISKON50
    $table->enum('tipe', ['persen', 'nominal']); // Diskon persen (%) atau potongan harga tetap (Rp)
    $table->integer('nilai'); // Jika tipe 'persen' isi 10 (10%), jika 'nominal' isi 20000 (Rp20.000)
    $table->integer('min_belanja')->default(0); // Syarat minimal belanja
    $table->integer('kuota')->nullable(); // Maksimal orang yang bisa pakai (opsional)
    $table->date('berlaku_sampai')->nullable(); // Tenggat waktu voucher
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
