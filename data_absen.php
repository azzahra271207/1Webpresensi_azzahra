<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi ke database benar

// Periksa apakah siswa sudah login
if (!isset($_SESSION['nisn'])) {
    header('Location: login1.php'); // Redirect ke halaman login jika belum login
    exit();
}

// Ambil NISN dari session
$nisn = $_SESSION['nisn'];

// Ambil data siswa berdasarkan NISN
$query = "SELECT * FROM siswa WHERE nisn = '$nisn'";
$result = mysqli_query($koneksi, $query);
$siswa = mysqli_fetch_assoc($result);

// Jika data siswa tidak ditemukan
if (!$siswa) {
    echo "<script>alert('Data siswa tidak ditemukan!');</script>";
    session_destroy();
    header('Location: login1.php');
    exit();
}

// Ambil data presensi siswa
$query_presensi = "SELECT * FROM presensi WHERE nisn = '$nisn' ORDER BY tanggal DESC";
$result_presensi = mysqli_query($koneksi, $query_presensi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Presensi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9; /* Warna biru muda lembut */
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #A7C7E7; /* Warna biru muda */
            padding: 20px;
            text-align: center;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #1E3A8A; /* Warna teks biru tua */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #A7C7E7; /* Warna biru muda */
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            display: inline-block;
            margin: 20px 0;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #80B3D1; /* Warna biru hover */
            color: white;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }

        a:hover {
            background-color: #5A8FBF; /* Warna hover lebih gelap */
        }

        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #A7C7E7;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        Riwayat Presensi Siswa
    </header>

    <div class="content">
        <h2>Riwayat Presensi - <?= htmlspecialchars($siswa['nama_siswa']); ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Status Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_presensi)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['tanggal']); ?></td>
                    <td><?= htmlspecialchars($row['status_kehadiran']); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="homesiswa.php">Kembali ke Dashboard</a>
    </div>

    <footer style="position: fixed; bottom: 0; width: 100%; background-color: #A7C7E7; color: white; text-align: center; padding: 10px;">
        © 2024 Azzahra Nur Aulia 
    </footer>
</body>
</html>
