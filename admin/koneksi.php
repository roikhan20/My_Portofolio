<?php
$host = "localhost";
$user = "root";
$pass = "rijal123";
$db   = "portofolio";

$conn = mysqli_connect($host, $user, $pass, $db, $port = 3306);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error() . " | Error No: " . mysqli_connect_errno());
}


mysqli_set_charset($conn, "utf8mb4");
    