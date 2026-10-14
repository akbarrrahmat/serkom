<?php

session_start();
include 'koneksi.php';


if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}


if (isset($_POST['simpan'])) {
    $judul   = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi     = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $tanggal = date('Y-m-d'); 

    $nama_file = $_FILES['gambar']['name'];
    $tmp_file  = $_FILES['gambar']['tmp_name'];
    $ukuran_file = $_FILES['gambar']['size'];
    
    $ekstensi_dibolehkan = array('png', 'jpg', 'jpeg', 'webp');
    $x = explode('.', $nama_file);
    $ekstensi = strtolower(end($x));

    if (!empty($nama_file)) {
        if (in_array($ekstensi, $ekstensi_dibolehkan) === true) {
            
            $nama_gambar_baru = uniqid() . '-' . $nama_file;
            $direktori = 'assets/images/artikel/';

            
            if (move_uploaded_file($tmp_file, $direktori . $nama_gambar_baru)) {
                
                $query = "INSERT INTO artikel (judul, isi, gambar, tanggal) VALUES ('$judul', '$isi', '$nama_gambar_baru', '$tanggal')";
                $result = mysqli_query($koneksi, $query);

                if ($result) {
                    echo "<script>alert('Data kegiatan berhasil ditambahkan!'); window.location='dashboard.php';</script>";
                } else {
                    $error = "Gagal menyimpan ke database!";
                }
            } else {
                $error = "Gagal mengunggah gambar ke folder!";
            }
        } else {
            $error = "Ekstensi gambar tidak diizinkan! (Gunakan jpg, jpeg, png, atau webp)";
        }
    } else {
        $error = "Silakan pilih gambar terlebih dahulu!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kegiatan Baru - Administrator</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">Panel Admin</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="dashboard.php">Kembali ke Dashboard</a>
            </div>
        </div>
    </nav>

    <!-- Konten Form Tambah Artikel -->
    <div class="container my-5" style="max-width: 700px;">
        <div class="card shadow-sm border">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 fw-bold">Form Tambah Informasi Kegiatan</h4>
            </div>
            <div class="card-body p-4">

                <!-- Tampilkan pesan error jika ada kendala -->
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <!-- Form menggunakan enctype wajib untuk upload file/gambar -->
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Kegiatan</label>
                        <input type="text" name="judul" class="form-control" required autocomplete="off" placeholder="Masukkan judul kegiatan...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi / Deskripsi Kegiatan</label>
                        <textarea name="isi" class="form-control" rows="6" required placeholder="Tuliskan detail kegiatan di sini..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Unggah Gambar Kegiatan</label>
                        <input type="file" name="gambar" class="form-control" required>
                        <div class="form-text">Format yang didukung: JPG, JPEG, PNG, WEBP.</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="simpan" class="btn btn-primary fw-bold">Simpan Kegiatan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>
</html>