<?php
session_start();

// Hapus semua session siswa
if (isset($_SESSION['nisn'])) {
    unset($_SESSION['nisn']);
    unset($_SESSION['role']);
    unset($_SESSION['username']);
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
        document.location.href = 'index.php';  // Kembali ke halaman login siswa
    </script>
";
?>
