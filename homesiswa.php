<?php
session_start();

// Pastikan siswa sudah login, jika tidak, redirect ke halaman login
if (!isset($_SESSION['nisn'])) {
    echo "<script>
            alert('Silakan login sebagai siswa terlebih dahulu');
            window.location.href = 'login1.php';
          </script>";
    exit();
}

// Ambil data siswa berdasarkan NISN
include 'koneksi.php';
$nisn = $_SESSION['nisn'];
$query = "SELECT * FROM siswa WHERE nisn = '$nisn'";
$result = mysqli_query($koneksi, $query);
$siswa = mysqli_fetch_assoc($result);

// Jika data siswa tidak ditemukan
if (!$siswa) {
    echo "<script>
            alert('Data siswa tidak ditemukan!');
            window.location.href = 'login1.php';
          </script>";
    session_destroy();
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #A7C7E7;
            color: white;
            padding: 20px;
            font-size: 1.5em;
        }

        header h1 {
            margin: 0;
        }

        header a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            background-color: #80B3D1;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        header a:hover {
            background-color: #5A8FBF;
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            flex-wrap: wrap;
            flex: 1;
        }

        .box {
            background-color: #FFFFFF;
            border: 1px solid #80B3D1;
            border-radius: 10px;
            margin: 15px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.2s ease-in-out;
        }

        .box:hover {
            transform: scale(1.05);
        }

        .box h2 {
            color: #0288d1;
            font-size: 1.6em;
        }

        .box p {
            color: #555;
            margin: 15px 0;
            font-size: 1em;
        }

        .box button {
            background-color: #80B3D1;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1.1em;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .box button:hover {
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

<header>
    <h1>Dashboard Siswa - SMK Ceria</h1>
    <a href="logout1.php">Logout</a>
</header>

<div class="content">
    <div class="box">
        <h2>Absen</h2>
        <p>Isi absen Anda di sini.</p>
        <button onclick="window.location.href='absen.php'">Absen Sekarang</button>
    </div>

    <div class="box">
        <h2>Data Absen</h2>
        <p>Lihat data absen Anda.</p>
        <button onclick="window.location.href='data_absen.php'">Lihat Data Absen</button>
    </div>
</div>

<div class="footer">
        &copy; <?php echo date('Y'); ?> || @Azzahra Nur Aulia 
    </div>

</body>
</html>
