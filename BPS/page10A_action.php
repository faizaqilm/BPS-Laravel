<?php 
session_start(); 
include 'dbconn.php'; 

try { 
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? ''; 

    if (empty($username) || empty($password)) {
        echo "<script>alert('Username dan password wajib diisi!'); window.location.href='page10A.php';</script>";
        exit();
    }

    $sql  = "SELECT * FROM user WHERE username = :username LIMIT 1"; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // KONDISI 1: Cek apakah akun ada dan password sudah di-hash (Standar Keamanan Baru)
    if ($user && password_verify($password, $user['password'])) {
        
        session_regenerate_id(true); // Perlindungan session fixation
        $_SESSION['username'] = $user['username'];
        header("Location: home.php");
        exit();

    } 
    // KONDISI 2: Cek apakah akun ada TAPI password masih teks biasa (Auto-Migration)
    elseif ($user && $password === $user['password']) {
        
        // 1. Enkripsi (hash) password teks biasa tersebut
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // 2. Perbarui password di database menjadi versi yang sudah di-hash
        $updateSql = "UPDATE user SET password = :hash WHERE username = :username";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([
            'hash' => $hashedPassword,
            'username' => $user['username']
        ]);

        // 3. Lanjutkan proses login
        session_regenerate_id(true);
        $_SESSION['username'] = $user['username'];
        header("Location: home.php");
        exit();

    } 
    // KONDISI 3: Username atau password salah
    else {
        echo "<script>
                alert('Username atau password salah!');
                window.location.href = 'page10A.php';
              </script>";
        exit();
    }
    
    $pdo = null; 
} catch(PDOException $e) { 
    exit("Koneksi gagal: " . $e->getMessage()); 
}
?>