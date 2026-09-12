<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: page10A.php");
    exit();
}
$isAdmin = true;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" type="text/css" href="myCSS.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="aset/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg" type="image/svg+xml">
    <title>Ubah Publikasi BPS KALTARA</title>
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
            <a href="#">Home</a>
            <a href="page09A.php">Daftar Publikasi</a>
            <a href="page09C.php">Tambah Publikasi</a>
            <a href="https://kaltara.bps.go.id/layanan" target="_blank">Layanan</a>
            <a href="page06E.php">Galeri Kegiatan</a>
            
            <div class="dropdown">
                <button class="dropbtn">Informasi Publik ▾</button>
                <div class="dropdown-content">
                  <a href="#">Tentang Kami</a>
                  <a href="#">PPID</a>
                  <a href="#">Kebijakan Diseminasi</a>
                  <a href="#">Informasi Layanan</a>
                  <a href="#">Pengaduan</a>
                </div>
            </div>

            <a href="page10B.php">Logout</a>
        </nav>
    </header>
    <main class="kotak">
        <h1>Formulir Ubah Data Publikasi</h1>
        
        <form name="myFormEdit" action="page09E_action.php" method="post" enctype="multipart/form-data" onsubmit="return validate06C()">
            
            <label for="nomor">Nomor:</label>
            <input type="number" id="nomor" name="No" value="<?= isset($_GET['No']) ? htmlspecialchars($_GET['No']) : ''; ?>" readonly style="background-color: #e9ecef;">
            <br><br>
            
            <label for="Judul">Judul:</label>
            <input type="text" id="Judul" name="Judul" value="<?= isset($_GET['Judul']) ? htmlspecialchars($_GET['Judul']) : ''; ?>">
            <br><br>
            
            <label for="tgl_rilis">Tanggal Rilis:</label>
            <input type="date" id="tgl_rilis" name="Tanggal_rilis" value="<?= isset($_GET['Tanggal_rilis']) ? htmlspecialchars($_GET['Tanggal_rilis']) : ''; ?>">
            <br><br>
            
            <label for="sampul_lama">Sampul Lama:</label> 
            <img src="aset/<?= $_GET['Sampul']; ?>" alt= "No Image" width="70px"> <br/><br/> 
            <label for="sampul_baru">Sampul Baru:</label> 
            <input type="file" id="sampul_baru" name="sampul_baru" > <br/><br/> 
                        
            <input type="submit" value="Ubah Data">
        </form>
    </main>
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
                <a href="https://ppid.bps.go.id/app/konten/6500/Profil-BPS.html?_gl=1*rnuluf*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3ODEyMzEkbzM3JGcxJHQxNzg4NzgyMDY1JGo2MCRsMCRoMA.." target="_blank">Profil BPS</a>
                <a href="https://ppid.bps.go.id/?mfd=6500&_gl=1*rnuluf*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3ODEyMzEkbzM3JGcxJHQxNzg4NzgyMDY1JGo2MCRsMCRoMA.." target="_blank">PPID</a>
                <a href="https://ppid.bps.go.id/app/konten/0000/Layanan-BPS.html?_gl=1*1o347a9*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3ODEyMzEkbzM3JGcxJHQxNzg4NzgyMDY1JGo2MCRsMCRoMA..#pills-3" target="_blank">Kebijakan Diseminasi</a>
            </div>
            <div class="footer-col link-col">
                <h3>Tautan Lainnya</h3>
                <a href="https://www.aseanstats.org/" target="_blank">ASEAN Stats</a>
                <a href="https://rb.bps.go.id/?_gl=1*1o347a9*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3ODEyMzEkbzM3JGcxJHQxNzg4NzgyMDY1JGo2MCRsMCRoMA.." target="_blank">Reformasi Birokrasi</a>
                <a href="https://lpse.bps.go.id" target="_blank">Layanan Pengadaan Secara Elektronik</a>
                <a href="https://stis.ac.id" target="_blank">Politeknik Statistika STIS</a>
                <a href="https://pusdiklat.bps.go.id/?_gl=1*1aodd1q*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3ODEyMzEkbzM3JGcxJHQxNzg4NzgyMDY1JGo2MCRsMCRoMA.." target="_blank">Pusdiklat BPS</a>
                <a href="https://jdih.bps.go.id/?_gl=1*1aodd1q*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3ODEyMzEkbzM3JGcxJHQxNzg4NzgyMDY1JGo2MCRsMCRoMA.." target="_blank">JDIH BPS</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright © 2026 Politeknik Statistika STIS | Created by Faiz Aqil Majid (faizaqil.m@gmail.com)</p>
        </div>
    </footer>
</body>
</html>