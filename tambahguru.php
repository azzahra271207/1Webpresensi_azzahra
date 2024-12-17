<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $mata_pelajaran = $_POST['mata_pelajaran'];
    $nomor_handphone = $_POST['nomor_handphone'];
    $foto = $_FILES['foto']; // Menangkap file foto yang diupload

    // Memproses file foto
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
        $foto_path = ''; // Jika tidak ada foto yang diupload
    }

    // Prepared statement untuk menambah data guru termasuk foto
    $stmt = $koneksi->prepare("INSERT INTO guru (NIP, Nama, Mata_Pelajaran, Nomor_Handphone, Foto) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nip, $nama, $mata_pelajaran, $nomor_handphone, $foto_path);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data guru berhasil ditambahkan');
                window.location.href = 'guru1.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menambahkan data guru');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Guru</title>
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

        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #333;
        }

        input[type="text"]:focus, input[type="file"]:focus {
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
    <h2>Tambah Guru</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="nip">NIP:</label>
        <input type="text" id="nip" name="nip" required><br>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required><br>

        <label for="mata_pelajaran">Mata Pelajaran:</label>
        <input type="text" id="mata_pelajaran" name="mata_pelajaran" required><br>

        <label for="nomor_handphone">Nomor Handphone:</label>
        <input type="text" id="nomor_handphone" name="nomor_handphone" required><br>

        <!-- Input for Foto -->
        <label for="foto">Foto Guru:</label>
        <input type="file" id="foto" name="foto"><br><br>

        <button type="submit">Tambah Guru</button>
    </form>

    <!-- Small Back Button -->
    <button class="back-btn" onclick="window.location.href='guru1.php'">Kembali</button>
</body>
</html>
