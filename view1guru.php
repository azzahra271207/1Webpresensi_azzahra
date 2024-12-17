<?php
include 'koneksi.php';

// Mendapatkan NIP dari URL
$nip = isset($_GET['id']) ? $_GET['id'] : '';

// Query untuk mendapatkan data guru berdasarkan NIP
$stmt = $koneksi->prepare("SELECT * FROM guru WHERE nip = ?");
$stmt->bind_param("s", $nip);
$stmt->execute();
$result = $stmt->get_result();
$guru = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Guru</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex; /* Menjadikan body sebagai flex container */
            justify-content: center; /* Membuat konten di tengah secara horizontal */
            align-items: center; /* Membuat konten di tengah secara vertikal */
            min-height: 100vh; /* Mengatur tinggi minimum body */
        }
        .content {
            width: 100%; /* Memastikan konten responsif */
            max-width: 800px;
            padding: 20px;
        }
        .guru-detail {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
            align-items: center;
        }
        .guru-detail img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
            max-width: 150px;
            margin: 0 auto;
        }
        .guru-detail p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }
        .back-btn {
            background-color: #A7C7E7;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            display: block;
            text-align: center;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .back-btn:hover {
            background-color: #80B3D1;
        }
    </style>
</head>
<body>
    <div class="content">
        <?php if ($guru): ?>
            <div class="guru-detail">
                <img src="<?= htmlspecialchars($guru['foto']) ?>" alt="Foto Guru">
                <div>
                    <p><strong>Nama:</strong> <?= htmlspecialchars($guru['nama']) ?></p>
                    <p><strong>NIP:</strong> <?= htmlspecialchars($guru['nip']) ?></p>
                    <p><strong>Mata Pelajaran:</strong> <?= htmlspecialchars($guru['mata_pelajaran']) ?></p>
                    <p><strong>Nomor HP:</strong> <?= htmlspecialchars($guru['nomor_handphone']) ?></p>
                </div>
            </div>
            <a href="guru1.php" class="back-btn">Kembali ke Data Guru</a>
        <?php else: ?>
            <p>Data guru tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</body>
</html>
