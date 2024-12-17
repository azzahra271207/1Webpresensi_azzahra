<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cek jika form disubmit
    if (isset($_POST['nisn']) && isset($_POST['status_kehadiran']) && isset($_POST['waktu']) && isset($_POST['tanggal'])) {
        $nisn = $_POST['nisn'];
        $status_kehadiran = $_POST['status_kehadiran'];
        $waktu = $_POST['waktu'];
        $tanggal = $_POST['tanggal'];

        // Masukkan data presensi ke database
        $query = "INSERT INTO presensi (NISN, Status_Kehadiran, Waktu, Tanggal) 
                VALUES ('$nisn', '$status_kehadiran', '$waktu', '$tanggal')";

        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Presensi berhasil ditambahkan!'); window.location.href = 'presensi3.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan presensi.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Presensi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .content {
            padding: 20px;
            margin-top: 20px;
            width: 100%;
            max-width: 1320px;
            margin-left: auto;
            margin-right: auto;
        }

        .content h2 {
            color: #1E3A8A;
            margin-bottom: 20px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        .form-container input[type="text"],
        .form-container input[type="date"],
        .form-container input[type="time"],
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-container button {
            background-color: #80B3D1;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .form-container button:hover {
            background-color: #5A8FBF;
        }
    </style>
</head>
<body>
<div class="content">
    <a href="presensi3.php" style="display: inline-block; margin-bottom: 20px; padding: 10px 20px; background-color: #A7C7E7; color: white; text-decoration: none; border-radius: 8px; font-size: 16px;">
    ⬅ Kembali
</a>
    <div class="content">
        <h2>Tambah Presensi</h2>
        <div class="form-container">
            <form method="POST" action="">
                <label for="nisn">NISN dan Nama:</label>
                <select name="nisn" required>
                    <option value="">Pilih NISN dan Nama</option>
                    <?php
                    // Ambil data siswa untuk pilihan NISN dan Nama
                    $querySiswa = "SELECT NISN, Nama_siswa FROM siswa"; // Pastikan tabel siswa memiliki kolom Nama_siswa
                    $resultSiswa = mysqli_query($koneksi, $querySiswa);

                    // Periksa apakah data siswa ada
                    if ($resultSiswa && mysqli_num_rows($resultSiswa) > 0) {
                        while ($row = mysqli_fetch_assoc($resultSiswa)) {
                            echo "<option value='" . $row['NISN'] . "'>" . $row['NISN'] . " - " . htmlspecialchars($row['Nama_siswa'], ENT_QUOTES, 'UTF-8') . "</option>";
                        }
                    } else {
                        echo "<option value=''>Data siswa tidak ditemukan</option>";
                    }
                    ?>
                </select>

                <label for="status_kehadiran">Status Kehadiran:</label>
                <select name="status_kehadiran" required>
                    <option value="">Pilih Status Kehadiran</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Izin">Izin</option>
                    <option value="Alfa">Alfa</option>
                </select>

                <label for="waktu">Waktu:</label>
                <input type="time" name="waktu" required>

                <label for="tanggal">Tanggal:</label>
                <input type="date" name="tanggal" required>

                <button type="submit">Tambah Presensi</button>
            </form>
        </div>
    </div>
</body>
</html>
