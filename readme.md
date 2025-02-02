Penerapan Metode WASPAS

## Deskripsi Proyek
Penerapan Metode WASPAS adalah sebuah sistem berbasis web yang digunakan untuk pemilihan alternatif terbaik berdasarkan metode Weighted Aggregated Sum Product Assessment (WASPAS). Sistem ini dikembangkan menggunakan PHP dan MySQL sebagai basis datanya.

## Fitur Utama
- **Manajemen Alternatif**: Menyimpan daftar alternatif yang akan dievaluasi.
- **Manajemen Kriteria**: Menyediakan kriteria penilaian dengan bobot yang dapat disesuaikan.
- **Matriks Keputusan**: Menampilkan nilai alternatif terhadap kriteria.
- **Normalisasi Data**: Proses normalisasi untuk WASPAS dengan perhitungan nilai maksimum dan minimum.
- **Perhitungan WASPAS**: Menghitung nilai akhir menggunakan kombinasi metode SAW dan WPM.
- **Laporan dan Hasil**: Menampilkan peringkat alternatif terbaik berdasarkan nilai akhir.

## Struktur Folder
```
- penerapan_metode_waspas/
  - db_metode_waspas.sql      # Database SQL untuk inisialisasi
  - index.php                 # Halaman utama web
  - admin/                    # Folder administrator
  - assets/                   # Berisi file konfigurasi dan aset statis
  - includes/                 # File PHP yang digunakan di beberapa halaman
  - laporan/                  # Laporan hasil perhitungan
```

## Instalasi
1. **Clone atau Ekstrak Proyek**
   ```sh
   git clone https://github.com/user/penerapan_metode_waspas.git
   ```
   atau ekstrak file zip ke dalam server lokal Anda.

2. **Impor Database**
   - Buka **phpMyAdmin** atau terminal MySQL.
   - Buat database baru, misalnya `db_metode_waspas`.
   - Impor file `db_metode_waspas.sql`.

3. **Konfigurasi Koneksi Database**
   - Buka `assets/conn/config.php`.
   - Sesuaikan pengaturan berikut:
     ```php
     $host = 'localhost';
     $user = 'root';
     $pass = '';
     $dbname = 'db_metode_waspas';
     ```

4. **Jalankan Aplikasi**
   - Pastikan server Apache & MySQL berjalan (XAMPP, Laragon, dll.).
   - Buka browser dan akses:
     ```
     http://localhost/penerapan_metode_waspas
     ```

## Teknologi yang Digunakan
- **Backend**: PHP (Native)
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Version Control**: Git



