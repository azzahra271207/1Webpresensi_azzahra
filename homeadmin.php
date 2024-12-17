<?php
session_start();

// Cek apakah pengguna login sebagai admin
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    echo "
        <script>
            alert('Anda harus login sebagai admin!');
            document.location.href = 'login.php';
        </script>
    ";
    exit;
}
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
    <title>Home Admin</title>
    <style>
        /* CSS */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f4f4f9;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #A7C7E7; /* Warna biru muda */
            color: white;
            padding: 20px;
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
            background-color: #80B3D1; /* Biru muda */
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .header-right a:hover {
            background-color: #5A8FBF; /* Biru sedikit lebih gelap */
        }

        /* Navigasi */
        .navbar {
            display: flex;
            justify-content: flex-start;
            background-color: #A7C7E7; /* Biru muda */
            padding: 10px 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #80B3D1; /* Biru muda */
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 1em;
        }

        .navbar a:hover {
            background-color: #5A8FBF; /* Biru sedikit lebih gelap */
        }

        /* Kontainer utama */
        .main-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #80B3D1;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
            text-align: center;
        }

        .main-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .main-container h1 {
            font-size: 2em;
            color: #333;
        }

        .main-container p {
            font-size: 1.1em;
            color: #555;
            margin: 15px 0;
        }

        .main-container a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #80B3D1;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 1em;
        }

        .main-container a:hover {
            background-color: #5A8FBF;
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
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">Presensi Admin</div>
        <div class="header-right">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Navigasi -->
    <div class="navbar">
        <a href="homeadmin.php" class="active">Home Admin</a>
        <a href="guru1.php">Data Guru</a>
        <a href="presensi1.php">Data Presensi</a>
        <a href="siswa1.php">Data Siswa</a>
    </div>

    <!-- Konten Utama -->
    <div class="main-container">
        <img src="asset/sekolah.jpeg" alt="sekolah">
        <h1>Selamat datang Di Web Lms SMK CERIA 27!</h1>
        <p>Ini adalah halaman khusus Admin</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; <?php echo date('Y'); ?> || @Azzahra Nur Aulia 
    </div>
</body>
</html>
