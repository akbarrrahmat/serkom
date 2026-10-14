<?php
session_start();
include 'koneksi.php';

// Jika tombol login ditekan
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); 

    
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($koneksi, $query);

    
    if (mysqli_num_rows($result) === 1) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Administrator</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS Eksternal (Opsional kalau mau pakai gaya Neo-Brutalism juga) -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    
    <div class="container" style="max-width: 400px;">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="text-center mb-4 fw-bold">Login Admin</h3>
                
                <!--  jika login gagal -->
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger py-2 text-center small">Username atau Password salah!</div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control" required autocomplete="off" placeholder="Masukkan username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100 py-2 fw-bold">Login</button>
                </form>

                <div class="text-center mt-3">
                    <a href="index.php" class="text-decoration-none small text-muted">&larr; Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>