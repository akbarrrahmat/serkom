# PANDUAN MANUAL CODING WEBSITE PORTAL KEGIATAN SMKN 1 PROBOLINGGO
> **Lokasi Project:** `c:\xampp\htdocs\07_Miles`  
> **Teknologi:** PHP Native, MySQL (MariaDB), Bootstrap 5, Bootstrap Icons  
> **Developer:** Fikri Akbar Rahmat Ramadhan  

---

## DAFTAR ISI
1. [Pengenalan & Struktur Folder](#1-pengenalan--struktur-folder)
2. [Langkah 1: Pembuatan Database MySQL (`07_miles`)](#langkah-1-pembuatan-database-mysql-07_miles)
3. [Langkah 2: File Konfigurasi & Koneksi Database](#langkah-2-file-konfigurasi--koneksi-database)
4. [Langkah 3: Asset Styling Kustom](#langkah-3-asset-styling-kustom)
5. [Langkah 4: Sisi Pengunjung / Publik](#langkah-4-sisi-pengunjung--publik)
   - [4.1 Beranda Utama (`index.php`)](#41-beranda-utama-indexphp)
   - [4.2 Detail Berita (`artikel_detail.php`)](#42-detail-berita-artikel_detailphp)
   - [4.3 Katalog & Paginasi (`artikel_list.php`)](#43-katalog--paginasi-artikel_listphp)
6. [Langkah 5: Autentikasi Administrator](#langkah-5-autentikasi-administrator)
   - [5.1 Login Admin (`login.php`)](#51-login-admin-loginphp)
   - [5.2 Logout (`logout.php`)](#52-logout-logoutphp)
7. [Langkah 6: Panel Kontrol & Fitur CRUD Upload Foto](#langkah-6-panel-kontrol--fitur-crud-upload-foto)
   - [6.1 Dashboard Admin (`dashboard.php`)](#61-dashboard-admin-dashboardphp)
   - [6.2 Tambah Artikel & Upload Gambar (`artikel_tambah.php`)](#62-tambah-artikel--upload-gambar-artikel_tambahphp)
   - [6.3 Hapus Data & Berkas Fisik (`artikel_hapus.php`)](#63-hapus-data--berkas-fisik-artikel_hapusphp)
8. [Langkah 7: Cara Menjalankan & Pengujian](#langkah-7-cara-menjalankan--pengujian)

---

## 1. Pengenalan & Struktur Folder

Proyek website ini dibangun secara native (tanpa framework) dengan struktur modular yang rapi:

```text
07_Miles/
├── config.php                  # Variabel koneksi MySQL ($host, $user, $pass, $db)
├── koneksi.php                 # Eksekusi mysqli_connect()
├── index.php                   # Tampilan beranda & 6 informasi terbaru
├── artikel_list.php            # Daftar semua artikel dengan pagination
├── artikel_detail.php          # Halaman baca lengkap per artikel (?id=...)
├── login.php                   # Form login admin (verifikasi MD5)
├── dashboard.php               # Halaman utama admin berproteksi session
├── artikel_tambah.php          # Form upload gambar & tambah data
├── artikel_hapus.php           # Logika penghapusan database & file gambar
├── logout.php                  # Menghapus session admin
├── PANDUAN_CODING.md           # Modul dokumentasi ini
└── assets/
    ├── css/
    │   └── style.css           # Styling warna navbar dan tema
    └── images/
        └── artikel/            # Tempat penyimpanan gambar hasil upload
```

---

## Langkah 1: Pembuatan Database MySQL (`07_miles`)

Buka browser ke `http://localhost/phpmyadmin`, buat database bernama `07_miles`, lalu jalankan query SQL berikut:

```sql
CREATE DATABASE IF NOT EXISTS `07_miles`;
USE `07_miles`;

-- 1. Tabel users untuk otentikasi admin
CREATE TABLE `users` (
  `id_user` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Akun admin bawaan (Username: admin | Password: admin)
INSERT INTO `users` (`username`, `password`) VALUES
('admin', MD5('admin'));

-- 2. Tabel artikel untuk menampung postingan kegiatan sekolah
CREATE TABLE `artikel` (
  `id_artikel` INT(11) NOT NULL AUTO_INCREMENT,
  `judul` VARCHAR(255) NOT NULL,
  `isi` TEXT NOT NULL,
  `gambar` VARCHAR(255) NOT NULL,
  `tanggal` DATE NOT NULL,
  PRIMARY KEY (`id_artikel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## Langkah 2: File Konfigurasi & Koneksi Database

### `config.php`
Menyimpan parameter konfigurasi server database:
```php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "07_miles";
?>
```

### `koneksi.php`
Memanggil `config.php` dan melakukan inisialisasi koneksi MySQL:
```php
<?php
include 'config.php';

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
```

---

## Langkah 3: Asset Styling Kustom

### `assets/css/style.css`
Mengatur tema visual navbar dan interaksi kursor hover:
```css
.navbar {
    background-color: #581bc2 !important; 
    border-bottom: 3px solid #000000 !important; 
}

.navbar-brand, .navbar-nav .nav-link {
    color: #000000 !important;
    font-weight: bold;
}

.navbar-nav .nav-link:hover {
    color: #ffffff !important; 
}
```

---

## Langkah 4: Sisi Pengunjung / Publik

### 4.1 Beranda Utama (`index.php`)
- Memanggil `include 'koneksi.php';`
- Menampilkan navbar resmi sekolah dengan logo singkatan `SMK`.
- Menjalankan query 6 data kegiatan paling baru:
  ```php
  $query = "SELECT * FROM artikel ORDER BY id_artikel DESC LIMIT 6";
  $result = mysqli_query($koneksi, $query);
  ```
- Merender setiap postingan dalam bentuk Card Bootstrap dengan gambar cover dari `assets/images/artikel/`.
- Memotong teks isi deskripsi menjadi 90 karakter dengan `substr($row['isi'], 0, 90)`.
- Menyertakan footer resmi kontak SMKN 1 Probolinggo.

### 4.2 Detail Berita (`artikel_detail.php`)
- Menangkap parameter ID melalui URL: `$_GET['id']`.
- Memvalidasi keberadaan data di database: jika tidak ada, melempar kembali ke `index.php`.
- Menampilkan gambar utama resolusi penuh (`img-fluid`).
- Menggunakan fungsi `nl2br($row['isi'])` agar karakter baris baru (enter) dari form textarea admin terbaca rapi sebagai paragraf di HTML.

### 4.3 Katalog & Paginasi (`artikel_list.php`)
- Menentukan batas per halaman: `$batas = 5;`.
- Menghitung offset halaman awal: `$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;`.
- Menghitung total seluruh halaman: `$total_halaman = ceil($jumlah_data / $batas);`.
- Mengambil data menggunakan `LIMIT $halaman_awal, $batas`.
- Menampilkan tombol angka halaman Bootstrap di bagian bawah.

---

## Langkah 5: Autentikasi Administrator

### 5.1 Login Admin (`login.php`)
- Memulai sesi: `session_start();`.
- Menerima `$_POST['username']` dan mengenkripsi password dengan `md5($_POST['password'])`.
- Memeriksa ke tabel `users`:
  ```php
  $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
  ```
- Jika ditemukan 1 baris cocok (`mysqli_num_rows($result) === 1`):
  - Isi session: `$_SESSION['admin'] = $username;`
  - Redirect ke `dashboard.php`.
- Jika salah, munculkan notifikasi peringatan.

### 5.2 Logout (`logout.php`)
- Mengosongkan dan menghapus session:
  ```php
  session_start();
  $_SESSION = array();
  session_unset();
  session_destroy();
  header("Location: index.php");
  exit;
  ```

---

## Langkah 6: Panel Kontrol & Fitur CRUD Upload Foto

### 6.1 Dashboard Admin (`dashboard.php`)
- Memastikan pengunjung sudah login dengan mengecek `!isset($_SESSION['admin'])`.
- Menampilkan sambutan kepada admin yang aktif.
- Menampilkan tabel seluruh data artikel lengkap dengan thumbnail foto dan tombol **Hapus**.

### 6.2 Tambah Artikel & Upload Gambar (`artikel_tambah.php`)
- Form menggunakan atribut `enctype="multipart/form-data"` (wajib untuk input file).
- Mencegah SQL Injection dengan `mysqli_real_escape_string()`.
- Validasi ekstensi yang diizinkan: `['png', 'jpg', 'jpeg', 'webp']`.
- Mencegah nama file tertimpa atau bentrok dengan `uniqid()`:
  ```php
  $nama_gambar_baru = uniqid() . '-' . $nama_file;
  move_uploaded_file($tmp_file, 'assets/images/artikel/' . $nama_gambar_baru);
  ```
- Menyimpan record data ke tabel `artikel`.

### 6.3 Hapus Data & Berkas Fisik (`artikel_hapus.php`)
- Menangkap parameter `$_GET['id']`.
- Mencari nama file gambar dari database terlebih dahulu:
  ```php
  SELECT gambar FROM artikel WHERE id_artikel = '$id'
  ```
- Menghapus berkas fisik di folder server menggunakan `unlink($path_gambar)`.
- Menghapus record dari database menggunakan `DELETE FROM artikel WHERE id_artikel = '$id'`.

---

## Langkah 7: Cara Menjalankan & Pengujian

1. Nyalakan **Apache** & **MySQL** di XAMPP.
2. Akses halaman depan website:
   ```text
   http://localhost/07_Miles/index.php
   ```
3. Akses login admin:
   ```text
   http://localhost/07_Miles/login.php
   ```
   - **Username:** `admin`
   - **Password:** `admin`
4. Coba tambahkan kegiatan baru lengkap dengan foto kegiatan.
5. Periksa apakah foto tersimpan di `assets/images/artikel/` dan postingan muncul di halaman depan.

