<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query_select = "SELECT gambar FROM artikel WHERE id_artikel = '$id'";
    $result_select = mysqli_query($koneksi, $query_select);
    
    if (mysqli_num_rows($result_select) > 0) {
        $row = mysqli_fetch_assoc($result_select);
        $nama_gambar = $row['gambar'];
        $path_gambar = "assets/images/artikel/" . $nama_gambar;
        if (file_exists($path_gambar)) {
            unlink($path_gambar);
        }

        $query_delete = "DELETE FROM artikel WHERE id_artikel = '$id'";
        $result_delete = mysqli_query($koneksi, $query_delete);

        if ($result_delete) {
            echo "<script>alert('Data kegiatan berhasil dihapus!'); window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data dari database!'); window.location='dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location='dashboard.php';</script>";
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>