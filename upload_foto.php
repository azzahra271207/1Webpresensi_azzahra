<?php
include 'koneksi.php'; // Hubungkan ke database

// Cek jika file foto di-upload
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    // Nama file foto dan direktori tujuan upload
    $foto = $_FILES['foto']['name'];
    $tmp_name = $_FILES['foto']['tmp_name'];
    $upload_dir = 'uploads/'; // Folder upload di server
    $upload_file = $upload_dir . basename($foto);

    // Cek apakah file bisa dipindahkan
    if (move_uploaded_file($tmp_name, $upload_file)) {
        // Ambil data NIP dari form atau URL (misalnya NIP guru)
        $nip = $_POST['nip'];

        // Query untuk memperbarui data foto di database
        $stmt = $koneksi->prepare("UPDATE guru SET foto = ? WHERE nip = ?");
        $stmt->bind_param("ss", $foto, $nip);
        if ($stmt->execute()) {
            echo "Foto berhasil diupload!";
        } else {
            echo "Terjadi kesalahan saat menyimpan data foto.";
        }
    } else {
        echo "Gagal mengupload foto.";
    }
} else {
    echo "Tidak ada foto yang dipilih.";
}
?>
