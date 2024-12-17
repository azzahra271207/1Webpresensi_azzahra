<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        /* CSS */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        /* Kontainer Utama */
        .main-container {
            width: 90%; /* Atur lebar kontainer */
            max-width: 600px; /* Maksimal lebar */
            height: 300px; /* Tinggi tetap */
            margin: auto;
            padding: 20px;
            border: 1px solid #80B3D1;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .main-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .main-container p {
            font-size: 1.1em;
            color: #555;
            margin: 15px 0;
        }

        /* Footer */
        footer {
            background-color: #A7C7E7;
            color: #ffffff;
            text-align: center;
            padding: 10px 20px;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">Home</div>
    </div>

    <!-- Navigasi -->
    <div class="navbar">
        <a href="index.php" class="active">Home</a>
        <a href="login.php" class="active">Login Admin</a>
        <a href="login1.php" class="active">Login User</a>
    </div>

    <!-- Konten Utama -->
    <div class="main-container">
        <img src="asset/sekolah.jpeg" alt="sekolah">
        <p>LMS SMK CERIA 27</p>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 || Azzahra Nur Aulia
    </footer>
</body>
</html>
