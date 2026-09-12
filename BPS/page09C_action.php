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
    
    if (empty($no) || empty($judul) || empty($tanggal_rilis)) {
        echo "<script>alert('Semua data wajib diisi!'); window.history.back();</script>";
        exit();
    }

    $namaFileAsli    = $_FILES['Sampul']['name']; 
    $lokasiSementara = $_FILES['Sampul']['tmp_name']; 
    $errorFile       = $_FILES['Sampul']['error'];
    
    if ($errorFile === 0) {
        $ekstensiValid = ['jpg', 'jpeg', 'png', 'webp'];
        $mimeValid     = ['image/jpeg', 'image/png', 'image/webp'];

        $ekstensiFile = strtolower(pathinfo($namaFileAsli, PATHINFO_EXTENSION));
        $mimeAktual   = mime_content_type($lokasiSementara);

        if (!in_array($ekstensiFile, $ekstensiValid) || !in_array($mimeAktual, $mimeValid)) {
            echo "<script>alert('Gagal: Berkas harus berupa gambar valid (JPG, JPEG, PNG, WebP)!'); window.history.back();</script>";
            exit();
        }

        $namaFileBaru = uniqid('sampul_', true) . '.' . $ekstensiFile;
        $dirUpload    = "aset/";  
        
        if (move_uploaded_file($lokasiSementara, $dirUpload . $namaFileBaru)) {
            $sql  = "INSERT INTO publikasi (no, judul, tanggal_rilis, sampul) VALUES (?, ?, ?, ?)"; 
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$no, $judul, $tanggal_rilis, $namaFileBaru]);
            
            echo "<script>alert('Data Berhasil Ditambahkan'); window.location.href = 'page09A.php';</script>"; 
        } else {
            echo "<script>alert('Gagal memindahkan berkas yang diunggah.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengunggah berkas sampul.'); window.history.back();</script>";
    }
    
    $pdo = null; 
} catch (PDOException $e) { 
    exit("Database Error: " . $e->getMessage()); 
} 
?>