<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
   public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect('/cart')->with('error', 'Keranjang kosong.');

        $totalBelanja = collect($cart)->sum(fn($item) => $item['harga'] * $item['qty']);
        $user = auth()->user();

        // Hitung Diskon dari Voucher (jika ada)
        $diskon = 0;
        $voucher = session()->get('voucher'); // <--- INI VARIABEL YANG DICARI BLADE
        
        if ($voucher) {
            if ($totalBelanja < $voucher->min_belanja) {
                session()->forget('voucher');
                $voucher = null;
            } else {
                if ($voucher->tipe === 'persen') {
                    $diskon = ($totalBelanja * $voucher->nilai) / 100;
                } else {
                    $diskon = $voucher->nilai;
                }
                if ($diskon > $totalBelanja) $diskon = $totalBelanja;
            }
        }

        $totalAkhir = $totalBelanja - $diskon;

        // PASTIKAN COMPACT MENGIRIMKAN SEMUA VARIABEL INI:
        return view('checkout.index', compact('cart', 'totalBelanja', 'diskon', 'totalAkhir', 'voucher', 'user'));
    }

    public function applyVoucher(Request $request)
    {
        $request->validate(['kode_voucher' => 'required|string']);
        $kode = strtoupper($request->kode_voucher);

        $voucher = Voucher::where('kode_voucher', $kode)->where('is_active', true)->first();

        if (!$voucher) return back()->with('error', 'Voucher tidak ditemukan atau tidak aktif.');
        
        if ($voucher->berlaku_sampai && Carbon::now()->startOfDay()->gt($voucher->berlaku_sampai)) {
            return back()->with('error', 'Voucher sudah kadaluarsa.');
        }
        
        if ($voucher->kuota !== null && $voucher->kuota <= 0) {
            return back()->with('error', 'Kuota voucher sudah habis digunakan.');
        }

        $cart = session()->get('cart', []);
        $totalBelanja = collect($cart)->sum(fn($item) => $item['harga'] * $item['qty']);

        if ($totalBelanja < $voucher->min_belanja) {
            return back()->with('error', 'Minimal belanja untuk menggunakan voucher ini adalah Rp ' . number_format($voucher->min_belanja, 0, '.', '.'));
        }

        session()->put('voucher', $voucher);
        return back()->with('success', 'Voucher berhasil diterapkan!');
    }

    public function removeVoucher()
    {
        session()->forget('voucher');
        return back()->with('success', 'Voucher dibatalkan.');
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect('/cart')->with('error', 'Keranjang kosong.');

        $validated = $request->validate([
            'nama_penerima'   => 'required|string|max:100',
            'no_telp_penerima'=> 'required|string|max:20',
            'alamat_pengiriman'=> 'required|string',
            'metode_pembayaran'=> 'required|in:transfer,ewallet,cod,qris',
            'catatan'          => 'nullable|string',
        ]);

        $totalBelanja = collect($cart)->sum(fn($item) => $item['harga'] * $item['qty']);
        
        // Kalkulasi ulang diskon untuk dimasukkan ke database (mencegah manipulasi)
        $diskon = 0;
        $voucher = session()->get('voucher');
        if ($voucher && $totalBelanja >= $voucher->min_belanja) {
            $diskon = $voucher->tipe === 'persen' ? ($totalBelanja * $voucher->nilai) / 100 : $voucher->nilai;
            if ($diskon > $totalBelanja) $diskon = $totalBelanja;
        }

        $totalAkhir = $totalBelanja - $diskon;

        $order = DB::transaction(function () use ($cart, $totalBelanja, $totalAkhir, $diskon, $voucher, $validated) {
            $order = Order::create([
                'user_id'           => auth()->id(),
                'total_harga'       => $totalAkhir, // Harga yang sudah dipotong diskon
                'status'            => 'pending',
                'nama_penerima'     => $validated['nama_penerima'],
                'no_telp_penerima'  => $validated['no_telp_penerima'],
                'alamat_pengiriman' => $validated['alamat_pengiriman'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'catatan'           => $validated['catatan'] ?? null,
                'voucher_id'        => $voucher ? $voucher->id : null,
                'potongan_diskon'   => $diskon,
            ]);

            foreach ($cart as $item) {
                OrderDetail::create([
                    'order_id'       => $order->id,
                    'product_id'     => $item['id'],
                    'kuantitas'      => $item['qty'],
                    'harga_satuan'   => $item['harga'],
                    'catatan_khusus' => $item['catatan'] ?? null,
                ]);

                // Kurangi stok
                \App\Models\Product::where('id', $item['id'])->decrement('stok', $item['qty']);
            }

            // Kurangi kuota voucher jika ada limitnya
            if ($voucher && $voucher->kuota !== null) {
                Voucher::where('id', $voucher->id)->decrement('kuota', 1);
            }

            return $order;
        });

        // Bersihkan session setelah sukses
        session()->forget('cart');
        session()->forget('voucher'); 

        return redirect()->route('payment.show', $order->id)
            ->with('success', 'Pesanan dibuat! Silakan selesaikan pembayaran.');
    }
}