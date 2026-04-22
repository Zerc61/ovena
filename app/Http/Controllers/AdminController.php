<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ── Dashboard ──
    public function dashboard()
    {
        $totalPenjualan = Order::where('status', 'selesai')->sum('total_harga');
        $totalPesanan = Order::count();
        $totalProduk = Product::count();
        $pendingOrders = Order::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalPenjualan', 'totalPesanan', 'totalProduk', 'pendingOrders'));
    }

    // ── Produk ──
    public function products()
    {
        $products = Product::with('category')->latest()->paginate(10);
        $categories = Category::all();
        return view('admin.products.index', compact('products', 'categories'));
    }

   public function productStore(Request $request)
{
    $validated = $request->validate([
        'nama_produk'   => 'required|string|max:150',
        'kategori_id'   => 'required|exists:categories,id',
        'deskripsi'     => 'nullable|string',
        'harga'         => 'required|integer|min:0',
        'stok'          => 'required|integer|min:0',
        'url_gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'is_fragile'    => 'boolean',
        'umur_simpan'   => 'nullable|integer|min:1',
    ]);

    $validated['is_fragile'] = $request->has('is_fragile');

    if ($request->hasFile('url_gambar')) {
        $validated['url_gambar'] = $request->file('url_gambar')
            ->store('products', 'public');
    }

    Product::create($validated);
    return back()->with('success', 'Produk berhasil ditambahkan.');
}

