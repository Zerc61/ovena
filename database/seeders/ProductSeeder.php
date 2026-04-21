<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['kategori_id'=>1,'nama_produk'=>'Sourdough Artisan','deskripsi'=>'Difermentasi 48 jam dengan starter alami. Tekstur renyah di luar, lembut berongga di dalam.','harga'=>45000,'stok'=>25,'url_gambar'=>'https://picsum.photos/seed/sourdoughbread/400/400.jpg','is_fragile'=>false,'umur_simpan'=>3],
            ['kategori_id'=>2,'nama_produk'=>'Butter Croissant','deskripsi'=>'Butter Prancis premium dengan 84 lapisan adonan. renyah dan berlapis sempurna.','harga'=>32000,'stok'=>30,'url_gambar'=>'https://picsum.photos/seed/buttercroissant/400/400.jpg','is_fragile'=>true,'umur_simpan'=>2],
            ['kategori_id'=>1,'nama_produk'=>'Baguette Prancis','deskripsi'=>'Roti batang klasik Prancis dengan kulit renyah dan crumb berongga.','harga'=>28000,'stok'=>20,'url_gambar'=>'https://picsum.photos/seed/baguettefrench/400/400.jpg','is_fragile'=>false,'umur_simpan'=>2],
            ['kategori_id'=>2,'nama_produk'=>'Cinnamon Roll','deskripsi'=>'Bolu gulung dengan filling kayu manis dan cream cheese frosting.','harga'=>35000,'stok'=>18,'url_gambar'=>'https://picsum.photos/seed/cinnamonroll99/400/400.jpg','is_fragile'=>true,'umur_simpan'=>3],
            ['kategori_id'=>1,'nama_produk'=>'Chocolate Babka','deskripsi'=>'Roti twisted dengan isian cokelat ganache lembut.','harga'=>48000,'stok'=>12,'url_gambar'=>'https://picsum.photos/seed/chocbabka/400/400.jpg','is_fragile'=>true,'umur_simpan'=>3],
            ['kategori_id'=>1,'nama_produk'=>'Brioche Toast','deskripsi'=>'Roti toast lembut dan buttery, cocok untuk sandwich.','harga'=>38000,'stok'=>22,'url_gambar'=>'https://picsum.photos/seed/briochetoast/400/400.jpg','is_fragile'=>false,'umur_simpan'=>4],
            ['kategori_id'=>3,'nama_produk'=>'Red Velvet Cake','deskripsi'=>'Kue lembut berwarna merah dengan cream cheese frosting. Ukuran 18cm.','harga'=>125000,'stok'=>8,'url_gambar'=>'https://picsum.photos/seed/redvelvetcake/400/400.jpg','is_fragile'=>true,'umur_simpan'=>3],
            ['kategori_id'=>3,'nama_produk'=>'Tiramisu Slice','deskripsi'=>'Slice tiramisu klasik dengan mascarpone dan kopi espresso.','harga'=>55000,'stok'=>15,'url_gambar'=>'https://picsum.photos/seed/tiramisuslice/400/400.jpg','is_fragile'=>true,'umur_simpan'=>2],
            ['kategori_id'=>4,'nama_produk'=>'Whole Wheat Bread','deskripsi'=>'Roti gandum utuh 100%, kaya serat dan nutrisi.','harga'=>32000,'stok'=>20,'url_gambar'=>'https://picsum.photos/seed/wheatbread/400/400.jpg','is_fragile'=>false,'umur_simpan'=>5],
            ['kategori_id'=>1,'nama_produk'=>'Focaccia Rosemary','deskripsi'=>'Roti Italia datar dengan rosemary dan olive oil.','harga'=>42000,'stok'=>14,'url_gambar'=>'https://picsum.photos/seed/focacciarose/400/400.jpg','is_fragile'=>false,'umur_simpan'=>3],
            ['kategori_id'=>2,'nama_produk'=>'Almond Croissant','deskripsi'=>'Croissant dengan filling almond frangipane dan taburan almond slice.','harga'=>38000,'stok'=>16,'url_gambar'=>'https://picsum.photos/seed/almondcroiss/400/400.jpg','is_fragile'=>true,'umur_simpan'=>2],
            ['kategori_id'=>5,'nama_produk'=>'Matcha Cookies','deskripsi'=>'Cookies matcha Jepang dengan choco chips. renyah di luar, chewy di dalam.','harga'=>28000,'stok'=>30,'url_gambar'=>'https://picsum.photos/seed/matchacookie/400/400.jpg','is_fragile'=>false,'umur_simpan'=>7],
            ['kategori_id'=>5,'nama_produk'=>'Chocolate Chip Cookies','deskripsi'=>'Klasik chocolate chip cookies dengan dark chocolate 70%.','harga'=>26000,'stok'=>35,'url_gambar'=>'https://picsum.photos/seed/chocchipcook/400/400.jpg','is_fragile'=>false,'umur_simpan'=>7],
            ['kategori_id'=>6,'nama_produk'=>'Hot Chocolate Blend','deskripsi'=>'Bubuk cokelat premium untuk hot chocolate. Isi 200g.','harga'=>35000,'stok'=>40,'url_gambar'=>'https://picsum.photos/seed/hotchocdrink/400/400.jpg','is_fragile'=>false,'umur_simpan'=>90],
            ['kategori_id'=>7,'nama_produk'=>'Hamper Natal Mini','deskripsi'=>'Paket hamper berisi 3 varian roti, cookies, dan hot chocolate blend.','harga'=>185000,'stok'=>10,'url_gambar'=>'https://picsum.photos/seed/hampermini/400/400.jpg','is_fragile'=>true,'umur_simpan'=>5],
            ['kategori_id'=>7,'nama_produk'=>'Paket Keluarga','deskripsi'=>'Paket berisi 5 roti pilihan untuk keluarga. hemat 15%.','harga'=>95000,'stok'=>15,'url_gambar'=>'https://picsum.photos/seed/familypack/400/400.jpg','is_fragile'=>true,'umur_simpan'=>3],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}