<?php
session_start();

// Cek apakah pengguna memiliki hak akses untuk absen teman
if (!isset($_SESSION['hak_absen']) || $_SESSION['hak_absen'] !== 'teman') {
    echo "
        <script>
            alert('Anda tidak memiliki hak akses untuk absen teman!');
            document.location.href = 'login.php'; 
        </script>
    ";
    exit;
}

// Menampilkan notifikasi jika login berhasil
if (isset($_SESSION['login_success'])) {
    echo "<script>alert('" . $_SESSION['login_success'] . "');</script>";
    unset($_SESSION['login_success']); // Hapus pesan sukses setelah ditampilkan
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Absensi - Siswa</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .header {
            background-color: #A7C7E7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            color: white;
            font-size: 1.8em;
            font-weight: bold;
        }
        .header-left {
            padding-left: 20px;
        }
        .header-right {
            padding-right: 20px;
            font-size: 0.8em;
        }
        .header-right a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            background-color: #80B3D1;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .header-right a:hover {
            background-color: #5A8FBF;
        }

        /* Navigasi */
        .navbar {
            display: flex;
            justify-content: flex-start;
            background-color: #A7C7E7;
            padding: 10px 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #80B3D1;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 1em;
        }

        .navbar a:hover {
            background-color: #5A8FBF;
        }

        /* Main Content */
        .main-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #80B3D1;
            border-radius: 10px;
            background-color: white;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .main-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .btn-absen, .btn-edit, .btn-print {
            padding: 10px 20px;
            background-color: #80B3D1;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px;
        }

        .btn-absen:hover, .btn-edit:hover, .btn-print:hover {
            background-color: #5A8FBF;
        }

        .footer {
            background-color: #A7C7E7;
            text-align: center;
            color: white;
            padding: 15px 20px;
            font-size: 0.9em;
        }
        /* Footer */
        .footer {
            background-color: #A7C7E7;
            color: white;
            text-align: center;
            padding: 15px 20px;
            font-size: 0.9em;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .footer a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        // Fungsi untuk mencetak halaman
        function printPage() {
            window.print();
        }
        
    </script>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">Absensi Siswa</div>
        <div class="header-right">
            <a href="logout1.php">Logout</a>
        </div>
    </div>

    <!-- Navigasi -->
    <div class="navbar">
    <a href="homeabsensi.php" class="active">Home Absen</a>
        <a href="presensi3.php">Kehadiran</a>
            <a href="siswa3.php">Data Siswa</a>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <img src="asset/sekolah.jpeg" alt="sekolah">
        <h1>Selamat datang Di Web LMS SMK CERIA 27!</h1>
        <p>Ini adalah halaman utama absensi.</p>
        <p>Anda memiliki hak akses untuk melakukan absensi teman di sini.</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; <?php echo date('Y'); ?> || @Azzahra Nur Aulia 
    </div>
</body>
</html>
