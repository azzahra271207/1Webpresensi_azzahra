<?php
include 'koneksi.php';

// Mengecek apakah parameter NISN ada di URL
if (isset($_GET['id'])) {
    // Menyimpan NISN dari URL
    $nisn = $_GET['id'];

    // Prepared statement untuk menghapus data siswa berdasarkan NISN
    $stmt = $koneksi->prepare("DELETE FROM siswa WHERE nisn = ?");
    $stmt->bind_param("s", $nisn); // Mengikat parameter NISN yang diterima

    // Mengeksekusi query
    if ($stmt->execute()) {
        echo "<script>
                alert('Data siswa berhasil dihapus');
                window.location.href = 'siswa1.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menghapus data siswa');</script>";
    }

    // Menutup prepared statement
    $stmt->close();
} else {
    // Jika NISN tidak ditemukan di URL
    echo "<script>alert('NISN tidak ditemukan.'); window.location.href = 'siswa1.php';</script>";
}

// Menutup koneksi ke database
mysqli_close($koneksi);
?>
