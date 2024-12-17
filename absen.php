<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi ke database benar

// Ambil NISN dari session
$nisn = $_SESSION['nisn'];

// Ambil data siswa berdasarkan NISN
$query = "SELECT * FROM siswa WHERE nisn = '$nisn'";
$result = mysqli_query($koneksi, $query);
$siswa = mysqli_fetch_assoc($result);

// Cek apakah hari ini sudah ada presensi untuk siswa ini
$tanggal_hari_ini = date('Y-m-d');
$query_presensi = "SELECT * FROM presensi WHERE nisn = '$nisn' AND tanggal = '$tanggal_hari_ini'";
$result_presensi = mysqli_query($koneksi, $query_presensi);

// Variabel untuk notifikasi
$notifikasi = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil status presensi dari input form
    $status_presensi = $_POST['status'] ?? null;

    if (!$status_presensi) {
        $notifikasi = "Pilih salah satu status presensi.";
    } elseif (mysqli_num_rows($result_presensi) === 0) {
        // Tambahkan data presensi jika belum ada
        $query_insert_presensi = "INSERT INTO presensi (nisn, tanggal, status_kehadiran, waktu)
                                  VALUES ('$nisn', '$tanggal_hari_ini', '$status_presensi', CURTIME())";
        if (mysqli_query($koneksi, $query_insert_presensi)) {
            $notifikasi = "Presensi berhasil dicatat.";
            // Menggunakan JavaScript untuk menunda pengalihan
            echo "<script>
                    alert('$notifikasi');
                    window.location.href = 'data_absen.php';
                  </script>";
            exit();
        } else {
            $notifikasi = "Gagal mencatat presensi. Kesalahan: " . mysqli_error($koneksi);
        }
    } else {
        $notifikasi = "Presensi untuk hari ini sudah tercatat.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Siswa</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #0288d1;
        }

        p {
            font-size: 1em;
            color: #555;
        }

        .foto-siswa {
            display: block;
            margin: 20px auto;
            width: 120px;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0;
        }

        .checkbox-container {
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }

        .checkbox-container label {
            font-size: 1em;
            cursor: pointer;
        }

        button {
            background-color: #80B3D1;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }

        button:hover {
            background-color: #5A8FBF;
        }

        a {
            text-decoration: none;
            color: #0288d1;
            display: block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Selamat Datang, <?= htmlspecialchars($siswa['nama_siswa']); ?>!</h2>
        
        <!-- Menampilkan Foto Siswa di Tengah -->
        <?php if (!empty($siswa['foto'])): ?>
            <img src="<?= htmlspecialchars($siswa['foto']); ?>" alt="Foto Siswa" class="foto-siswa">
        <?php else: ?>
            <img src="default-profile.png" alt="Foto Default" class="foto-siswa">
        <?php endif; ?>

        <!-- Menampilkan Informasi Siswa di Tengah -->
        <p><strong>NISN:</strong> <?= htmlspecialchars($siswa['nisn']); ?></p>
        <p><strong>Kelas:</strong> <?= htmlspecialchars($siswa['kelas']); ?></p>
        <p><strong>Jurusan:</strong> <?= htmlspecialchars($siswa['jurusan']); ?></p>

        <!-- Form Presensi -->
        <form method="POST" action="">
            <label>Pilih Status Presensi:</label>
            <div class="checkbox-container">
                <label><input type="radio" name="status" value="Hadir" required> Hadir</label>
                <label><input type="radio" name="status" value="Sakit" required> Sakit</label>
                <label><input type="radio" name="status" value="Izin" required> Izin</label>
                <label><input type="radio" name="status" value="Alfa" required> Alfa</label>
            </div>
            <button type="submit">Kirim Presensi</button>
        </form>

        <a href="homesiswa.php">Kembali ke Dashboard</a>
    </div>
</body>
</html>
