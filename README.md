## Location Picker Laravel 12

Aplikasi Laravel 12 yang memungkinkan pengguna mencari dan memilih lokasi menggunakan OpenStreetMap dan Leaflet.js. Aplikasi ini dilengkapi dengan fitur pencarian lokasi, dropdown hasil pencarian, serta deteksi lokasi terkini secara otomatis.

## 🚀 Fitur
- 🔍 **Pencarian Lokasi**: Pengguna dapat mencari lokasi berdasarkan nama tempat, alamat, atau koordinat.
- 📍 **Pemilihan Lokasi**: Hasil pencarian akan ditampilkan dalam dropdown, dan pengguna dapat memilih lokasi dari daftar.
- 🗺️ **Leaflet.js & OpenStreetMap**: Menggunakan OpenStreetMap sebagai peta utama dengan Leaflet.js untuk interaksi.
- 📡 **Deteksi Lokasi Terkini**: Saat halaman dimuat, peta akan otomatis menunjukkan lokasi pengguna berdasarkan geolokasi browser.
- 💾 **Simpan Lokasi**: Lokasi yang dipilih dapat disimpan dalam database Laravel.

## 📂 Instalasi
### 1️⃣ Clone Repository
```sh
git clone https://github.com/username/location-picker-laravel.git
cd location-picker-laravel
```

### 2️⃣ Instalasi Dependensi
```sh
composer install
npm install
```

### 3️⃣ Konfigurasi Environment
Duplikasi file `.env.example` dan ubah menjadi `.env`, kemudian sesuaikan konfigurasi database:
```sh
DB_DATABASE=teslokasi
DB_USERNAME=root
DB_PASSWORD=
```
Lalu jalankan migrasi database:
```sh
php artisan migrate
```

### 4️⃣ Menjalankan Aplikasi
Jalankan server backend Laravel:
```sh
php artisan serve
```
Jalankan frontend Vite:
```sh
npm run dev
```
Akses aplikasi di `http://127.0.0.1:8000`.

## 📜 Struktur Direktori
```
├── app/Http/Controllers/LocationController.php  # Controller untuk menangani lokasi
├── resources/views/location.blade.php          # Tampilan frontend
├── resources/js/components/MapComponent.vue    # Komponen Vue untuk peta
├── routes/web.php                              # Rute aplikasi
└── database/migrations/xxxx_xx_xx_create_locations_table.php # Migrasi database
```

## 🔧 Teknologi yang Digunakan
- Laravel 12
- Vue.js
- Leaflet.js
- OpenStreetMap
- Vite
- TailwindCSS

## 🎯 Cara Menggunakan
1. Buka aplikasi di browser.
2. Saat halaman dimuat, peta akan otomatis menampilkan lokasi terkini pengguna.
3. Ketikkan nama lokasi di kotak pencarian dan pilih dari dropdown yang muncul.
4. Klik pada peta untuk menandai lokasi secara manual.
5. Simpan lokasi untuk menyimpannya ke dalam database.

## 📌 Lisensi
Proyek ini menggunakan lisensi MIT. Silakan gunakan dan modifikasi sesuai kebutuhan.

---

Happy coding! 🚀
