<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: page10A.php");
    exit();
}

include 'dbconn.php'; 

try { 
    $no            = isset($_POST['No']) ? (int)$_POST['No'] : 0; 
    $judul         = trim($_POST['Judul']); 
    $tanggal_rilis = $_POST['Tanggal_rilis'];
    $dirUpload     = "aset/"; 

    // Ambil data publikasi saat ini untuk mengetahui sampul lama
    $stmtCek = $pdo->prepare("SELECT sampul FROM publikasi WHERE no = ?");
    $stmtCek->execute([$no]);
    $dataLama = $stmtCek->fetch();

    if (!$dataLama) {
        echo "<script>alert('Data publikasi tidak ditemukan!'); window.location.href='page09A.php';</script>";
        exit();
    }

    if (isset($_FILES['sampul_baru']) && $_FILES['sampul_baru']['error'] === 0) { 
        $namaFileAsli    = $_FILES['sampul_baru']['name']; 
        $lokasiSementara = $_FILES['sampul_baru']['tmp_name']; 
        
        $ekstensi = strtolower(pathinfo($namaFileAsli, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        $allowedMimes      = ['image/jpeg', 'image/png', 'image/webp'];

        // Validasi ekstensi
        if (!in_array($ekstensi, $allowedExtensions)) {
            echo "<script>alert('Ekstensi berkas wajib berupa JPG, JPEG, PNG, atau WebP!'); window.history.back();</script>";
            exit();
        }

        // Validasi MIME Type aktual
        $mimeType = mime_content_type($lokasiSementara);
        if (!in_array($mimeType, $allowedMimes)) {
            echo "<script>alert('Format berkas yang diunggah tidak valid!'); window.history.back();</script>";
            exit();
        }

        // Berikan nama acak yang aman
        $namaFileBaru = uniqid('sampul_', true) . '.' . $ekstensi;

        if (move_uploaded_file($lokasiSementara, $dirUpload . $namaFileBaru)) {
            // Hapus berkas lama jika ada di server
            if (!empty($dataLama['sampul']) && file_exists($dirUpload . $dataLama['sampul'])) {
                @unlink($dirUpload . $dataLama['sampul']);
            }

            $sql  = "UPDATE publikasi SET judul = ?, tanggal_rilis = ?, sampul = ? WHERE no = ?"; 
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$judul, $tanggal_rilis, $namaFileBaru, $no]);
        } else {
            echo "<script>alert('Gagal memindahkan berkas unggahan!'); window.history.back();</script>";
            exit();
        }
    } else { 
        // Jika tidak mengganti sampul, update data teks saja
        $sql  = "UPDATE publikasi SET judul = ?, tanggal_rilis = ? WHERE no = ?"; 
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$judul, $tanggal_rilis, $no]);
    }

    echo "<script> 
            alert('Data Berhasil Diperbarui'); 
            window.location.href = 'page09A.php';
          </script>"; 

    $pdo = null; 
} catch (PDOException $e) { 
    exit("Database Error: " . $e->getMessage()); 
}
?>