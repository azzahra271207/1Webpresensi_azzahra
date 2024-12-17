<?php
include 'koneksi.php';

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menangkap data yang diinputkan
    $nisn = $_POST['nisn'];
    $nama_siswa = $_POST['nama_siswa'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $alamat = $_POST['alamat'];

    // Menangani upload foto
    $foto = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto_tmp_name = $_FILES['foto']['tmp_name'];
        $foto_name = $_FILES['foto']['name'];
        $foto_target = 'uploads/' . basename($foto_name);
        move_uploaded_file($foto_tmp_name, $foto_target);
        $foto = $foto_target;
    }

    // Menyimpan data siswa ke database
    $stmt = $koneksi->prepare("INSERT INTO siswa (nisn, nama_siswa, kelas, jurusan, jeniskelamin, alamat, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nisn, $nama_siswa, $kelas, $jurusan, $jeniskelamin, $alamat, $foto);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data siswa berhasil ditambahkan!');
                document.location.href = 'siswa1.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan data siswa!');
              </script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .content {
            padding: 20px;
            max-width: 600px;
            margin: 50px auto;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }
        .form-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .form-container input,
        .form-container select,
        .form-container textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        .form-container button {
            background-color: #80B3D1;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
        }
        .form-container button:hover {
            background-color: #5A8FBF;
        }
        .btn-back {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            text-align: center;
            margin-top: 10px;
        }
        .btn-back:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="form-container">
            <h2>Tambah Siswa</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="nisn">NISN</label>
                <input type="text" id="nisn" name="nisn" required>

                <label for="nama_siswa">Nama Siswa</label>
                <input type="text" id="nama_siswa" name="nama_siswa" required>

                <label for="kelas">Kelas</label>
                <input type="text" id="kelas" name="kelas" required>

                <label for="jurusan">Jurusan</label>
                <input type="text" id="jurusan" name="jurusan" required>

                <label for="jeniskelamin">Jenis Kelamin</label>
                <select id="jeniskelamin" name="jeniskelamin" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>

                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" required></textarea>

                <label for="foto">Foto Siswa</label>
                <input type="file" id="foto" name="foto" accept="image/*">

                <button type="submit">Tambah Siswa</button>
            </form>
            <!-- Tombol Kembali -->
            <a href="siswa1.php" class="btn-back">Kembali</a>
        </div>
    </div>
</body>
</html>
