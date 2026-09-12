<?php
session_start();
include 'dbconn.php';
$isAdmin = isset($_SESSION['username']);

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS galeri (
        id INT AUTO_INCREMENT PRIMARY KEY,
        judul VARCHAR(255) NOT NULL,
        foto VARCHAR(255) NOT NULL
    )");
    
    $stmtCek = $pdo->query("SELECT COUNT(*) as jml FROM galeri");
    if ($stmtCek->fetch()['jml'] == 0) {
        $pdo->exec("INSERT INTO galeri (judul, foto) VALUES 
            ('Sensus Penduduk', '1.jpg'), ('Petani Kaltara', '2.jpg'), ('Sosialisasi', '3.png'), 
            ('Survei Lapangan', '4.jpg'), ('Kegiatan Internal', '5.jpg'), ('Gedung BPS', '6.jpg')");
    }
} catch (PDOException $e) {
}

$action = isset($_GET['action']) ? $_GET['action'] : 'view';
$dirUpload = "aset/";

if ($isAdmin) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        if (isset($_POST['tambah'])) {
            $judul = trim($_POST['judul']);
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $ekstensi = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
                if (in_array($ekstensi, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $namaFileBaru = uniqid('galeri_') . '.' . $ekstensi;
                    move_uploaded_file($_FILES['foto']['tmp_name'], $dirUpload . $namaFileBaru);
                    
                    $stmt = $pdo->prepare("INSERT INTO galeri (judul, foto) VALUES (?, ?)");
                    $stmt->execute([$judul, $namaFileBaru]);
                    echo "<script>alert('Foto Galeri berhasil ditambahkan!'); window.location.href='page06E.php';</script>";
                    exit();
                } else {
                    echo "<script>alert('Ekstensi file harus JPG, JPEG, PNG, atau WebP!');</script>";
                }
            }
        } 
        elseif (isset($_POST['edit'])) {
            $id = $_POST['id'];
            $judul = trim($_POST['judul']);
            $foto_lama = $_POST['foto_lama'];
            
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $ekstensi = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
                if (in_array($ekstensi, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $namaFileBaru = uniqid('galeri_') . '.' . $ekstensi;
                    move_uploaded_file($_FILES['foto']['tmp_name'], $dirUpload . $namaFileBaru);
                    
                    if (file_exists($dirUpload . $foto_lama) && !in_array($foto_lama, ['1.jpg','2.jpg','3.png','4.jpg','5.jpg','6.jpg'])) {
                        @unlink($dirUpload . $foto_lama);
                    }
                    
                    $stmt = $pdo->prepare("UPDATE galeri SET judul = ?, foto = ? WHERE id = ?");
                    $stmt->execute([$judul, $namaFileBaru, $id]);
                }
            } else {
                $stmt = $pdo->prepare("UPDATE galeri SET judul = ? WHERE id = ?");
                $stmt->execute([$judul, $id]);
            }
            echo "<script>alert('Data Galeri berhasil diperbarui!'); window.location.href='page06E.php';</script>";
            exit();
        }
    } 
    elseif ($action === 'hapus' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT foto FROM galeri WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if ($data) {
            if (file_exists($dirUpload . $data['foto']) && !in_array($data['foto'], ['1.jpg','2.jpg','3.png','4.jpg','5.jpg','6.jpg'])) {
                @unlink($dirUpload . $data['foto']);
            }
            $stmt = $pdo->prepare("DELETE FROM galeri WHERE id = ?");
            $stmt->execute([$id]);
            echo "<script>alert('Foto Galeri berhasil dihapus!'); window.location.href='page06E.php';</script>";
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" type="text/css" href="myCSS.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="aset/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg" type="image/svg+xml">
    <title>GALERI BPS KALTARA</title>
</head>
<body>
    <header>
        <div class="header-kiri">
            <img src="aset/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg" alt="logo BPS" type="image/svg+xml">
            <div class="judulweb">
                <span class="judul-atas">BADAN PUSAT STATISTIK</span>
                <span class="judul-bawah">PROVINSI KALIMANTAN UTARA</span>
            </div>
        </div>
        <nav>
            <a href="home.php">Beranda</a>
            <a href="page09A.php">Daftar Publikasi</a>
            
            <?php if($isAdmin): ?>
                <a href="page09C.php">Tambah Publikasi</a>
            <?php endif; ?>
            
            <a href="https://pst.bps.go.id/?_gl=1*1c94lna*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3NzMxMjIkbzM2JGcxJHQxNzg4Nzc4MzY2JGo2MCRsMCRoMA.." target="_blank">Layanan</a>
            <a class="active" href="page06E.php">Galeri Kegiatan</a>
            
            <div class="dropdown">
                <button class="dropbtn">Informasi Publik ▾</button>
                <div class="dropdown-content">
                  <a href="https://ppid.bps.go.id/app/konten/6500/Profil-BPS.html?_gl=1*nmam2d*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3NzMxMjIkbzM2JGcxJHQxNzg4Nzc4MzY2JGo2MCRsMCRoMA.." target="_blank">Tentang Kami</a>
                  <a href="https://ppid.bps.go.id/?mfd=6500&_gl=1*4adiu5*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3NzMxMjIkbzM2JGcxJHQxNzg4Nzc4MzY2JGo2MCRsMCRoMA.." target="_blank">PPID</a>
                  <a href="https://ppid.bps.go.id/app/konten/0000/Layanan-BPS.html?_gl=1*4adiu5*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3NzMxMjIkbzM2JGcxJHQxNzg4Nzc4MzY2JGo2MCRsMCRoMA..#pills-3" target="_blank">Kebijakan Diseminasi</a>
                  <a href="https://ppid.bps.go.id/app/konten/6500/Layanan-BPS.html?_gl=1*zg2fxu*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3NzMxMjIkbzM2JGcxJHQxNzg4Nzc4MzY2JGo2MCRsMCRoMA.." target="_blank">Informasi Layanan</a>
                  <a href="https://ppid.bps.go.id/app/keberatan_informasi?_gl=1*sxzjwz*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3NzMxMjIkbzM2JGcxJHQxNzg4Nzc4MzY2JGo2MCRsMCRoMA.." target="_blank">Pengaduan</a>
                </div>
            </div>

            <?php if($isAdmin): ?>
                <a href="page10B.php">Logout</a>
            <?php else: ?>
                <a href="page10A.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <?php 
    /* =========================================
       TAMPILAN FORM TAMBAH GALERI
       ========================================= */
    if ($action === 'tambah' && $isAdmin): ?>
        <main class="kotak" style="margin-top: 120px;">
            <h1>Tambah Foto Kegiatan</h1>
            <form action="page06E.php?action=tambah" method="post" enctype="multipart/form-data">
                <label for="judul">Keterangan:</label>
                <input type="text" id="judul" name="judul" required style="width: 75%; padding: 10px; margin-bottom: 15px;">
                <br>
                <label for="foto">Pilih Foto:</label>
                <input type="file" id="foto" name="foto" required style="width: 75%; padding: 10px; margin-bottom: 15px;">
                <br><br>
                <input type="submit" name="tambah" value="Simpan Foto" class="btn-tampilkan">
                <a href="page06E.php" style="margin-left: 15px; color: #d9534f; text-decoration: none;">Batal</a>
            </form>
        </main>

    <?php 
    /* =========================================
       TAMPILAN FORM EDIT GALERI
       ========================================= */
    elseif ($action === 'edit' && $isAdmin && isset($_GET['id'])): 
        $stmt = $pdo->prepare("SELECT * FROM galeri WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $editData = $stmt->fetch();
    ?>
        <main class="kotak" style="margin-top: 120px;">
            <h1>Edit Data Galeri</h1>
            <form action="page06E.php?action=edit" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($editData['foto']) ?>">
                
                <label for="judul">Keterangan:</label>
                <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($editData['judul']) ?>" required style="width: 75%; padding: 10px; margin-bottom: 15px;">
                <br>
                <label>Foto Saat Ini:</label>
                <img src="aset/<?= htmlspecialchars($editData['foto']) ?>" width="120" style="display:inline-block; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc;">
                <br>
                <label for="foto">Ganti Foto:</label>
                <input type="file" id="foto" name="foto" style="width: 75%; padding: 10px; margin-bottom: 15px;">
                <span style="font-size: 12px; color: #666; margin-left: 135px;">(Kosongkan jika tidak ingin mengganti foto)</span>
                <br><br>
                <input type="submit" name="edit" value="Simpan Perubahan" class="btn-tampilkan">
                <a href="page06E.php" style="margin-left: 15px; color: #d9534f; text-decoration: none;">Batal</a>
            </form>
        </main>

    <?php 
    /* =========================================
       TAMPILAN UTAMA GALERI KEGIATAN
       ========================================= */
    else: 
        $stmt = $pdo->query("SELECT * FROM galeri ORDER BY id DESC");
        $galeriList = $stmt->fetchAll();
    ?>
        <main class="galeri" style="margin-top: 100px;">
            <h1>Galeri Kegiatan BPS Kalimantan Utara</h1>
            
            <?php if ($isAdmin): ?>
                <div style="margin-bottom: 20px; text-align: left;">
                    <a href="page06E.php?action=tambah" class="btn-tampilkan" style="text-decoration: none; padding: 10px 20px; font-weight: bold;">+ Tambah Foto</a>
                </div>
            <?php endif; ?>

            <div class="galeri-container">
                <div class="preview">
                    <?php if(count($galeriList) > 0): ?>
                        <img id="imgPreview" src="aset/<?= htmlspecialchars($galeriList[0]['foto']) ?>" alt="<?= htmlspecialchars($galeriList[0]['judul']) ?>">
                    <?php else: ?>
                        <div style="padding: 100px; color: #777; background-color: #eee; border-radius: 4px;">Belum ada foto galeri yang diunggah.</div>
                    <?php endif; ?>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 15px;">
                    <?php foreach($galeriList as $row): ?>
                        <div style="text-align: center; border: 1px solid #ddd; padding: 10px; border-radius: 4px; background-color: white;">
                            <img src="aset/<?= htmlspecialchars($row['foto']) ?>" 
                                 alt="<?= htmlspecialchars($row['judul']) ?>" 
                                 title="<?= htmlspecialchars($row['judul']) ?>"
                                 onclick="gantiPreview(this)" 
                                 style="width: 100%; height: 120px; object-fit: cover; cursor: pointer; border-radius: 4px; transition: 0.2s;">
                            
                            <div style="font-size: 13px; margin-top: 10px; color: #333; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?= htmlspecialchars($row['judul']) ?>
                            </div>

                            <?php if($isAdmin): ?>
                                <div style="margin-top: 12px; font-size: 12px; display: flex; justify-content: center; gap: 8px;">
                                    <a href="page06E.php?action=edit&id=<?= $row['id'] ?>" style="color: #034f84; text-decoration: none; border: 1px solid #034f84; padding: 4px 10px; border-radius: 4px;">Edit</a>
                                    <a href="page06E.php?action=hapus&id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus foto ini secara permanen?')" style="color: #d9534f; text-decoration: none; border: 1px solid #d9534f; padding: 4px 10px; border-radius: 4px;">Hapus</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
        
        <script>
            function gantiPreview(el) {
                document.getElementById('imgPreview').src = el.src;
                document.getElementById('imgPreview').alt = el.alt;
            }
        </script>
    <?php endif; ?>

    <footer class="footer-bps">
        <div class="footer-content">
            <div class="footer-col brand-col">
                <div class="footer-logo">
                    <img src="aset/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg" alt="logo BPS">
                    <span>BADAN PUSAT STATISTIK</span>
                </div>
                <p>Badan Pusat Statistik Provinsi Kalimantan Utara (BPS-Statistics Kalimantan Utara Province)</p>
                <p>Jl. Jelarai Raya RT 75 RW 28 Tanjung Selor Hilir 77212</p>
                <p>Telp. (0552) 2033254; Whatsapp: 0822-5442-6005; Mailbox: bps6500@bps.go.id / pst6500@bps.go.id</p>
            </div>
            <div class="footer-col link-col">
                <h3>Tentang Kami</h3>
                <a href="#">Profil BPS</a>
                <a href="#">PPID</a>
                <a href="#">Kebijakan Diseminasi</a>
            </div>
            <div class="footer-col link-col">
                <h3>Tautan Lainnya</h3>
                <a href="#">ASEAN Stats</a>
                <a href="#">Reformasi Birokrasi</a>
                <a href="https://lpse.bps.go.id" target="_blank">Layanan Pengadaan Secara Elektronik</a>
                <a href="https://stis.ac.id" target="_blank">Politeknik Statistika STIS</a>
                <a href="#">Pusdiklat BPS</a>
                <a href="#">JDIH BPS</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright © 2026 Politeknik Statistika STIS | Created by Faiz Aqil Majid (faizaqil.m@gmail.com)</p>
        </div>
    </footer>
</body>
</html>