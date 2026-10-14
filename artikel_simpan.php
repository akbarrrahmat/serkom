<?php
// 1. Mulai session dan hubungkan ke database
session_start();
include 'koneksi.php';

// 2. Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// 3. Cek apakah tombol simpan diklik dan metodenya POST
if (isset($_POST['simpan'])) {
    $judul   = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi     = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $tanggal = date('Y-m-d'); // Tanggal otomatis hari ini

    // 4. Konfigurasi Upload Gambar
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file  = $_FILES['gambar']['tmp_name'];
    
    // Ekstensi yang dibolehkan
    $ekstensi_dibolehkan = array('png', 'jpg', 'jpeg', 'webp');
    $x = explode('.', $nama_file);
    $ekstensi = strtolower(end($x));

    if (!empty($nama_file)) {
        if (in_array($ekstensi, $ekstensi_dibolehkan) === true) {
            // Beri nama unik agar tidak ada nama file kembar
            $nama_gambar_baru = uniqid() . '-' . $nama_file;
            $direktori = 'assets/images/artikel/';

            // Pindahkan file ke folder tujuan
            if (move_uploaded_file($tmp_file, $direktori . $nama_gambar_baru)) {
                
                // 5. Query Insert ke Database
                $query = "INSERT INTO artikel (judul, isi, gambar, tanggal) VALUES ('$judul', '$isi', '$nama_gambar_baru', '$tanggal')";
                $result = mysqli_query($koneksi, $query);

                if ($result) {
                    echo "<script>alert('Data kegiatan berhasil disimpan!'); window.location='dashboard.php';</script>";
                } else {
                    echo "<script>alert('Gagal menyimpan ke database!'); window.location='artikel_tambah.php';</script>";
                }

            } else {
                echo "<script>alert('Gagal mengunggah gambar ke folder!'); window.location='artikel_tambah.php';</script>";
            }
        } else {
            echo "<script>alert('Ekstensi gambar tidak diizinkan! (Gunakan jpg, jpeg, png, webp)'); window.location='artikel_tambah.php';</script>";
        }
    } else {
        echo "<script>alert('Silakan pilih gambar terlebih dahulu!'); window.location='artikel_tambah.php';</script>";
    }
} else {
    // Jika diakses secara langsung tanpa lewat tombol simpan, tendang balik
    header("Location: dashboard.php");
    exit;
}
?>