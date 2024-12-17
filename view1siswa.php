<?php 
include 'koneksi.php';  
// Mendapatkan NISN dari URL 
$nisn = isset($_GET['id']) ? $_GET['id'] : '';  
// Query untuk mendapatkan data siswa berdasarkan NISN 
$stmt = $koneksi->prepare("SELECT * FROM siswa WHERE nisn = ?"); 
$stmt->bind_param("s", $nisn); 
$stmt->execute(); 
$result = $stmt->get_result(); 
$siswa = $result->fetch_assoc(); 
?>  

<!DOCTYPE html> 
<html lang="id"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>View Siswa</title>     
    <style>         
        body {             
            font-family: 'Arial', sans-serif;             
            background-color: #f4f6f9;             
            margin: 0;             
            padding: 0;         
        }          
        /* Main Content */         
        .content {             
            padding: 20px;             
            max-width: 800px;             
            margin-left: auto;             
            margin-right: auto;         
        }          
        h2 {             
            text-align: center;             
            color: #1E3A8A;         
        }          
        /* Siswa Detail Section with Grid Layout */         
        .siswa-detail {             
            background-color: #fff;             
            padding: 20px;             
            border-radius: 8px;             
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);             
            margin-bottom: 20px;             
            display: grid;             
            grid-template-columns: 1fr 1fr; /* Membuat 2 kolom */             
            grid-gap: 20px;             
            align-items: center;         
        }          
        .siswa-detail img {             
            width: 100%;             
            height: auto;             
            object-fit: cover;             
            border-radius: 8px;             
            margin-bottom: 20px;             
            max-width: 150px; /* Ukuran gambar lebih kecil */             
            margin-left: auto;             
            margin-right: auto;         
        }          
        .siswa-detail p {             
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
            text-align: center;             
            display: inline-block;             
            width: 100%;             
            transition: background-color 0.3s ease;         
        }          
        .back-btn:hover {             
            background-color: #80B3D1;         
        }     
    </style> 
</head> 
<body>     
    <!-- Main Content -->     
    <div class="content">         
        <h2>Detail Siswa</h2>          
        <?php if ($siswa): ?>             
            <div class="siswa-detail">                 
                <img src="<?= htmlspecialchars($siswa['foto']) ?>" alt="Foto Siswa">                 
                <div>                     
                    <p><strong>Nama:</strong> <?= htmlspecialchars($siswa['nama_siswa']) ?></p>                     
                    <p><strong>NISN:</strong> <?= htmlspecialchars($siswa['nisn']) ?></p>                     
                    <p><strong>Kelas:</strong> <?= htmlspecialchars($siswa['kelas']) ?></p>                     
                    <p><strong>Jurusan:</strong> <?= htmlspecialchars($siswa['jurusan']) ?></p>                     
                    <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($siswa['jeniskelamin']) ?></p>                     
                    <p><strong>Alamat:</strong> <?= htmlspecialchars($siswa['alamat']) ?></p>                 
                </div>             
            </div>             
            <a href="siswa1.php" class="back-btn">Kembali ke Data Siswa</a>         
        <?php else: ?>             
            <p>Data siswa tidak ditemukan.</p>         
        <?php endif; ?>     
    </div> 
</body> 
</html>
