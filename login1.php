<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi ke database sudah benar

// Cek jika siswa sudah login
if (isset($_SESSION['nisn'])) {
    header('Location: homesiswa.php'); // Redirect ke halaman home siswa
    exit();
}

// Jika halaman ini diakses setelah logout, beri notifikasi
if (isset($_GET['logout'])) {
    $message = "Anda telah berhasil logout. Silakan login kembali.";
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nisn = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Validasi NISN dan password di database
    $query = "SELECT * FROM users1 WHERE nisn = '$nisn' AND password = '$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        // Login berhasil, simpan NISN ke session
        $_SESSION['nisn'] = $nisn;

        // Redirect ke halaman home siswa
        echo "<script>
                alert('Login berhasil sebagai siswa');
                window.location.href = 'homesiswa.php';
              </script>";
        exit();
    } else {
        $error = "NISN atau password salah. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff; /* Mengubah latar belakang halaman menjadi putih */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #ffffff; /* Latar belakang putih untuk form */
            border: 1px solid #81d4fa; /* Biru muda */
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 25px 30px;
            width: 350px;
        }

        h2 {
            text-align: center;
            color: #0288d1; /* Biru gelap */
            font-size: 1.8em;
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
            color: #0288d1; /* Biru gelap */
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #b3e5fc; /* Biru muda terang */
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #0288d1; /* Biru gelap */
            outline: none;
        }

        button {
            background-color: #0288d1; /* Biru gelap */
            color: white;
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1.1em;
            display: block;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0277bd; /* Biru lebih gelap saat hover */
        }

        a {
            display: block;
            text-align: center;
            color: #0288d1;
            margin-top: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .message {
            color: green;
            text-align: center;
        }

        p {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <form method="POST" action="login1.php">
        <h2>Login Siswa</h2>
        <?php if (isset($error)): ?>
            <p><?= $error ?></p>
        <?php endif; ?>
        <?php if (isset($message)): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>
        <label for="nisn">NISN:</label><br>
        <input type="text" name="nisn" id="nisn" required><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
