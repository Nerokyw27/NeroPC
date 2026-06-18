# 🖥️ NeroPC - Custom PC Builder & E-Commerce

NeroPC adalah aplikasi web e-commerce interaktif yang dirancang khusus untuk merakit komputer (Custom PC Builder) dan berbelanja komponen komputer. Aplikasi ini dibuat sebagai proyek mata kuliah **Pemrograman Web (PWEB)**.

Dengan NeroPC, pengguna dapat merakit PC impian mereka dengan memilih komponen yang kompatibel, melihat estimasi harga secara langsung, dan menambahkannya ke keranjang untuk melakukan pemesanan. Admin juga disediakan dashboard khusus untuk mengelola katalog produk dan memproses transaksi.

---

## ✨ Fitur Utama

- **🖥️ Custom PC Builder:** Pilih komponen PC (Processor, Motherboard, RAM, VGA, Storage, PSU, Casing) langkah-demi-langkah dengan perhitungan harga total secara real-time.
- **🔍 Catalog & Live Search:** Telusuri produk berdasarkan kategori atau gunakan fitur pencarian langsung (*live search* berbasis AJAX).
- **🛒 Keranjang Belanja (Shopping Cart):** Simpan produk pilihan atau paket rakitan PC sebelum melanjutkan ke pembayaran.
- **💳 Checkout & Order History:** Lakukan pemesanan barang dan pantau riwayat transaksi yang pernah dilakukan.
- **👤 User Profile:** Kelola informasi profil pribadi pelanggan.
- **📊 Admin Dashboard:** Fitur khusus admin untuk mengelola katalog produk (CRUD), melihat statistik penjualan, serta memperbarui status transaksi pelanggan.

---

## 🛠️ Tech Stack

Aplikasi ini dibangun menggunakan teknologi modern:
- **Backend Framework:** [Laravel 13.x](https://laravel.com) (PHP 8.3+)
- **Frontend Build Tool:** [Vite](https://vitejs.dev)
- **Styling:** [Tailwind CSS v4.0](https://tailwindcss.com) (menggunakan `@tailwindcss/vite` plugin baru)
- **Database:** mySQL
- **Task Runner:** [Concurrently](https://github.com/open-cli-tools/concurrently) (menjalankan server Laravel, Vite, queue, dan logs secara bersamaan)

---

## 📋 Prasyarat Sistem

Sebelum menginstal, pastikan komputer Anda sudah memiliki:
1. **PHP >= 8.3** (pastikan ekstensi `pdo_sqlite` dan `sqlite3` aktif di file `php.ini` Anda)
2. **Composer** (untuk mengelola dependensi PHP/Laravel)
3. **Node.js** & **npm** (untuk mengelola dependensi JavaScript/Vite)

---

## ⚙️ Panduan Instalasi

Ikuti langkah-langkah di bawah ini untuk menginstal NeroPC di komputer lokal Anda:

### 1. Dapatkan Kode Sumber
Buka terminal/command prompt di direktori proyek ini.

### 2. Jalankan Script Setup Otomatis
Aplikasi ini sudah dilengkapi dengan script instalasi otomatis yang dikonfigurasi pada `composer.json`. Jalankan perintah berikut untuk menginstal dependensi PHP & JS, membuat file `.env`, generate key aplikasi, migrasi database SQLite, serta melakukan build file aset:

```bash
composer run setup
```

*Script di atas akan melakukan:*
- Instalasi dependensi PHP (`composer install`)
- Menyalin file `.env.example` menjadi `.env`
- Membuat kunci aplikasi (`php artisan key:generate`)
- Menjalankan migrasi database (`php artisan migrate --force`)
- Instalasi dependensi Node.js (`npm install`)
- Build file CSS & JS menggunakan Vite (`npm run build`)


### 3. Masukkan Data Awal (Database Seeding)
Untuk mengisi database dengan contoh produk komponen PC, prebuilt PC, serta akun demo, jalankan perintah seeder berikut:

```bash
php artisan db:seed
```

---

## 🚀 Menjalankan Aplikasi

Anda dapat menjalankan seluruh layanan aplikasi (Web Server, Vite Dev Server, Queue Listener, & Logger Pail) hanya dengan **satu perintah** berkat integrasi package `concurrently`:

```bash
composer run dev
```

Setelah menjalankan perintah tersebut, buka browser Anda dan akses:
- **Aplikasi Web:** [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Vite Dev Server:** Berjalan secara otomatis di latar belakang untuk hot-reloading halaman.

---

## 🔑 Akun Demo (Pre-seeded)

Untuk mempermudah pengujian, database telah diisi dengan dua akun demo berikut:

### 1. Akun Admin
Gunakan akun ini untuk masuk ke dashboard admin (`/admin/dashboard`) dan mengelola produk serta transaksi.
- **Email:** `admin@neropc.com`
- **Password:** `admin123`
- **Role:** Administrator

### 2. Akun Customer (Pelanggan)
Gunakan akun ini untuk mensimulasikan proses belanja, merakit PC, memasukkan barang ke keranjang, dan melakukan checkout.
- **Email:** `user@neropc.com`
- **Password:** `user123`
- **Role:** Customer (Budi Santoso)

---

## 📂 Struktur Folder Utama

- `app/Http/Controllers/` - Berisi logika aplikasi (PcController, PcBuilderController, CartController, dll).
- `database/migrations/` - Struktur skema database (users, products, carts, orders, order_items).
- `database/seeders/` - Pengisian data awal komponen PC dan akun uji coba (`ProductSeeder.php`).
- `resources/views/` - File tampilan visual aplikasi (Blade Templates).
- `routes/web.php` - Daftar rute halaman dan API yang tersedia di NeroPC.
- `vite.config.js` - Konfigurasi build tool Vite dengan integrasi Tailwind CSS v4.
