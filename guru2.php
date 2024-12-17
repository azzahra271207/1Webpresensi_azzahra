<?php
include 'koneksi.php';

// Logic for search functionality
$search_query = isset($_GET['search']) ? trim($_GET['search']) : "";

// Prepared Statement untuk keamanan
if ($search_query) {
    // Menggunakan LIKE pada NIP, Nama, dan Mata Pelajaran
    $stmt = $koneksi->prepare("SELECT * FROM guru WHERE nip LIKE ? OR nama LIKE ? OR mata_pelajaran LIKE ?");
    $like_query = "%{$search_query}%"; // Menambahkan wildcards untuk pencarian
    $stmt->bind_param("sss", $like_query, $like_query, $like_query);
} else {
    $stmt = $koneksi->prepare("SELECT * FROM guru"); // Menampilkan semua data guru jika tidak ada pencarian
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 100%;
            background-color: #A7C7E7;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .sidebar h2 {
            font-size: 24px;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
            padding-bottom: 10px;
            text-align: left;
        }

        .sidebar nav a {
            display: inline-block;
            text-decoration: none;
            color: #ffffff;
            background-color: #80B3D1;
            padding: 12px 20px;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            font-size: 16px;
        }

        .sidebar nav a:hover {
            background-color: #5A8FBF;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .content {
            padding: 20px;
            margin-top: 160px;
            max-width: 1320px;
            margin-left: auto;
            margin-right: auto;
        }

        .search-container {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .search-container button {
            background-color: #80B3D1;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        /* Card Container */
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        /* Styling for each Card */
        .card {
            background-color: #fff;
            width: 250px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            padding: 20px;
        }

        .card img {
            width: 100%;
            aspect-ratio: 2 / 3; /* Menyesuaikan rasio gambar 4x6 */
            object-fit: cover; /* Memastikan gambar sesuai dengan rasio */
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .card h3 {
            font-size: 18px;
            color: #1E3A8A;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
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
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Data Guru</h2>
        <nav>
        <a href="homeguru.php">Home Guru</a>
            <a href="guru2.php" class="active">Data Guru</a>
            <a href="presensi2.php">Kehadiran</a>
            <a href="siswa2.php">Data Siswa</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Data Guru</h2>
        <div class="search-container">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Cari NIP, Nama, atau Mata Pelajaran..." value="<?= htmlspecialchars($search_query) ?>">
                <button type="submit">Cari</button>
            </form>
        </div>

        <!-- Card Container for Guru -->
        <div class="card-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card">
                        <!-- Menambahkan gambar untuk guru -->
                        <img src="<?= htmlspecialchars($row['foto']) ?>" alt="Foto Guru">
                        <h3><?= htmlspecialchars($row['nama']) ?></h3>
                        <p><strong>NIP:</strong> <?= htmlspecialchars($row['nip']) ?></p>
                        <p><strong>Mata Pelajaran:</strong> <?= htmlspecialchars($row['mata_pelajaran']) ?></p>
                        <p><strong>Nomor HP:</strong> <?= htmlspecialchars($row['nomor_handphone']) ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Tidak ada data ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer">
        &copy; <?php echo date('Y'); ?> || @Azzahra Nur Aulia 
    </div>
</body>
</html> 
