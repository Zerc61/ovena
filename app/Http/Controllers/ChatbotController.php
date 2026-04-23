<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function handleChat(Request $request)
    {
        $userMessage = $request->input('message');

        // 1. Ambil data produk untuk "disuapkan" ke AI
       $products = Product::select('id', 'nama_produk', 'harga', 'deskripsi')->take(20)->get();
        $katalog = json_encode($products);

        // 2. CARI BEST SELLER SUNGGUHAN (Agar Ovi tidak menebak-nebak)
        $bestSellerData = \App\Models\OrderDetail::select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(kuantitas) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->first();

        $infoBestSeller = "Belum ada data penjualan.";
        if ($bestSellerData) {
            $bestProduct = \App\Models\Product::find($bestSellerData->product_id);
            if ($bestProduct) {
                $infoBestSeller = "Kue paling laris (Best Seller) saat ini adalah: " . $bestProduct->nama_produk . " [PRODUK-" . $bestProduct->id . "].";
            }
        }

        // 3. SYSTEM PROMPT SUPER KETAT (Mencegah Ovi Ngelantur)
       // 3. SYSTEM PROMPT SUPER KETAT (Mencegah Ovi Ngelantur)
        $systemPrompt = "Kamu adalah Ovi, asisten customer service toko kue premium 'Ovena'.
        Gaya bahasamu ramah, elegan, dan sangat membantu.

        INFORMASI PENTING UNTUKMU:
        1. Katalog Produk: {$katalog}
        2. Status Best Seller: {$infoBestSeller}
        3. Cara Belanja di Ovena: 
           - Pilih kue yang diinginkan lalu klik tombol 'Masukkan ke Keranjang' (Masuk untuk Belanja).
           - Buka halaman Keranjang di pojok kanan atas.
           - Klik tombol 'Checkout'.
           - Isi data pengiriman dengan lengkap dan pilih metode pembayaran (Transfer Bank, E-Wallet, QRIS, atau Bayar di Tempat/COD).
           - Pesanan akan langsung diproses oleh sistem setelah pembayaran terkonfirmasi.

        ATURAN KERJA WAJIB (JANGAN DILANGGAR):
        - JANGAN PERNAH menyuruh pelanggan memesan lewat WhatsApp, Email, DM, atau telepon! Semua transaksi WAJIB dilakukan langsung di website ini.
        - BACA DESKRIPSI DENGAN TELITI! Jika pelanggan mencari rasa 'coklat', cari produk di katalog yang nama atau deskripsinya benar-benar mengandung kata coklat/choco. 
        - Jika pelanggan menanyakan kue terlaris/best seller/paling laku, WAJIB sebutkan produk yang tertera pada 'Status Best Seller' di atas.
        - WAJIB menyisipkan kode rahasia [PRODUK-id] pada setiap produk yang kamu rekomendasikan (Ganti 'id' dengan angka ID produknya). Contoh: [PRODUK-3].
        - Jawablah dengan bahasa manusia yang natural, luwes, dan rapi.";

        // ... (lanjutkan ke bagian pemanggilan API Groq di bawahnya seperti biasa) ...

        // 3. Panggil API Groq (Menggunakan model Llama 3)
        $apiKey = env('GROQ_API_KEY');
        $endpoint = "https://api.groq.com/openai/v1/chat/completions";

       try {
            // Tambahkan ->withoutVerifying() agar tidak error SSL di localhost
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post($endpoint, [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userMessage]
                ],
                'temperature' => 0.7
            ]);

            // Jika API Groq menolak (misal key salah)
            if ($response->failed()) {
                \Illuminate\Support\Facades\Log::error('Groq Error: ' . $response->body());
                return response()->json([
                    'status' => 'error',
                    'reply' => 'Aduh, sepertinya kunci API Ovi bermasalah. Coba cek log Laravel ya.'
                ]);
            }

            // Ambil teks balasan dari AI Groq
            $aiResponse = $response->json('choices.0.message.content');

            return response()->json([
                'status' => 'success',
                'reply' => $aiResponse
            ]);

        } catch (\Exception $e) {
            // Mencatat error asli ke file storage/logs/laravel.log agar mudah dilacak
            \Illuminate\Support\Facades\Log::error('Chatbot Error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'reply' => 'Maaf, sistem Ovi sedang merapikan rak kue. Silakan coba beberapa saat lagi ya! 😊'
            ]);
        }
    }

public function getProductCard($id)
    {
        $product = \App\Models\Product::find($id);
        if (!$product) return response()->json(['html' => '']);

        // Desain Kartu Mini: Gambar di kiri (kecil), teks di tengah, tombol di kanan
        $html = '
        <div style="display: flex; gap: 12px; background: rgba(26,14,8,0.6); border: 1px solid rgba(201,169,110,0.3); border-radius: 12px; margin-top: 12px; padding: 10px; align-items: center; animation: fadeIn 0.3s ease;">
            <img src="'.asset('storage/'.$product->url_gambar).'" style="width: 55px; height: 55px; object-fit: cover; border-radius: 8px; flex-shrink: 0; border: 1px solid rgba(201,169,110,0.2);">
            
            <div style="flex: 1;">
                <h5 style="margin: 0; font-size: 13px; color: var(--cream); font-weight: 700; line-height: 1.3;">'.$product->nama_produk.'</h5>
                <div style="color: var(--gold); font-weight: 700; font-size: 12px; margin: 4px 0;">Rp '.number_format($product->harga, 0, ',', '.').'</div>
            </div>
            
            <a href="'.route('products.show', $product->id).'" style="display: inline-block; background: var(--gold); color: #1a0e08; text-decoration: none; padding: 8px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; flex-shrink: 0; transition: transform 0.2s;" onmouseover="this.style.transform=\'scale(1.05)\'" onmouseout="this.style.transform=\'scale(1)\'">Lihat</a>
        </div>';

        return response()->json(['html' => $html]);
    }
}