public function productUpdate(Request $request, Product $product)
{
    $validated = $request->validate([
        'nama_produk'   => 'required|string|max:150',
        'kategori_id'   => 'required|exists:categories,id',
        'deskripsi'     => 'nullable|string',
        'harga'         => 'required|integer|min:0',
        'stok'          => 'required|integer|min:0',
        'url_gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'is_fragile'    => 'boolean',
        'umur_simpan'   => 'nullable|integer|min:1',
    ]);

    $validated['is_fragile'] = $request->has('is_fragile');

    if ($request->hasFile('url_gambar')) {
        if ($product->url_gambar && Storage::disk('public')->exists($product->url_gambar)) {
            Storage::disk('public')->delete($product->url_gambar);
        }
        $validated['url_gambar'] = $request->file('url_gambar')
            ->store('products', 'public');
    }

    $product->update($validated);
    return back()->with('success', 'Produk berhasil diperbarui.');
}

    public function productDelete(Product $product)
    {
        if ($product->url_gambar && Storage::disk('public')->exists($product->url_gambar)) {
            Storage::disk('public')->delete($product->url_gambar);
        }
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    // ── Pesanan ──
    public function orders()
    {
        $orders = Order::with(['user', 'details.product', 'delivery'])
            ->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function orderUpdateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,dibayar,diproses,dikirim,selesai',
        ]);
        $order->update($validated);

        // Jika status dikirim, buat delivery record
        if ($validated['status'] === 'dikirim' && !$order->delivery) {
            $request->validate([
                'nama_kurir'      => 'required|string|max:100',
                'no_telp_kurir'    => 'nullable|string|max:20',
                'plat_kendaraan'   => 'nullable|string|max:20',
            ]);
            Delivery::create([
                'order_id'       => $order->id,
                'nama_kurir'     => $request->nama_kurir,
                'no_telp_kurir'   => $request->no_telp_kurir,
                'plat_kendaraan'  => $request->plat_kendaraan,
                'status_pengantaran' => 'di jalan',
                'waktu_berangkat' => now(),
            ]);
        }

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    // ── Pengiriman ──
    public function deliveries()
    {
        $deliveries = Delivery::with(['order.user', 'order.details.product'])
            ->whereHas('order', fn($q) => $q->whereIn('status', ['dikirim', 'selesai']))
            ->latest()->paginate(15);
        return view('admin.deliveries.index', compact('deliveries'));
    }

    public function deliveryUpdate(Request $request, Delivery $delivery)
    {
        $validated = $request->validate([
            'status_pengantaran' => 'required|in:persiapan,di jalan,terkirim',
        ]);

        $data = $validated;
        if ($validated['status_pengantaran'] === 'terkirim') {
            $data['waktu_sampai'] = now();
            $delivery->order->update(['status' => 'selesai']);
        }

        $delivery->update($data);
        return back()->with('success', 'Status pengantaran diperbarui.');
    }

    // ── Kategori ──
    public function categoryStore(Request $request)
    {
        $validated = $request->validate(['nama_kategori' => 'required|string|max:50|unique:categories']);
        Category::create($validated);
        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function categoryDelete(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    // ── Banners / Hero ──
  // ── Banners / Hero ──
    public function banners()
    {
        $banners = \App\Models\Banner::latest()->paginate(10);
        // Ambil data produk untuk ditampilkan di dropdown pilihan banner
        $products = \App\Models\Product::select('id', 'nama_produk')->get(); 
        
        return view('admin.banners.index', compact('banners', 'products'));
    }

    public function bannerStore(Request $request)
    {
        $validated = $request->validate([
            'judul'      => 'required|string|max:255',
            'subjudul'   => 'nullable|string|max:255',
            'gambar_url' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product_id' => 'nullable|exists:products,id', // <-- Tambahkan ini
            'is_active'  => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['gambar_url'] = $request->file('gambar_url')->store('banners', 'public');

        \App\Models\Banner::create($validated);
        return back()->with('success', 'Banner berhasil ditambahkan.');
    }

    public function bannerUpdate(Request $request, \App\Models\Banner $banner)
    {
        $validated = $request->validate([
            'judul'      => 'required|string|max:255',
            'subjudul'   => 'nullable|string|max:255',
            'gambar_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product_id' => 'nullable|exists:products,id', // <-- Tambahkan ini
            'is_active'  => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('gambar_url')) {
            if ($banner->gambar_url && Storage::disk('public')->exists($banner->gambar_url)) {
                Storage::disk('public')->delete($banner->gambar_url);
            }
            $validated['gambar_url'] = $request->file('gambar_url')->store('banners', 'public');
        }

        $banner->update($validated);
        return back()->with('success', 'Banner berhasil diperbarui.');
    }

    public function bannerDelete(\App\Models\Banner $banner)
    {
        if ($banner->gambar_url && Storage::disk('public')->exists($banner->gambar_url)) {
            Storage::disk('public')->delete($banner->gambar_url);
        }
        $banner->delete();
        return back()->with('success', 'Banner berhasil dihapus.');
    }

    // ── Vouchers ──
    public function vouchers()
    {
        $vouchers = \App\Models\Voucher::latest()->paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function voucherStore(Request $request)
    {
        $validated = $request->validate([
            'kode_voucher'   => 'required|string|max:50|unique:vouchers',
            'tipe'           => 'required|in:persen,nominal',
            'nilai'          => 'required|integer|min:1',
            'min_belanja'    => 'required|integer|min:0',
            'kuota'          => 'nullable|integer|min:1',
            'berlaku_sampai' => 'nullable|date',
            'is_active'      => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['kode_voucher'] = strtoupper($validated['kode_voucher']); // Pastikan kode selalu huruf besar

        \App\Models\Voucher::create($validated);
        return back()->with('success', 'Voucher berhasil ditambahkan.');
    }

    public function voucherUpdate(Request $request, \App\Models\Voucher $voucher)
    {
        $validated = $request->validate([
            'kode_voucher'   => 'required|string|max:50|unique:vouchers,kode_voucher,'.$voucher->id,
            'tipe'           => 'required|in:persen,nominal',
            'nilai'          => 'required|integer|min:1',
            'min_belanja'    => 'required|integer|min:0',
            'kuota'          => 'nullable|integer|min:1',
            'berlaku_sampai' => 'nullable|date',
            'is_active'      => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['kode_voucher'] = strtoupper($validated['kode_voucher']);

        $voucher->update($validated);
        return back()->with('success', 'Voucher berhasil diperbarui.');
    }

    public function voucherDelete(\App\Models\Voucher $voucher)
    {
        $voucher->delete();
        return back()->with('success', 'Voucher berhasil dihapus.');
    }
}