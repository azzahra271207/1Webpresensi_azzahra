<?php
include 'koneksi.php';

// Mengecek apakah parameter NISN ada di URL
if (isset($_GET['NISN'])) {
    // Menyimpan NISN dari URL
    $nisn = $_GET['NISN'];

    // Query untuk menghapus data presensi berdasarkan NISN
    $query = "DELETE FROM presensi WHERE NISN = '$nisn'";

    // Mengeksekusi query
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, arahkan kembali ke halaman presensi
        echo "<script>alert('Data presensi berhasil dihapus!'); window.location.href = 'presensi2.php';</script>";
    } else {
        // Jika gagal, tampilkan pesan error
        echo "<script>alert('Gagal menghapus data presensi.'); window.location.href = 'presensi2.php';</script>";
    }
} else {
    // Jika NISN tidak ditemukan di URL
    echo "<script>alert('NISN tidak ditemukan.'); window.location.href = 'presensi2.php';</script>";
}

mysqli_close($koneksi);
?>
