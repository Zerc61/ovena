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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('nama_kurir', 100);
            $table->string('no_telp_kurir', 20)->nullable();
            $table->string('plat_kendaraan', 20)->nullable();
            $table->enum('status_pengantaran', ['persiapan', 'di jalan', 'terkirim'])->default('persiapan');
            $table->timestamp('waktu_berangkat')->nullable();
            $table->timestamp('waktu_sampai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
