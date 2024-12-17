<?php
session_start();

// Periksa apakah ada session untuk role yang berbeda (admin, guru, siswa) dan hapus session yang sesuai
if (isset($_SESSION['admin_id'])) {
    // Jika admin, hapus session admin
    unset($_SESSION['admin_id']);
    unset($_SESSION['role']);
    unset($_SESSION['username']);
} elseif (isset($_SESSION['guru_id'])) {
    // Jika guru, hapus session guru
    unset($_SESSION['guru_id']);
    unset($_SESSION['role']);
    unset($_SESSION['username']);
} elseif (isset($_SESSION['siswa_nisn'])) {
    // Jika siswa, hapus session siswa
    unset($_SESSION['siswa_nisn']);
    unset($_SESSION['role']);
    unset($_SESSION['username']);
    unset($_SESSION['hak_absen']);  // Hapus hak akses absen (sendiri/teman)
}

// Hapus semua session lainnya dan menghancurkan session
session_unset();
session_destroy();

// Set header untuk mencegah browser menyimpan cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect ke halaman login setelah logout
echo "
    <script>
        alert('Anda berhasil logout');
        document.location.href = 'index.php';  // Halaman login
    </script>
";
?>
