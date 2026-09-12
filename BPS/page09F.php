<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: page10A.php");
    exit();
}
include 'dbconn.php'; 

try { 
    $no = $_GET['No']; 
    
    $stmtCek = $pdo->prepare("SELECT sampul FROM publikasi WHERE no = ?");
    $stmtCek->execute([$no]);
    $dataPublikasi = $stmtCek->fetch();

    if ($dataPublikasi) {
        $namaFile = $dataPublikasi['sampul'];
        $dirUpload = "aset/"; 
        
        if (!empty($namaFile) && file_exists($dirUpload . $namaFile)) {
            unlink($dirUpload . $namaFile);
        }

        $sql = "DELETE FROM publikasi WHERE no = ?"; 
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$no]);
        
        echo "<script>
                alert('Data dan File Sampul Berhasil Dihapus'); 
                window.location.href = 'page09A.php';
              </script>"; 
    } else {
        echo "<script>
                alert('Data tidak ditemukan!'); 
                window.location.href = 'page09A.php';
              </script>"; 
    }
    
    $pdo = NULL; 
} catch (PDOException $e) { 
    exit("PDO Error: " . $e->getMessage() . "<br>"); 
} 
?>