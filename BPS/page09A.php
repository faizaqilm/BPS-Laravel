<?php
session_start();
include 'dbconn.php';
$isAdmin = isset($_SESSION['username']);

function tanggalIndo($tanggal) {
    if (empty($tanggal)) return '';
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $ts = strtotime($tanggal);
    return date('j', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

// Tangkap filter dari form
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$tahun   = isset($_GET['tahun']) ? trim($_GET['tahun']) : '';
$urutkan = isset($_GET['urutkan']) ? $_GET['urutkan'] : 'terbaru';

// Query Dasar Database Lokal
$sql = "SELECT * FROM publikasi WHERE 1=1";
$sqlHitung = "SELECT COUNT(*) AS jml FROM publikasi WHERE 1=1";
$params = [];

if ($keyword !== '') {
    $kondisi = " AND Judul LIKE ?";
    $sql .= $kondisi;
    $sqlHitung .= $kondisi;
    $params[] = "%$keyword%";
}
if ($tahun !== '') {
    $kondisi = " AND YEAR(Tanggal_rilis) = ?";
    $sql .= $kondisi;
    $sqlHitung .= $kondisi;
    $params[] = $tahun;
}

// Eksekusi Total Data
$stmtHitung = $pdo->prepare($sqlHitung);
$stmtHitung->execute($params);
$totalSemua = $stmtHitung->fetch()['jml'];

// Logika Paginasi
$limit = 6; 
$halamanAktif = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
if ($halamanAktif < 1) $halamanAktif = 1;
$offset = ($halamanAktif - 1) * $limit;
$totalHalaman = ceil($totalSemua / $limit);

// Logika Pengurutan
if ($urutkan === 'terlama') {
    $sql .= " ORDER BY Tanggal_rilis ASC";
} else {
    $sql .= " ORDER BY Tanggal_rilis DESC";
}

$sql .= " LIMIT $limit OFFSET $offset";

// Ambil Data
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$dataPublikasi = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalHasil = count($dataPublikasi);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" type="text/css" href="myCSS.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="aset/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg" type="image/svg+xml">
    <title>PUBLIKASI BPS KALTARA</title>
    <style>
        /* Sidebar Filter */
        .filter-sidebar-modern {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            flex: 0 0 280px;
            box-sizing: border-box;
            border: 1px solid #f0f0f0;
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
        }
        
        .filter-sidebar-modern label {
            display: block;
            font-size: 15px;
            color: #1a1a1a;
            margin-bottom: 8px;
            font-weight: 500;
            white-space: nowrap;
        }

        .filter-sidebar-modern input[type="text"],
        .filter-sidebar-modern select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
            margin-bottom: 16px;
            box-sizing: border-box;
            color: #333;
        }

        .filter-sidebar-modern select {
            appearance: none;
            background: url('data:image/svg+xml;utf8,<svg fill="%23999" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 10px center;
            background-color: white;
            cursor: pointer;
        }

        .filter-sidebar-modern .hint-box {
            font-size: 12px;
            color: #666;
            margin-top: -12px;
            margin-bottom: 16px;
            min-height: 14px;
        }

        .btn-modern-submit {
            width: 100%;
            background-color: #008be5;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.2s;
        }

        .btn-modern-submit:hover {
            background-color: #0073bf;
        }

        /* Kartu Publikasi */
        .publikasi-card {
            display: flex;
            gap: 20px;
            background-color: white;
            border: 1px solid #e2e2e2;
            border-radius: 8px;
            padding: 16px;
            transition: box-shadow 0.2s;
        }

        .publikasi-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .publikasi-card img {
            width: 140px;
            height: 200px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0;
            border: 1px solid #eee;
        }

        .publikasi-info {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            width: 100%;
        }

        .meta-text {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13.5px;
            color: #666;
            margin-bottom: 8px;
        }

        .publikasi-judul-link {
            font-size: 17px;
            color: #034f84;
            text-decoration: none;
            margin-bottom: 10px;
            font-weight: bold;
            line-height: 1.4;
        }

        .publikasi-judul-link:hover {
            text-decoration: underline;
        }

        .publikasi-abstrak {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .publikasi-aksi-admin {
            margin-top: 10px;
            display: flex;
            gap: 15px;
            padding-top: 10px;
            border-top: 1px dashed #ddd;
        }

        .publikasi-aksi-admin a {
            font-size: 13px;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .publikasi-aksi-admin a:hover {
            color: #008be5;
        }

        .btn-sync {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            float: right;
        }
        .btn-sync:hover { background-color: #218838; }
    </style>
</head>
<body>
    <header>
        <div class="header-kiri">
            <img src="aset/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg" alt="logo BPS">
            <div class="judulweb">
                <span class="judul-atas">BADAN PUSAT STATISTIK</span>
                <span class="judul-bawah">PROVINSI KALIMANTAN UTARA</span>
            </div>
        </div>
        
        <nav>
            <a href="home.php">Beranda</a>
            <a class="active" href="page09A.php">Daftar Publikasi</a>
            
            <?php if($isAdmin): ?>
                <a href="page09C.php">Tambah Publikasi</a>
            <?php endif; ?>
            
            <a href="https://pst.bps.go.id/" target="_blank" rel="noopener">Layanan</a>
            <a href="page06E.php">Galeri Kegiatan</a>
            
            <div class="dropdown">
                <button class="dropbtn" type="button">Informasi Publik <span class="chevron">&#9662;</span></button>
                <div class="dropdown-content">
                  <a href="https://ppid.bps.go.id/app/konten/6500/Profil-BPS.html" target="_blank">Tentang Kami</a>
                  <a href="https://ppid.bps.go.id/?mfd=6500" target="_blank">PPID</a>
                  <a href="https://ppid.bps.go.id/app/konten/0000/Layanan-BPS.html" target="_blank">Kebijakan Diseminasi</a>
                  <a href="https://ppid.bps.go.id/app/konten/6500/Layanan-BPS.html" target="_blank">Informasi Layanan</a>
                  <a href="https://ppid.bps.go.id/app/keberatan_informasi" target="_blank">Pengaduan</a>
                </div>
            </div>

            <?php if($isAdmin): ?>
                <a href="page10B.php">Logout</a>
            <?php else: ?>
                <a href="page10A.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="publikasi-wrapper">
        <aside class="filter-sidebar-modern">
            <form action="page09A.php" method="get">
                
                <label for="keyword">Kata Kunci</label>
                <input type="text" id="keyword" name="keyword"
                       placeholder="Masukkan kata kunci..."
                       value="<?= htmlspecialchars($keyword) ?>"
                       onkeyup="showHint(this.value)"
                       autocomplete="off">
                <p class="hint-box">Saran: <span id="txtHint"></span></p>

                <label for="tahun">Tahun</label>
                <select id="tahun" name="tahun">
                    <option value="">Pilih Tahun</option>
                    <?php for($y = (int)date('Y'); $y >= 2010; $y--): ?>
                        <option value="<?= $y ?>" <?= (string)$tahun === (string)$y ? 'selected' : '' ?>>
                            <?= $y ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <label for="urutkan">Urutkan Berdasarkan</label>
                <select id="urutkan" name="urutkan">
                    <option value="terbaru" <?= $urutkan === 'terbaru' ? 'selected' : '' ?>>Terbaru</option>
                    <option value="terlama" <?= $urutkan === 'terlama' ? 'selected' : '' ?>>Terlama</option>
                </select>

                <button type="submit" class="btn-modern-submit">Tampilkan</button>
                
                <?php if ($keyword !== '' || $tahun !== '' || $urutkan !== 'terbaru'): ?>
                    <a href="page09A.php" class="reset-filter" style="margin-top: 15px; display: block; text-align: center; color: #008be5; text-decoration: none; font-size: 14px;">Reset Filter</a>
                <?php endif; ?>
            </form>
        </aside>

        <section class="publikasi-hasil">
            <div class="publikasi-header">
                <?php if($isAdmin): ?>
                    <a href="sync_api.php" class="btn-sync" onclick="return confirm('Proses sinkronisasi akan menarik data terbaru dari API BPS ke database lokal. Lanjutkan?');">
                        &#x21bb; Sinkronkan Data BPS
                    </a>
                <?php endif; ?>
                
                <h1>Daftar Publikasi BPS Kaltara</h1>
                <p class="info-jumlah">
                    Menampilkan hasil dari total <?= $totalSemua ?> publikasi (Database Lokal)
                </p>
            </div>

            <div class="publikasi-list">
                <?php if ($totalHasil === 0): ?>
                    <p class="empty-state">Tidak ada publikasi yang cocok dengan filter pencarian ini.</p>
                <?php else: ?>
                    <?php foreach ($dataPublikasi as $row): ?>
                        <?php
                            // Cek apakah sampul dari API (HTTP) atau file lokal
                            $sampulImg = (strpos($row['Sampul'], 'http') === 0) ? $row['Sampul'] : 'aset/' . $row['Sampul'];
                            
                            // Siapkan parameter URL untuk fitur edit/hapus
                            $linkParams = http_build_query([
                                'No' => $row['No'],
                                'Judul' => $row['Judul'],
                                'Tanggal_rilis' => $row['Tanggal_rilis'],
                                'Sampul' => $row['Sampul']
                            ]);
                        ?>
                        <article class="publikasi-card">
                            <img src="<?= htmlspecialchars($sampulImg) ?>" 
                                 alt="<?= htmlspecialchars($row['Judul']) ?>"
                                 onerror="this.src='aset/Lambang_Badan_Pusat_Statistik_(BPS)_Indonesia.svg';">
                            
                            <div class="publikasi-info">
                                <!-- Meta Tanggal Rilis -->
                                <div class="meta-text">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    <?= tanggalIndo($row['Tanggal_rilis']) ?>
                                </div>
                                
                                <!-- Judul Publikasi (Link ke PDF jika ada) -->
                                <a href="<?= !empty($row['pdf_link']) ? htmlspecialchars($row['pdf_link']) : '#' ?>" target="_blank" rel="noopener" class="publikasi-judul-link">
                                    <?= htmlspecialchars($row['Judul']) ?>
                                </a>

                                <!-- Abstrak (Kolom baru) -->
                                <div class="publikasi-abstrak">
                                    <?= htmlspecialchars($row['abstract'] ?? 'Tidak ada deskripsi yang tersedia untuk publikasi ini.') ?>
                                </div>

                                <!-- Meta Kategori (Kolom baru) -->
                                <div class="meta-text" style="margin-top: auto;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                                    <?= htmlspecialchars($row['kategori'] ?? 'Umum') ?>
                                </div>

                                <!-- Tombol Edit & Hapus Khusus Admin -->
                                <?php if ($isAdmin): ?>
                                <div class="publikasi-aksi-admin">
                                    <a href="page09E.php?<?= $linkParams ?>">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> 
                                        Ubah
                                    </a>
                                    <a href="page09F.php?<?= $linkParams ?>" onclick="return confirm('Yakin ingin menghapus publikasi ini secara permanen?')">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="color:#d9534f;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> 
                                        <span style="color:#d9534f;">Hapus</span>
                                    </a>
                                </div>
                                <?php endif; ?>

                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Paginasi -->
            <?php if ($totalHalaman > 1): ?>
            <div style="display: flex; justify-content: center; gap: 8px; margin-top: 30px; flex-wrap: wrap;">
                <?php 
                    $startPage = max(1, $halamanAktif - 3);
                    $endPage   = min($totalHalaman, $halamanAktif + 3);
                ?>
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <?php 
                        $queryUrl = $_GET; 
                        $queryUrl['halaman'] = $i; 
                        $linkHalaman = http_build_query($queryUrl);
                    ?>
                    <a href="page09A.php?<?= $linkHalaman ?>" 
                       style="padding: 8px 14px; border-radius: 4px; text-decoration: none; border: 1px solid #008be5; 
                              <?= ($i === $halamanAktif) ? 'background-color: #008be5; color: white;' : 'color: #008be5; background-color: white;' ?>">
                       <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
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
                <a href="https://ppid.bps.go.id/app/konten/6500/Profil-BPS.html" target="_blank">Profil BPS</a>
                <a href="https://ppid.bps.go.id/?mfd=6500" target="_blank">PPID</a>
                <a href="https://ppid.bps.go.id/app/konten/0000/Layanan-BPS.html#pills-3" target="_blank">Kebijakan Diseminasi</a>
            </div>
            <div class="footer-col link-col">
                <h3>Tautan Lainnya</h3>
                <a href="https://www.aseanstats.org/" target="_blank">ASEAN Stats</a>
                <a href="https://rb.bps.go.id/" target="_blank">Reformasi Birokrasi</a>
                <a href="https://lpse.bps.go.id" target="_blank">Layanan Pengadaan Secara Elektronik</a>
                <a href="https://stis.ac.id" target="_blank">Politeknik Statistika STIS</a>
                <a href="https://pusdiklat.bps.go.id/" target="_blank">Pusdiklat BPS</a>
                <a href="https://jdih.bps.go.id/" target="_blank">JDIH BPS</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright © 2026 Politeknik Statistika STIS | Created by Faiz Aqil Majid (faizaqil.m@gmail.com)</p>
        </div>
    </footer>
    
    <script src="page11A_suggestion.js"></script>
</body>
</html>