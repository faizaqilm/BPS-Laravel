<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("Akses ditolak. Hanya admin yang dapat melakukan sinkronisasi.");
}
include 'dbconn.php';

// Hilangkan batas waktu eksekusi script karena proses sinkronisasi banyak halaman membutuhkan waktu
set_time_limit(0);

// 1. OTOMATISASI UPDATE STRUKTUR TABEL
try {
    $pdo->exec("ALTER TABLE publikasi ADD COLUMN IF NOT EXISTS pub_id VARCHAR(100) NULL");
    $pdo->exec("ALTER TABLE publikasi ADD COLUMN IF NOT EXISTS abstract TEXT NULL");
    $pdo->exec("ALTER TABLE publikasi ADD COLUMN IF NOT EXISTS kategori VARCHAR(255) NULL");
    $pdo->exec("ALTER TABLE publikasi ADD COLUMN IF NOT EXISTS pdf_link TEXT NULL");
} catch(PDOException $e) {
    // Abaikan jika kolom sudah ada
}

// Cek nilai "no" tertinggi di database untuk auto-increment manual
$stmtMax = $pdo->query("SELECT MAX(no) as max_no FROM publikasi");
$rowMax = $stmtMax->fetch();
$currentNo = $rowMax['max_no'] ? (int)$rowMax['max_no'] : 0;

// 2. KONFIGURASI API BPS
$apiKey = "5fe7ead70192dafd9cf4f06b0d10308f"; // Pastikan API key tetap diisi
$domain = "6500";

$sukses = 0;
$page = 1;
$totalPages = 1; // Akan di-update otomatis setelah request halaman pertama

// 3. LOOPING UNTUK MENARIK DATA DARI SELURUH HALAMAN
do {
    // URL disesuaikan dengan paramater page yang dinamis
    $apiUrl = "https://webapi.bps.go.id/v1/api/list/model/publication/lang/ind/domain/{$domain}/page/{$page}/key/{$apiKey}/";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $result = json_decode($response, true);
        
        // Pastikan respon API berstatus OK
        if (isset($result['status']) && $result['status'] === 'OK') {
            
            // Ambil total halaman dari metadata API BPS pada request pertama
            if (isset($result['data'][0]['pages'])) {
                $totalPages = (int)$result['data'][0]['pages'];
            }

            if (isset($result['data'][1])) {
                $dataApi = $result['data'][1];
                
                foreach ($dataApi as $item) {
                    $pub_id   = $item['pub_id'];
                    $judul    = $item['title'];
                    $tgl      = $item['rl_date'];
                    $cover    = $item['cover'];
                    $abstrak  = strip_tags($item['abstract'] ?? 'Tidak ada deskripsi.');
                    
                    $kategori = 'Umum';
                    if (!empty($item['subject_csa'])) {
                        $kategori = implode(', ', $item['subject_csa']);
                    } elseif (!empty($item['schn'])) {
                        $kategori = $item['schn'];
                    }

                    $pdf_link = $item['pdf'] ?? '';

                    // Cek apakah data sudah ada
                    $stmtCek = $pdo->prepare("SELECT no FROM publikasi WHERE pub_id = ? OR judul = ?");
                    $stmtCek->execute([$pub_id, $judul]);
                    $ada = $stmtCek->fetch();

                    if ($ada) {
                        // Update jika sudah ada
                        $sql = "UPDATE publikasi SET judul=?, tanggal_rilis=?, sampul=?, abstract=?, kategori=?, pdf_link=?, pub_id=? WHERE no=?";
                        $pdo->prepare($sql)->execute([$judul, $tgl, $cover, $abstrak, $kategori, $pdf_link, $pub_id, $ada['no']]);
                    } else {
                        // Increment manual untuk data baru
                        $currentNo++;
                        $sql = "INSERT INTO publikasi (no, judul, tanggal_rilis, sampul, abstract, kategori, pdf_link, pub_id) VALUES (?,?,?,?,?,?,?,?)";
                        $pdo->prepare($sql)->execute([$currentNo, $judul, $tgl, $cover, $abstrak, $kategori, $pdf_link, $pub_id]);
                    }
                    $sukses++;
                }
            }
        } else {
            // Hentikan perulangan jika API mengembalikan error di halaman tertentu
            break; 
        }
    } else {
        // Hentikan perulangan jika gagal mengeksekusi cURL
        break;
    }
    
    // Pindah ke halaman selanjutnya
    $page++;
    
} while ($page <= $totalPages);

echo "<script>
        alert('Proses Sinkronisasi Selesai! $sukses data dari pusat berhasil diperbarui ke database lokal.');
        window.location.href='page09A.php';
      </script>";
?>