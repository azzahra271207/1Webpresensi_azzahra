<?php
include 'koneksi.php';

// Mendapatkan data NISN dari URL
$nisn = isset($_GET['id']) ? $_GET['id'] : '';

if (!$nisn) {
    echo "NISN tidak ditemukan!";
    exit;
}

// Mendapatkan data siswa berdasarkan NISN
$stmt = $koneksi->prepare("SELECT * FROM siswa WHERE nisn = ?");
$stmt->bind_param("s", $nisn);
$stmt->execute();
$result = $stmt->get_result();
$siswa = $result->fetch_assoc();

if (!$siswa) {
    echo "Data siswa tidak ditemukan!";
    exit;
}

// Update data siswa jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_siswa = $_POST['nama_siswa'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $alamat = $_POST['alamat'];

    // Periksa apakah file foto diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = 'uploads/' . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
    } else {
        $foto = $siswa['foto']; // Gunakan foto lama jika tidak ada yang diunggah
    }

    // Update query
    $stmt_update = $koneksi->prepare("UPDATE siswa SET nama_siswa = ?, kelas = ?, jurusan = ?, jeniskelamin = ?, alamat = ?, foto = ? WHERE nisn = ?");
    $stmt_update->bind_param("sssssss", $nama_siswa, $kelas, $jurusan, $jeniskelamin, $alamat, $foto, $nisn);
    
    if ($stmt_update->execute()) {
        echo "<script>alert('Data siswa berhasil diperbarui!'); window.location.href='siswa1.php';</script>";
    } else {
        echo "Gagal memperbarui data: " . $stmt_update->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }

        h2 {
            color: #1E3A8A;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        button {
            background-color: #80B3D1;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background-color: #5A8FBF;
        }

        .btn-back {
            text-decoration: none;
            background-color: #555;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            display: inline-block;
        }

        .btn-back:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <h2>Edit Data Siswa</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="nama_siswa">Nama Siswa</label>
        <input type="text" id="nama_siswa" name="nama_siswa" value="<?= htmlspecialchars($siswa['nama_siswa']) ?>" required>

        <label for="kelas">Kelas</label>
        <input type="text" id="kelas" name="kelas" value="<?= htmlspecialchars($siswa['kelas']) ?>" required>

        <label for="jurusan">Jurusan</label>
        <input type="text" id="jurusan" name="jurusan" value="<?= htmlspecialchars($siswa['jurusan']) ?>" required>

        <label for="jeniskelamin">Jenis Kelamin</label>
        <select id="jeniskelamin" name="jeniskelamin" required>
            <option value="Laki-Laki" <?= $siswa['jeniskelamin'] == 'Laki-Laki' ? 'selected' : '' ?>>Laki-Laki</option>
            <option value="Perempuan" <?= $siswa['jeniskelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
        </select>

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" required><?= htmlspecialchars($siswa['alamat']) ?></textarea>

        <label for="foto">Foto Siswa</label>
        <input type="file" id="foto" name="foto">
        <p>Foto saat ini:</p>
        <img src="<?= htmlspecialchars($siswa['foto']) ?>" alt="Foto Siswa" style="width: 150px; border-radius: 10px;">

        <button type="submit">Simpan</button>
        <a href="siswa1.php" class="btn-back">Kembali</a>
    </form>
</body>
</html>
