<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Voucher; // ⬅️ Tambahkan ini di deretan atas (di bawah use App\Models\Banner;) 
use Illuminate\Support\Facades\DB;

class OvenaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kosongkan data sebelumnya agar tidak dobel (opsional tapi disarankan saat testing)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Banner::truncate();
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. SEEDER PRODUK (18 Produk dengan Deskripsi Premium)
        $products = [
            // --- KUE & CAKE (Kategori 3) ---
            [
                'kategori_id' => 3, 
                'nama_produk' => 'Fudgy Brownies Bite Premium',
                'deskripsi' => 'Nikmati sensasi cokelat pekat yang sesungguhnya dengan Fudgy Brownies Bite kami. Dipanggang dengan suhu presisi untuk menghasilkan tekstur permukaan yang retak sempurna, namun sangat padat, kenyal, dan lumer (fudgy) di bagian dalamnya. Terbuat dari dark chocolate couverture asal Belgia dan mentega premium murni. Sangat cocok disajikan hangat bersama secangkir kopi hitam di sore hari.',
                'harga' => 45000,
                'stok' => 20,
                'url_gambar' => 'products/1.png',
                'is_fragile' => false,
                'umur_simpan' => 7,
            ],
            [
                'kategori_id' => 3, 
                'nama_produk' => 'Vanilla Cloud Whole Cake',
                'deskripsi' => 'Sebuah mahakarya klasik untuk momen spesial Anda. Vanilla Cloud Whole Cake menawarkan tekstur bolu spons (sponge cake) super lembut yang meleleh di mulut, dilapisi dengan krim segar (fresh cream) vanilla Madagascar asli yang ringan dan tidak bikin eneg. Tampilannya yang elegan dan bersih membuatnya sempurna untuk perayaan ulang tahun, hari jadi, atau acara istimewa lainnya.',
                'harga' => 180000,
                'stok' => 5,
                'url_gambar' => 'products/2.png',
                'is_fragile' => true,
                'umur_simpan' => 3,
            ],
            [
                'kategori_id' => 3, 
                'nama_produk' => 'Dark Choco Fudge Slice',
                'deskripsi' => 'Bagi para pecinta cokelat sejati, ini adalah surga di setiap suapan. Dark Choco Fudge Slice memiliki lapisan kue cokelat super lembap (moist) yang diselingi dengan krim cokelat ganache tebal dan kaya rasa. Dilapisi lagi dengan siraman cokelat mengkilap (mirror glaze) di atasnya. Cokelatnya terasa pekat, elegan, dan menyeimbangkan rasa manis dengan sempurna.',
                'harga' => 35000,
                'stok' => 12,
                'url_gambar' => 'products/5 (1).png', // Jika namanya 5.png sesuaikan saja
                'is_fragile' => true,
                'umur_simpan' => 3,
            ],
            [
                'kategori_id' => 3, 
                'nama_produk' => 'Matcha Strawberry Bliss',
                'deskripsi' => 'Perpaduan Timur dan Barat yang memesona lidah. Kue bolu lembut ini dibuat dengan bubuk matcha premium langsung dari Uji, Kyoto, menghasilkan aroma teh hijau yang khas (earthy) dan elegan. Kesegaran potongan buah stroberi murni dan krim kocok putih salju menyeimbangkan rasa teh hijau, menciptakan harmoni manis, asam, dan gurih dalam satu potongan indah.',
                'harga' => 40000,
                'stok' => 10,
                'url_gambar' => 'products/6 (1).png',
                'is_fragile' => true,
                'umur_simpan' => 2,
            ],
            [
                'kategori_id' => 3, 
                'nama_produk' => 'Purple Taro Velvet Slice',
                'deskripsi' => 'Varian unik dari Red Velvet klasik! Kue ini menggunakan ekstrak talas (taro) asli yang memberikan warna ungu alami yang memanjakan mata serta rasa gurih manis yang khas. Setiap lapisannya disatukan oleh cream cheese frosting yang sedikit asam dan sangat *creamy*. Teman ngemil yang cantik untuk menemani me-time kamu.',
                'harga' => 32000,
                'stok' => 10,
                'url_gambar' => 'products/7 (1).png',
                'is_fragile' => true,
                'umur_simpan' => 3,
            ],
            [
                'kategori_id' => 3, 
                'nama_produk' => 'Blackforest Vanilla Layer',
                'deskripsi' => 'Interpretasi modern dari resep klasik asal Jerman. Kue spons cokelat yang disiram perlahan dengan sirup ceri, dipadukan dengan lapisan krim vanilla tebal dan taburan serpihan cokelat pekat di puncaknya. Teksturnya sangat moist dengan sentuhan rasa klasik yang akan langsung mengingatkan Anda pada memori masa kecil yang indah.',
                'harga' => 35000,
                'stok' => 15,
                'url_gambar' => 'products/8 (1).png',
                'is_fragile' => true,
                'umur_simpan' => 3,
            ],
            [
                'kategori_id' => 3, 
                'nama_produk' => 'New York Classic Cheesecake',
                'deskripsi' => 'Tidak ada yang bisa mengalahkan resep aslinya. Cheesecake bergaya New York ini sangat padat, kaya akan cream cheese premium, namun tetap terasa lumer saat menyentuh lidah. Dipanggang perlahan menggunakan teknik water-bath untuk memastikan permukaannya mulus tanpa retak. Disajikan di atas dasar biskuit graham yang buttery dan renyah.',
                'harga' => 45000,
                'stok' => 8,
                'url_gambar' => 'products/9 (1).png',
                'is_fragile' => true,
                'umur_simpan' => 4,
            ],
            [
                'kategori_id' => 3, 
                'nama_produk' => 'Choco Banana Loaf Bite',
                'deskripsi' => 'Kue pisang (banana bread) artisan yang dipanggang lambat hingga karamelisasi alami pisangnya keluar dengan sempurna. Ditaburi dengan choco chips melimpah dan irisan pisang asli di atasnya. Aromanya semerbak merenuhi ruangan saat dihangatkan. Teksturnya padat, mengenyangkan, namun tetap lembut.',
                'harga' => 22000,
                'stok' => 15,
                'url_gambar' => 'products/17.png',
                'is_fragile' => false,
                'umur_simpan' => 4,
            ],

            // --- PASTRY (Kategori 2) ---
            [
                'kategori_id' => 2, 
                'nama_produk' => 'Golden Butter Danish',
                'deskripsi' => 'Kue pastry khas Denmark yang dilipat berulang kali untuk menciptakan ratusan lapisan tipis yang luar biasa renyah. Menggunakan 100% mentega asli (pure butter) sehingga menghasilkan aroma susu yang wangi memikat. Saat digigit, teksturnya rapuh di luar namun bersarang indah dan kenyal di bagian tengah.',
                'harga' => 25000,
                'stok' => 15,
                'url_gambar' => 'products/3 (1).png',
                'is_fragile' => true,
                'umur_simpan' => 2,
            ],
            [
                'kategori_id' => 2, 
                'nama_produk' => 'Classic French Croissant',
                'deskripsi' => 'Simbol sejati dari keahlian memanggang artisan. Croissant bulan sabit kami dibuat dengan proses laminasi adonan dan mentega selama 3 hari lamanya. Hasilnya adalah pastry dengan lapisan luar yang *flaky* (garing beremah) dan bagian dalam berongga menyerupai sarang lebah (honeycomb) yang kenyal dan sangat *buttery*.',
                'harga' => 24000,
                'stok' => 20,
                'url_gambar' => 'products/18.png',
                'is_fragile' => true,
                'umur_simpan' => 2,
            ],

            // --- COOKIES (Kategori 5) ---
            [
                'kategori_id' => 5, 
                'nama_produk' => 'Red Velvet Crinkle Cookie',
                'deskripsi' => 'Kue kering gaya soft-baked dengan warna merah pekat nan menggoda. Bagian luarnya sedikit renyah dengan pola retak (crinkle) yang estetik, menyembunyikan tekstur bagian dalam yang super chewy layaknya brownies. Disempurnakan dengan white chocolate chips manis yang menyeimbangkan rasa kakao alami.',
                'harga' => 15000,
                'stok' => 30,
                'url_gambar' => 'products/10.png',
                'is_fragile' => true,
                'umur_simpan' => 14,
            ],
            [
                'kategori_id' => 5, 
                'nama_produk' => 'Double Choco Chip Cookie',
                'deskripsi' => 'Definisi kebahagiaan hakiki bagi pecinta cokelat. Adonan dasar kue ini sudah dicampur dengan bubuk kakao premium, kemudian diisi penuh dengan chocolate chips berukuran besar. Berikan sensasi hangat 10 detik di microwave sebelum dimakan, dan cokelatnya akan meleleh sempurna di mulut Anda.',
                'harga' => 16000,
                'stok' => 25,
                'url_gambar' => 'products/11.png',
                'is_fragile' => true,
                'umur_simpan' => 14,
            ],
            [
                'kategori_id' => 5, 
                'nama_produk' => 'Matcha Green Tea Cookie',
                'deskripsi' => 'Rasa autentik Jepang dalam bentuk kue kering. Kami menggunakan grade matcha tertinggi yang menjamin warna hijau cemerlang tanpa pewarna buatan, serta rasa yang elegan. Teksturnya padat, sedikit renyah di tepi, dengan sentuhan rasa unik yang sulit dilupakan.',
                'harga' => 16000,
                'stok' => 20,
                'url_gambar' => 'products/12.png',
                'is_fragile' => true,
                'umur_simpan' => 14,
            ],
            [
                'kategori_id' => 5, 
                'nama_produk' => 'Cookies & Cream White Choco',
                'deskripsi' => 'Dua pahlawan camilan disatukan! Adonan cookie vanilla yang lembut dicampur secara kasar dengan serpihan biskuit Oreo hitam pekat dan potongan white chocolate. Setiap gigitannya menawarkan kejutan tekstur renyah dari biskuit dan kelembutan dari cokelat putih.',
                'harga' => 17000,
                'stok' => 20,
                'url_gambar' => 'products/13.png',
                'is_fragile' => true,
                'umur_simpan' => 14,
            ],
            [
                'kategori_id' => 5, 
                'nama_produk' => 'Classic Golden Choco Chip',
                'deskripsi' => 'Resep kue kering rumahan yang tidak akan pernah lekang oleh waktu. Pinggiran kue yang garing berwarna keemasan, bertemu dengan bagian tengah yang kenyal (chewy). Semakin sempurna dengan taburan choco chips semi-sweet melimpah yang dipanggang hingga mengkaramelisasi.',
                'harga' => 15000,
                'stok' => 35,
                'url_gambar' => 'products/14.png',
                'is_fragile' => true,
                'umur_simpan' => 14,
            ],
            [
                'kategori_id' => 5, 
                'nama_produk' => 'Triple Choco Frosted Cookie',
                'deskripsi' => 'Cookies tingkat dewa! Soft cookie cokelat pekat berukuran besar yang dihias (frosted) tebal menggunakan ganache cokelat creamy di atasnya. Belum cukup? Kami taburi lagi dengan remahan biskuit dan meses warna-warni untuk sentuhan ceria. Super dekaden, super memuaskan.',
                'harga' => 20000,
                'stok' => 15,
                'url_gambar' => 'products/15.png',
                'is_fragile' => true,
                'umur_simpan' => 10,
            ],

            // --- ROTI KLASIK / ROTI SEHAT (Kategori 1 / 4) ---
            [
                'kategori_id' => 1, 
                'nama_produk' => 'Rustic Buttered Bread',
                'deskripsi' => 'Potongan roti gaya rumahan Eropa dengan pori-pori besar yang empuk. Kami menyajikannya sudah diolesi dengan lapisan mentega gurih (salted butter) premium. Cocok dimakan langsung atau dipanggang sebentar di teflon untuk sarapan super praktis dan lezat.',
                'harga' => 12000,
                'stok' => 20,
                'url_gambar' => 'products/16.png',
                'is_fragile' => false,
                'umur_simpan' => 3,
            ],
            [
                'kategori_id' => 4, // Roti Sehat
                'nama_produk' => 'Artisan Sourdough Loaf',
                'deskripsi' => 'Roti kebanggaan Ovena. Difermentasi menggunakan ragi alami (wild yeast/starter) selama 24-36 jam untuk menghasilkan rasa asam (tangy) yang kompleks dan manfaat prebiotik yang sangat baik untuk usus. Kulitnya tebal dan garing (crusty), dengan bagian dalam berpori besar yang kenyal dan empuk.',
                'harga' => 45000,
                'stok' => 10,
                'url_gambar' => 'products/19.png',
                'is_fragile' => false,
                'umur_simpan' => 5,
            ],
        ];

        // Menyimpan semua produk ke database dan menampung hasilnya
        $insertedProducts = [];
        foreach ($products as $product) {
            $insertedProducts[] = Product::create($product);
        }

        // 3. SEEDER BANNER (2 Banner Promo)
        $banners = [
            [
                'judul' => "Kelembutan yang \nSulit Dilupakan.",
                'subjudul' => 'Nikmati sensasi lumer di mulut dari Vanilla Cloud Cake terbaru kami. Pesan sekarang untuk momen spesialmu!',
                'gambar_url' => 'products/2.png', // Pastikan letakkan foto di storage/app/public/banners/promo1.png
                'is_active' => true,
                'product_id' => $insertedProducts[1]->id, // Mengarah ke Vanilla Cloud Whole Cake
            ],
            [
                'judul' => 'Promo Artisan Sourdough',
                'subjudul' => 'Lebih sehat, lebih lezat. Dapatkan Sourdough segar langsung dari oven setiap pagi.',
                'gambar_url' => 'products/19.png', // Pastikan letakkan foto di storage/app/public/banners/promo2.png
                'is_active' => true,
                'product_id' => $insertedProducts[17]->id, // Mengarah ke Artisan Sourdough Loaf
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }

        // 4. SEEDER VOUCHER PROMO
        $vouchers = [
            [
                'kode_voucher' => 'OVENABARU',
                'tipe' => 'persen',
                'nilai' => 15, // Diskon 15%
                'min_belanja' => 50000,
                'kuota' => null, // Tanpa batas kuota
                'berlaku_sampai' => null, // Berlaku selamanya
                'is_active' => true,
            ],
            [
                'kode_voucher' => 'MANIS20',
                'tipe' => 'nominal',
                'nilai' => 20000, // Potongan Rp 20.000
                'min_belanja' => 100000,
                'kuota' => 50, // Hanya untuk 50 pembeli pertama
                'berlaku_sampai' => \Carbon\Carbon::now()->addDays(30)->toDateString(), // Berlaku 30 hari ke depan
                'is_active' => true,
            ],
            [
                'kode_voucher' => 'PESTAKUE50',
                'tipe' => 'nominal',
                'nilai' => 50000, // Potongan besar Rp 50.000
                'min_belanja' => 250000, // Cocok untuk pembelian Hamper / Whole Cake
                'kuota' => 20, 
                'berlaku_sampai' => \Carbon\Carbon::now()->addDays(14)->toDateString(),
                'is_active' => true,
            ],
            [
                'kode_voucher' => 'FLASH10',
                'tipe' => 'persen',
                'nilai' => 10, // Diskon 10%
                'min_belanja' => 0, // Tanpa minimal belanja
                'kuota' => 100,
                'berlaku_sampai' => \Carbon\Carbon::now()->addDays(7)->toDateString(),
                'is_active' => true,
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::create($voucher);
        }
    }
}