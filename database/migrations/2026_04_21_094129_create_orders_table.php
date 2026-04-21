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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('tanggal_order')->useCurrent();
            $table->integer('total_harga');
            $table->enum('status', ['pending', 'dibayar', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('pending');
            $table->string('alamat_pengiriman');
            $table->string('no_telp_penerima');
            $table->string('nama_penerima');
            $table->enum('metode_pembayaran', ['transfer', 'ewallet', 'cod', 'qris'])->default('transfer');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
