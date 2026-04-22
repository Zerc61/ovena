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
        Schema::create('banners', function (Blueprint $table) {
    $table->id();
     $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
    $table->string('judul'); // Teks besar di hero
    $table->string('subjudul')->nullable(); // Teks kecil penjelas
    $table->string('gambar_url'); // Gambar background
    $table->boolean('is_active')->default(true); // Admin bisa mematikan promo tanpa menghapus
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
