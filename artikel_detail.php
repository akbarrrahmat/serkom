<?php
include 'koneksi.php';

// 2. Cek apakah ada parameter 'id' yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data artikel berdasarkan ID tersebut
    $query = "SELECT * FROM artikel WHERE id_artikel = '$id'";
    $result = mysqli_query($koneksi, $query);

    // Jika data ditemukan, ambil datanya
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Jika data tidak ada di database, lempar kembali ke index
        header("Location: index.php");
        exit;
    }
} else {
    // Jika diakses tanpa parameter id, lempar kembali ke index
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $row['judul']; ?> - Portal Informasi Kegiatan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <!-- Navbar Website -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">SMKN Kabuh</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Beranda</a>
                <a class="nav-link" href="login.php">Login Admin</a>
            </div>
        </div>
    </nav>

    <!-- Konten Detail Artikel -->
    <div class="container my-5" style="max-width: 800px;">
        <div class="card shadow-sm border p-4 bg-white">
            
            <!-- Judul Kegiatan -->
            <h1 class="fw-bold mb-3"><?php echo $row['judul']; ?></h1>
            
            <!-- Tanggal Publikasi -->
            <p class="text-muted small mb-4">Dipublikasikan pada: <?php echo $row['tanggal']; ?></p>

            <!-- Gambar Utama Kegiatan (Ukuran Penuh) -->
            <div class="mb-4 text-center">
                <img src="assets/images/artikel/<?php echo $row['gambar']; ?>" class="img-fluid rounded shadow-sm w-100" style="max-height: 400px; object-fit: cover;" alt="Gambar Kegiatan">
            </div>

            <!-- Isi / Deskripsi Lengkap Artikel -->
            <div class="article-content text-secondary" style="line-height: 1.8; font-size: 1.1rem;">
                <!-- nl2br agar spasi atau enter di textarea admin terbaca rapi di web -->
                <p><?php echo nl2br($row['isi']); ?></p>
            </div>

            <hr class="my-4">

            <!-- Tombol Kembali -->
            <div>
                <a href="index.php" class="btn btn-dark px-4 py-2 rounded-pill fw-semibold shadow-sm">&larr; Kembali ke Beranda</a>
            </div>

        </div>
    </div>

</body>
</html>