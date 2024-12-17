<?php
// Koneksi ke database MySQL
$servername = "localhost";
$username = "root";  // Sesuaikan dengan username database Anda
$password = "";  // Sesuaikan dengan password database Anda
$dbname = "azzahra_presensi";  // Sesuaikan dengan nama database Anda

// Membuat koneksi
$koneksi = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>