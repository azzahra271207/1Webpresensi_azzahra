<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'azzahra_presensi');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Gunakan md5 (atau lebih baik password_hash untuk keamanan lebih tinggi)

    // Query login
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Menambahkan hak akses berdasarkan 'hak_absen'
        $_SESSION['hak_absen'] = $user['hak_absen'];  // Menyimpan hak akses absen siswa

        // Atur ID unik untuk tiap role
        if ($user['role'] === 'admin') {
            $_SESSION['admin_id'] = $user['id']; // ID admin
            $_SESSION['login_success'] = "Login berhasil sebagai Admin!";
            header('Location: homeadmin.php');
        } elseif ($user['role'] === 'guru') {
            $_SESSION['guru_id'] = $user['id']; // ID guru
            $_SESSION['login_success'] = "Login berhasil sebagai Guru!";
            header('Location: homeguru.php');
        } elseif ($user['role'] === 'siswa') {
            $_SESSION['siswa_nisn'] = $user['siswa_nisn']; // NISN siswa
            // Pastikan hanya siswa dengan hak_absen 'teman' yang bisa login
            if ($_SESSION['hak_absen'] === 'teman') {
                $_SESSION['login_success'] = "Login berhasil sebagai Absensi!";
                header('Location: homeabsensi.php'); // Halaman untuk absen teman
            } else {
                echo "<script>alert('Anda tidak memiliki hak akses untuk absen sendiri.');</script>";
            }
        }
        exit;
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Style tetap sama, tidak ada perubahan */
    </style>
</head>
<body>

<?php
// Menampilkan notifikasi jika login berhasil
if (isset($_SESSION['login_success'])) {
    echo "<script>alert('" . $_SESSION['login_success'] . "');</script>";
    unset($_SESSION['login_success']); // Hapus notifikasi setelah ditampilkan
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    </style>
</head>
<body>
    <form method="POST">
        <h2>Login</h2>
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
