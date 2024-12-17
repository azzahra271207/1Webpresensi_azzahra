<?php
include 'koneksi.php';

// Logic for search functionality
$search_query = isset($_GET['search']) ? trim($_GET['search']) : "";

// Prepared Statement untuk keamanan
if ($search_query) {
    $stmt = $koneksi->prepare("SELECT * FROM siswa WHERE nisn LIKE ? OR nama_siswa LIKE ? OR kelas LIKE ? OR jurusan LIKE ?");
    $like_query = "%{$search_query}%";
    $stmt->bind_param("ssss", $like_query, $like_query, $like_query, $like_query);
} else {
    $stmt = $koneksi->prepare("SELECT * FROM siswa");
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #A7C7E7;
            color: #ffffff;
        }

        .search-container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin: 20px 0;
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 8px;
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

        .back-button {
            background-color: #80B3D1;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #649AB0;
        }
    </style>
    <script>
        function printTable() {
            const printContent = document.querySelector('.tb').outerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(`
                <html>
                <head>
                    <title>Print Data Siswa</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                        th { background-color: #A7C7E7; color: #ffffff; }
                    </style>
                </head>
                <body>
                <h1>Data Siswa</h1>
                    ${printContent}
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</head>
<body>
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Cari NISN, Nama, Kelas atau Jurusan" value="<?= htmlspecialchars($search_query) ?>">
            <button type="submit">Cari</button>
            <button type="button" onclick="printTable()">Print</button>
        </form>
    </div>

    <table class="tb">
        <thead>
            <tr>
                <th>NISN</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nisn']) ?></td>
                        <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                        <td><?= htmlspecialchars($row['kelas']) ?></td>
                        <td><?= htmlspecialchars($row['jurusan']) ?></td>
                        <td><?= htmlspecialchars($row['jeniskelamin']) ?></td>
                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Tidak ada data ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tombol Kembali -->
    <button class="back-button" onclick="window.history.back()">Kembali</button>
</body>
</html>