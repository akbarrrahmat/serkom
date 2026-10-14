<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Website Belajar Serkom</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons untuk ikon kontak -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- 1. NAVBAR ALA WEBSITE RESMI SEKOLAH -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #0d1b2a;">
        <div class="container py-2">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="index.php">
                <div class="bg-white text-danger rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 900;">
                    SMK
                </div>
                <div>
                    <span class="d-block lh-1" style="font-size: 0.75rem; letter-spacing: 1px;">SMK NEGERI KABUH</span>
                    <span class="fs-5 tracking-wide">JOMBANG</span>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active fw-semibold" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="artikel_list.php">Artikel</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a href="login.php" class="btn btn-warning text-dark fw-bold px-4 rounded-pill shadow-sm">Login Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 2. KONTEN UTAMA: DAFTAR ARTIKEL / KEGIATAN -->
    <div class="container my-5 flex-grow-1">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark border-bottom pb-2">Informasi & Kegiatan Terbaru</h2>
                <p class="text-light">Portal resmi publikasi kegiatan dan berita seputar lingkungan SMKN Kabuh.</p>
            </div>
        </div>

        <div class="row">
            <?php
            $query = "SELECT * FROM artikel ORDER BY id_artikel DESC LIMIT 6";
            $result = mysqli_query($koneksi, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="assets/images/artikel/<?php echo $row['gambar']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Gambar">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-dark"><?php echo $row['judul']; ?></h5>
                                <p class="card-text text-muted small flex-grow-1"><?php echo substr($row['isi'], 0, 90); ?>...</p>
                                <a href="artikel_detail.php?id=<?php echo $row['id_artikel']; ?>" class="btn btn-outline-dark btn-sm mt-3 w-100 fw-semibold">Baca Selengkapnya</a>
                            </div>
                            <div class="card-footer bg-white border-top-0 text-muted small">
                                <i class="bi bi-calendar3 me-1"></i> <?php echo $row['tanggal']; ?>
                            </div>
                        </div>
                    </div>
            <?php 
                } 
            } else {
                echo '<div class="col-12"><div class="alert alert-info">Belum ada artikel kegiatan yang dipublikasikan.</div></div>';
            }
            ?>
        </div>
    </div>

    <!-- 3. FOOTER WUJUD WEBSITE RESMI (INFO KONTAK & ALAMAT) -->
    <footer class="text-light pt-5 pb-3 mt-auto" style="background-color: #1a1a1a;">
        <div class="container">
            <div class="row gy-4">
                <!-- Kolom 1: Identitas & Deskripsi -->
                <div class="col-md-4">
                    <h5 class="fw-bold text-uppercase mb-3" style="letter-spacing: 0.5px;">SMKN Kabuh </h5>
                    <p class="text-light small">Nikmati cara mudah dan menyenangkan ketika update informasi sekolah hanya dalam genggaman.</p>
                </div>

                <!-- Kolom 2: Menu Navigasi Cepat -->
                <div class="col-md-4">
                    <h6 class="fw-bold text-uppercase mb-3" style="letter-spacing: 0.5px;">Menu Lainnya</h6>
                    <ul class="list-unstyled text-light small">
                        <li class="mb-2"><a href="index.php" class="text-decoration-none text-light">Beranda</a></li>
                        <li class="mb-2"><a href="artikel_list.php" class="text-decoration-none text-light">Artikel Kegiatan</a></li>
                        <li class="mb-2"><a href="login.php" class="text-decoration-none text-light">Panel Administrator</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Kontak & Alamat Lengkap -->
                <div class="col-md-4">
                    <h6 class="fw-bold text-uppercase mb-3" style="letter-spacing: 0.5px;">Hubungi Kami</h6>
                    <p class="text-light small mb-2">
                        <i class="bi bi-geo-alt-fill text-danger me-2"></i> Jl. Kabuh-Tapen No.101, Kabuh, Kec. Kabuh, Kota Jombang
                    </p>
                    <p class="text-light small mb-2">
                        <i class="bi bi-telephone-fill text-warning me-2"></i> (0335) 421185
                    </p>
                    <p class="text-light small">
                        <i class="bi bi-envelope-fill text-info me-2"></i> info@smknkabuh.sch.id
                    </p>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start text-light small">
                    SMKN kabuh &copy; 2026 | All rights reserved.
                </div>
                <div class="col-md-6 text-center text-md-end text-light small">
                    Web Developer by: <strong class="text-light">Fikri Akbar Rahmat Ramadhan</strong>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>