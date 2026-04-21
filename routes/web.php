<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// ── Guest ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Publik ──
Route::get('/', function() {
    return view('dashboard.index');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/produk/{product}', [ProductController::class, 'show'])->name('products.show');

// ── Auth required ──
Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/keranjang/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/keranjang/hapus', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/keranjang/kosongkan', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/pesanan/{order}/batalkan', [OrderController::class, 'cancelOrder'])->name('orders.cancel');

    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/simulate', [PaymentController::class, 'simulate'])->name('payment.simulate');

    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profil/password', [ProfileController::class, 'changePassword'])->name('profile.password');
});

// ── Admin ──
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/produk', [AdminController::class, 'products'])->name('products.index');
    Route::post('/produk', [AdminController::class, 'productStore'])->name('products.store');
    Route::put('/produk/{product}', [AdminController::class, 'productUpdate'])->name('products.update');
    Route::delete('/produk/{product}', [AdminController::class, 'productDelete'])->name('products.delete');

    Route::post('/kategori', [AdminController::class, 'categoryStore'])->name('categories.store');
    Route::delete('/kategori/{category}', [AdminController::class, 'categoryDelete'])->name('categories.delete');

    Route::get('/pesanan', [AdminController::class, 'orders'])->name('orders.index');
    Route::put('/pesanan/{order}/status', [AdminController::class, 'orderUpdateStatus'])->name('orders.update-status');

    Route::get('/pengiriman', [AdminController::class, 'deliveries'])->name('deliveries.index');
    Route::put('/pengiriman/{delivery}', [AdminController::class, 'deliveryUpdate'])->name('deliveries.update');
});