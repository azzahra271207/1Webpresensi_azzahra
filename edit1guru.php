<?php
include 'koneksi.php';

$nip = $_GET['id']; // Ambil NIP dari URL

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $mata_pelajaran = $_POST['mata_pelajaran'];
    $nomor_handphone = $_POST['nomor_handphone'];
    $foto = $_FILES['foto']; // Mengambil file foto dari form
    
    // Memproses file foto yang diupload
    if ($foto['error'] == 0) {
        // Membuat nama file foto yang unik
        $foto_name = time() . "_" . basename($foto['name']);
        $target_dir = "uploads/"; // Folder tempat menyimpan foto
        $target_file = $target_dir . $foto_name;

        // Memindahkan file yang diupload ke folder tujuan
        if (move_uploaded_file($foto['tmp_name'], $target_file)) {
            $foto_path = $target_file; // Jika berhasil upload
        } else {
            $foto_path = ''; // Jika gagal upload
            echo "<script>alert('Gagal mengunggah foto.');</script>";
        }
    } else {
        // Jika foto tidak diubah, tetap menggunakan foto lama
        $foto_path = $_POST['foto_lama'];
    }

    // Prepared statement untuk update data guru
    $stmt = $koneksi->prepare("UPDATE guru SET Nama = ?, Mata_Pelajaran = ?, Nomor_Handphone = ?, Foto = ? WHERE NIP = ?");
    $stmt->bind_param("sssss", $nama, $mata_pelajaran, $nomor_handphone, $foto_path, $nip);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data guru berhasil diperbarui');
                window.location.href = 'guru1.php';
              </script>";
    } else {
        echo "<script>alert('Gagal memperbarui data guru');</script>";
    }
} else {
    // Ambil data guru berdasarkan NIP dari database
    $stmt = $koneksi->prepare("SELECT * FROM guru WHERE NIP = ?");
    $stmt->bind_param("s", $nip);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        $guru = $result->fetch_assoc();
    } else {
        echo "<script>alert('Data guru tidak ditemukan'); window.location.href = 'guru1.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guru</title>
    <style>
        /* General Body Style */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header Style */
        h2 {
            text-align: center;
            color: #1E3A8A;
            margin-top: 40px;
        }

        /* Form Styling */
        form {
            background-color: #ffffff;
            width: 50%;
            margin: 40px auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Input Fields */
        label {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #333;
        }

        input[type="text"]:focus {
            border-color: #A7C7E7;
            outline: none;
        }

        /* Submit Button Styling */
        button {
            width: 100%;
            padding: 12px;
            background-color: #A7C7E7;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #80B3D1;
        }

        /* Small Back Button Styling */
        .back-btn {
            width: auto;
            padding: 8px 16px;
            background-color: #D1D9E6;
            color: #1E3A8A;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .back-btn:hover {
            background-color: #BCC6D1;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            form {
                width: 80%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <h2>Edit Data Guru</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="nip">NIP:</label><br>
        <input type="text" id="nip" name="nip" value="<?= htmlspecialchars($guru['nip']) ?>" readonly><br><br>

        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($guru['nama']) ?>" required><br><br>

        <label for="mata_pelajaran">Mata Pelajaran:</label><br>
        <input type="text" id="mata_pelajaran" name="mata_pelajaran" value="<?= htmlspecialchars($guru['mata_pelajaran']) ?>" required><br><br>

        <label for="nomor_handphone">Nomor Handphone:</label><br>
        <input type="text" id="nomor_handphone" name="nomor_handphone" value="<?= htmlspecialchars($guru['nomor_handphone']) ?>" required><br><br>

        <!-- Menampilkan Foto Lama -->
        <label for="foto">Foto:</label><br>
        <?php if (!empty($guru['foto'])): ?>
            <img src="<?= htmlspecialchars($guru['foto']) ?>" alt="Foto Guru" style="width: 150px; height: auto; margin-bottom: 10px;">
        <?php endif; ?>
        <input type="file" id="foto" name="foto"><br><br>

        <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($guru['foto']) ?>"> <!-- Menyimpan foto lama jika tidak diubah -->
        
        <button type="submit">Perbarui Guru</button>
    </form>

    <!-- Small Back Button -->
    <button class="back-btn" onclick="window.location.href='guru1.php'">Kembali</button>
</body>
</html>
