<?php
include 'koneksi.php';

// Logic for search functionality
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $query = "SELECT presensi.*, siswa.* 
            FROM presensi 
            JOIN siswa ON presensi.NISN=siswa.NISN 
            WHERE (siswa.NISN LIKE '%$search_query%' 
            OR siswa.Nama_siswa LIKE '%$search_query%' 
            OR siswa.Kelas LIKE '%$search_query%') 
            AND siswa.Jurusan = 'PPLG'";  // Filter jurusan PPLG
} else {
    $query = "SELECT presensi.*, siswa.* 
            FROM presensi 
            JOIN siswa ON presensi.NISN = siswa.NISN 
            WHERE siswa.Jurusan = 'PPLG'"; // Filter jurusan PPLG
}

$result = mysqli_query($koneksi, $query);
$no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Presensi PPLG</title>
    <style>
        /* CSS */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

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

        .horizontal-line {
            width: 120%;
            border-bottom: 2px solid #ffffff;
            margin: 0 -10%;
            margin-bottom: 15px;
        }

        .sidebar nav {
            display: flex;
            gap: 10px;
            flex-direction: row;
            justify-content: flex-start;
            flex-wrap: wrap;
            width: 100%;
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
            text-align: center;
        }

        .sidebar nav a:hover {
            background-color: #5A8FBF;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .sidebar nav a.active {
            background-color: #4C7C9F;
            font-weight: bold;
        }

        .content {
            padding: 20px;
            margin-top: 160px;
            width: 100%;
            max-width: 1320px;
            margin-left: auto;
            margin-right: auto;
        }

        .content h2 {
            color: #1E3A8A;
            margin-bottom: 20px;
        }

        .search-container {
            margin-top: 20px;
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
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .search-container button:hover {
            background-color: #5A8FBF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #80B3D1;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .btn-edit, .btn-delete, .btn-view {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-edit {
            background-color: #4CAF50;
        }

        .btn-edit:hover {
            background-color: #45a049;
        }

        .btn-delete {
            background-color: #f44336;
        }

        .btn-delete:hover {
            background-color: #e53935;
        }

        .btn-view {
            background-color: #2196F3;
        }

        .btn-view:hover {
            background-color: #1976D2;
        }

        footer {
            background-color: #A7C7E7;
            color: #ffffff;
            text-align: center;
            padding: 10px 20px;
            margin-top: 20px;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
            bottom: 0;
            left: 0;
            width: 100%;
            font-size: 14px;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Kehadiran</h2>
        <div class="horizontal-line"></div>
        <nav>
        <a href="homeabsensi.php">Home Absen</a>
        <a href="presensi3.php">Kehadiran</a>
            <a href="siswa3.php">Data Siswa</a>
            <a href="cetak3presensi.php">Cetak</a>
        </nav>
    </div>

    <div class="content">
        <h2>Data Presensi Siswa Jurusan PPLG</h2>
        <a href="tambah3presensi.php">Tambah Presensi</a>
        <div class="search-container">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Cari NISN, Nama, atau Kelas..." value="<?= $search_query ?>">
                <button type="submit">Cari</button>
            </form>
        </div>

        <!-- Tabel Data Presensi -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>NISN</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Status Kehadiran</th>
                    <th>Waktu</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nama_siswa'] ?></td>
                        <td><?= $row['nisn'] ?></td>
                        <td><?= $row['kelas'] ?></td>
                        <td><?= $row['jurusan'] ?></td>
                        <td><?= $row['status_kehadiran'] ?></td>
                        <td><?= $row['waktu'] ?></td>
                        <td><?= $row['tanggal'] ?></td>
                        <td>
                            <a href="edit3presensi.php?NISN=<?= $row['nisn'] ?>" class="btn-edit">Edit</a>
                            <a href="hapus3presensi.php?NISN=<?= $row['nisn'] ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="9" style="text-align: center; font-size: 18px; color: #555;">Data tidak ditemukan</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 || Azzahra Nur Aulia
    </footer> 
</body>
</html>
