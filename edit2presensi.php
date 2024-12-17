<?php
include 'koneksi.php';

// Pastikan parameter NISN tersedia dan valid
if (isset($_GET['NISN'])) {
    $nisn = $_GET['NISN'];

    // Query untuk mengambil data berdasarkan NISN dengan JOIN ke tabel siswa
    $query = "SELECT presensi.*, siswa.Nama_siswa, siswa.Kelas, siswa.Jurusan 
              FROM presensi 
              JOIN siswa ON presensi.NISN = siswa.NISN 
              WHERE presensi.NISN = '$nisn'";
    $result = mysqli_query($koneksi, $query);

    // Cek apakah query berhasil dan data ditemukan
    if (mysqli_num_rows($result) > 0) {
        // Ambil data hasil query
        $row = mysqli_fetch_assoc($result);
    } else {
        // Jika data tidak ditemukan
        die("Data tidak ditemukan untuk NISN: $nisn");
    }
} else {
    die("NISN tidak ditemukan di parameter URL");
}

// Proses update data ketika form disubmit
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nisn = $_POST['nisn'];
    $status_kehadiran = $_POST['status_kehadiran'];
    $waktu = $_POST['waktu'];
    $tanggal = $_POST['tanggal'];

    // Query untuk update data presensi
    $query = "UPDATE presensi SET 
              Status_Kehadiran = ?, 
              Waktu = ?, 
              Tanggal = ? 
              WHERE NISN = ?";

    // Persiapkan statement untuk mencegah SQL Injection
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $status_kehadiran, $waktu, $tanggal, $nisn);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Data presensi berhasil diperbarui');
                window.location.href = 'presensi2.php';
              </script>";
    } else {
        echo "<script>alert('Gagal memperbarui data presensi');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Presensi</title>
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

        input[type="text"], input[type="date"], input[type="time"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #333;
        }

        input[type="text"]:focus, input[type="date"]:focus, input[type="time"]:focus {
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
    <h2>Edit Data Presensi</h2>
    <form method="POST" action="">
        <label for="nisn">NISN:</label><br>
        <input type="text" id="nisn" name="nisn" value="<?= htmlspecialchars($row['nisn']) ?>" readonly><br><br>

        <label for="nama_siswa">Nama Siswa:</label><br>
        <input type="text" id="nama_siswa" name="nama_siswa" value="<?= htmlspecialchars($row['Nama_siswa']) ?>" readonly><br><br>

        <label for="kelas">Kelas:</label><br>
        <input type="text" id="kelas" name="kelas" value="<?= htmlspecialchars($row['Kelas']) ?>" readonly><br><br>

        <label for="jurusan">Jurusan:</label><br>
        <input type="text" id="jurusan" name="jurusan" value="<?= htmlspecialchars($row['Jurusan']) ?>" readonly><br><br>

        <label for="status_kehadiran">Status Kehadiran:</label><br>
        <select name="status_kehadiran" required>
            <option value="Hadir" <?= $row['status_kehadiran'] == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
            <option value="Sakit" <?= $row['status_kehadiran'] == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
            <option value="Izin" <?= $row['status_kehadiran'] == 'Izin' ? 'selected' : '' ?>>Izin</option>
            <option value="Alfa" <?= $row['status_kehadiran'] == 'Alfa' ? 'selected' : '' ?>>Alfa</option>
        </select><br><br>

        <label for="waktu">Waktu:</label><br>
        <input type="time" id="waktu" name="waktu" value="<?= htmlspecialchars($row['waktu']) ?>" required><br><br>

        <label for="tanggal">Tanggal:</label><br>
        <input type="date" id="tanggal" name="tanggal" value="<?= htmlspecialchars($row['tanggal']) ?>" required><br><br>

        <button type="submit" name="submit">Perbarui Presensi</button>
    </form>

    <!-- Small Back Button -->
    <button class="back-btn" onclick="window.location.href='presensi2.php'">Kembali</button>
</body>
</html>

