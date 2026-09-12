<?php
session_start();
$isAdmin = isset($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - BPS Provinsi Kalimantan Utara</title>
    <link rel="icon" href="aset/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg" type="image/svg+xml">
    <link rel="stylesheet" type="text/css" href="myCSS.css">
</head>
<body>

    <header class="header-home">
        <div class="header-kiri">
            <img src="aset/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg" alt="Logo BPS">
            <div class="judulweb">
                <span class="judul-atas">BADAN PUSAT STATISTIK</span>
                <span class="judul-bawah">PROVINSI KALIMANTAN UTARA</span>
            </div>
        </div>

        <nav>
            <a class="active" href="home.php">Beranda</a>
            <a href="page09A.php">Daftar Publikasi</a>

            <?php if ($isAdmin): ?>
                <a href="page09C.php">Tambah Publikasi</a>
            <?php endif; ?>

            <a href="https://pst.bps.go.id/?_gl=1*1c94lna*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3NzMxMjIkbzM2JGcxJHQxNzg4Nzc4MzY2JGo2MCRsMCRoMA.." target="_blank" rel="noopener">Layanan</a>
            <a href="page06E.php">Galeri Kegiatan</a>

            <div class="dropdown">
                <button class="dropbtn" type="button">Informasi Publik <span class="chevron">&#9662;</span></button>
                <div class="dropdown-content">
                    <a href="https://ppid.bps.go.id/app/konten/6500/Profil-BPS.html?_gl=1*nmam2d*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3NzMxMjIkbzM2JGcxJHQxNzg4Nzc4MzY2JGo2MCRsMCRoMA.." target="_blank">Tentang Kami</a>
                  <a href="https://ppid.bps.go.id/?mfd=6500&_gl=1*4adiu5*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3NzMxMjIkbzM2JGcxJHQxNzg4Nzc4MzY2JGo2MCRsMCRoMA.." target="_blank">PPID</a>
                  <a href="https://ppid.bps.go.id/app/konten/0000/Layanan-BPS.html?_gl=1*4adiu5*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3NzMxMjIkbzM2JGcxJHQxNzg4Nzc4MzY2JGo2MCRsMCRoMA..#pills-3" target="_blank">Kebijakan Diseminasi</a>
                  <a href="https://ppid.bps.go.id/app/konten/6500/Layanan-BPS.html?_gl=1*zg2fxu*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3NzMxMjIkbzM2JGcxJHQxNzg4Nzc4MzY2JGo2MCRsMCRoMA.." target="_blank">Informasi Layanan</a>
                  <a href="https://ppid.bps.go.id/app/keberatan_informasi?_gl=1*sxzjwz*_ga*MTI3MTI1NzE0Ni4xNzMwNTI0NTEy*_ga_XXTTVXWHDB*czE3ODg3NzMxMjIkbzM2JGcxJHQxNzg4Nzc4MzY2JGo2MCRsMCRoMA.." target="_blank">Pengaduan</a>
                </div>
            </div>

            <?php if ($isAdmin): ?>
                <a href="page10B.php">Logout</a>
            <?php else: ?>
                <a href="page10A.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="home-main">

        <section class="hero-section">
            <div class="hero-pattern" aria-hidden="true"></div>
            <div class="hero-inner">
                <h1>Lembaga yang Independen, Tepercaya, dan Berperan Aktif dalam Mendukung Perumusan Kebijakan Berbasis Data Bersama Indonesia Maju Menuju Indonesia Emas 2045</h1>

                <form class="search-bar-home" action="page09A.php" method="get">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                    <input type="text" name="keyword" placeholder="Cari data statistik atau publikasi..." autocomplete="off">
                    <button type="submit">Cari</button>
                </form>
            </div>
        </section>

        <section class="indikator-container">

            <div class="indikator-card">
                <div class="indikator-title">Indeks Pembangunan Manusia (IPM)</div>
                <div class="indikator-value">74,04</div>
                <div class="indikator-unit">&nbsp;</div>
                <div class="indikator-period">2025</div>
            </div>

            <div class="indikator-card">
                <div class="indikator-title">Jumlah Kedatangan Wisman</div>
                <div class="indikator-value">1.486</div>
                <div class="indikator-unit">Kunjungan</div>
                <div class="indikator-period">Juli 2026</div>
            </div>

            <div class="indikator-card">
                <div class="indikator-title">Garis Kemiskinan</div>
                <div class="indikator-value">933.675</div>
                <div class="indikator-unit">Rupiah</div>
                <div class="indikator-period">September 2025</div>
            </div>

            <div class="indikator-card">
                <div class="indikator-title">Nilai Tukar Petani</div>
                <div class="indikator-value">117,41</div>
                <div class="indikator-unit">&nbsp;</div>
                <div class="indikator-period">Agustus 2026</div>
            </div>

            <div class="indikator-card">
                <div class="indikator-title">Nilai Tukar Nelayan dan Pembudidaya Ikan</div>
                <div class="indikator-value">103,83</div>
                <div class="indikator-unit">&nbsp;</div>
                <div class="indikator-period">Agustus 2026</div>
            </div>

        </section>
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