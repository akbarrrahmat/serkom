<?php

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "07_miles";

$koneksi = mysqli_connect($host, $user, $pass, $db);

//cek
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>