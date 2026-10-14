# Dokumentasi Proyek Ujian Kompetensi Junior Web Programmer
**Nama Peserta:** Fikri Akbar Rahmat Ramadhan  
**Sekolah:** SMK Negeri Kabuh 
**Judul Aplikasi:** Portal Informasi Kegiatan / Web Berita Sekolah  

---

## 1. Deskripsi Proyek
Aplikasi web ini dikembangkan sebagai bentuk pemenuhan Uji Kompetensi Keahlian (UKK) / Sertifikasi Kompetensi Junior Web Programmer. Sistem ini dirancang untuk menampilkan informasi kegiatan dan berita sekolah kepada publik secara dinamis, serta dilengkapi dengan panel kontrol administrator (*dashboard*) yang aman untuk mengelola data artikel (CRUD: Create, Read, Update, Delete).

---

## 2. Struktur Direktori Folder (Project Structure)
Berikut adalah struktur folder utama dari aplikasi ini:
```text
project-web-jwp/
├── index.php             # Halaman utama publik (menampilkan artikel kegiatan)
├── login.php             # Halaman autentikasi login administrator
├── logout.php            # Proses keluar sesi (destroy session)
├── dashboard.php         # Halaman utama panel admin (manajemen data)
├── artikel_list.php      # Daftar artikel lengkap dengan sistem pagination
├── artikel_tambah.php    # Form untuk input artikel baru
├── artikel_simpan.php    # Proses penyimpanan data artikel dan upload gambar
├── artikel_hapus.php     # Proses penghapusan data artikel beserta file fisik gambar
├── artikel_detail.php    # Halaman baca selengkapnya untuk setiap artikel
├── koneksi.php           # Berkas penghubung ke database MySQL
├── config.php            # Pengaturan konfigurasi umum aplikasi
├── assets/
│   ├── css/
│   │   └── style.css     # Kustomisasi lembar gaya (CSS) utama
│   ├── js/
│   │   └── script.js     # Berkas interaksi dan validasi JavaScript
│   └── images/
│       └── artikel/      # Direktori penyimpanan file gambar artikel
├── library/
│   └── pagination.php    # Pustaka logika pengatur halaman (pagination)
├── docs/
│   └── dokumentasi.md    # Berkas dokumentasi kode program ini
└── database/
    └── db_portal.sql     # Berkas ekspor struktur dan data basis data MySQL

3.Fitur Utama Sistem
1.Autentikasi Administrator:Menggunakan Sistem sesi berbasis PHP(session)untuk memproteksi halaman dashboard agar tidak bisa diakses secara sembarangan tanpa login terlebih dahulu.
2.Manajemen Artikel(CRUD):
-Create & Upload: Admin dapat menambahkan judul, isi, dan mengunggah gambar pendukung kegiatan. Berkas gambar divalidasi ekstensinya dan disimpan secara aman ke dalam folder assets/images/artikel.
-Delete: Penghapusan data dari basis data juga otomatis membersihkan berkas gambar fisiknya dari direktori server menggunakan fungsi unlink().
3.Tampilan Publik Responsif: Halaman utama dirancang menggunakan kerangka kerja Bootstrap 5 agar nyaman diakses melalui berbagai ukuran layar perangkat, lengkap dengan bagian kontak informasi instansi.

4.Konfigurasi DataBase
-Nama Database: 07_miles
-Tabel Utama:
users(Menyimpan data akun administrator: id_users, username, password)
artikel (Menyimpan data informasi kegiatan: id_artikel, judul, isi, gambar, tanggal)