<?php
include 'koneksi.php';

$nip = $_GET['id'];

// Prepared statement untuk menghapus data guru berdasarkan NIP
$stmt = $koneksi->prepare("DELETE FROM guru WHERE NIP = ?");
$stmt->bind_param("s", $nip);

if ($stmt->execute()) {
    echo "<script>
            alert('Data guru berhasil dihapus');
            window.location.href = 'guru1.php';
          </script>";
} else {
    echo "<script>alert('Gagal menghapus data guru');</script>";
}
?>
