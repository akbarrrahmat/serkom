<?php
// 1. Panggil file koneksi database
include 'koneksi.php';

// 2. Konfigurasi Pagination (Jumlah data per halaman)
$batas = 5; // 5 artikel per halaman
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// Hitung total data dan total halaman
$sql_jumlah = "SELECT * FROM artikel";
$query_jumlah = mysqli_query($koneksi, $sql_jumlah);
$jumlah_data = mysqli_num_rows($query_jumlah);
$total_halaman = ceil($jumlah_data / $batas);

// Ambil data sesuai limit halaman
$query = "SELECT * FROM artikel ORDER BY id_artikel DESC LIMIT $halaman_awal, $batas";
$result = mysqli_query($koneksi, $query);
$nomor = $halaman_awal + 1;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Artikel Kegiatan - SMKN 1 Probolinggo</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <!-- Navbar Sederhana -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">SMKN 1 Probolinggo</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Beranda</a>
                <a class="nav-link" href="login.php">Login Admin</a>
            </div>
        </div>
    </nav>

    <!-- Konten Daftar Artikel -->
    <div class="container my-5">
        <h2 class="mb-4 fw-bold">Semua Daftar Artikel Kegiatan</h2>

        <div class="row">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="assets/images/artikel/<?php echo $row['gambar']; ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="Gambar">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?php echo $row['judul']; ?></h5>
                                <p class="card-text text-muted small"><?php echo substr($row['isi'], 0, 100); ?>...</p>
                                <a href="artikel_detail.php?id=<?php echo $row['id_artikel']; ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                            </div>
                            <div class="card-footer bg-white text-muted small">
                                Tanggal: <?php echo $row['tanggal']; ?>
                            </div>
                        </div>
                    </div>
            <?php 
                } 
            } else {
                echo '<div class="col-12"><div class="alert alert-warning">Belum ada artikel yang tersedia.</div></div>';
            }
            ?>
        </div>

        <!-- Navigasi Pagination -->
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <!-- Tombol Previous -->
                <li class="page-item <?php echo ($halaman <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?halaman=<?php echo $halaman - 1; ?>">Sebelumnya</a>
                </li>

                <!-- Nomor Halaman -->
                <?php for ($x = 1; $x <= $total_halaman; $x++) { ?>
                    <li class="page-item <?php echo ($halaman == $x) ? 'active' : ''; ?>">
                        <a class="page-link" href="?halaman=<?php echo $x; ?>"><?php echo $x; ?></a>
                    </li>
                <?php } ?>

                <!-- Tombol Next -->
                <li class="page-item <?php echo ($halaman >= $total_halaman) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?halaman=<?php echo $halaman + 1; ?>">Berikutnya</a>
                </li>
            </ul>
        </nav>
    </div>

</body>
</html>