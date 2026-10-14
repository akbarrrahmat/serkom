<?php

session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrator</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS Eksternal (Opsional, kalau pakai gaya Neo-Brutalism) -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">Halaman Admin - SMKN Kabuh</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text text-light me-3">
                    Halo, <strong><?php echo $_SESSION['admin']; ?></strong>
                </span>
                <a class="btn btn-danger btn-sm px-3" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama Dashboard -->
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="p-4 bg-white rounded shadow-sm border">
                    <h2>Selamat Datang di Dashboard Administrator</h2>
                    <p class="text-muted">Dari halaman ini, kamu bisa mengelola data informasi kegiatan sekolah, menambah artikel baru, atau menghapus data yang tidak diperlukan.</p>
                    <hr>
                    <!-- Tombol menuju form tambah artikel -->
                    <a href="artikel_tambah.php" class="btn btn-primary fw-bold">+ Tambah Kegiatan Baru</a>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Kegiatan untuk Admin -->
        <div class="card shadow-sm border">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Dikelola Data Kegiatan / Artikel</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Gambar</th>
                                <th width="25%">Judul Kegiatan</th>
                                <th width="35%">Isi Singkat</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Ambil data dari database
                            $no = 1;
                            $query = "SELECT * FROM artikel ORDER BY id_artikel DESC";
                            $result = mysqli_query($koneksi, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <img src="assets/images/artikel/<?php echo $row['gambar']; ?>" width="80" class="img-thumbnail" style="height: 60px; object-fit: cover;" alt="Foto">
                                        </td>
                                        <td class="fw-semibold"><?php echo $row['judul']; ?></td>
                                        <td><?php echo substr($row['isi'], 0, 100); ?>...</td>
                                        <td>
                                            <a href="artikel_hapus.php?id=<?php echo $row['id_artikel']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                        </td>
                                    </tr>
                            <?php 
                                } 
                            } else {
                                echo '<tr><td colspan="5" class="text-center text-muted py-3">Belum ada data kegiatan yang dimasukkan.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>