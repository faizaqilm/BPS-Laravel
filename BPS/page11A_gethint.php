<?php
include 'dbconn.php';
try {
    // Code 6: query untuk mencari publikasi berdasarkan keyword pada judul
    $keyword = $_GET["keyword"];

    $sql = "SELECT Judul FROM publikasi WHERE Judul LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%" . $keyword . "%"]);

    // lookup all hints if query result is not empty
    if ($stmt->rowCount() > 0) {
        echo json_encode($stmt->fetchAll());
    } else {
        // Output "no suggestion" jika hint tidak ditemukan
        $response[] = array(
            'Judul' => 'no suggestion'
        );
        echo json_encode($response);
    }

    $pdo = NULL;
} catch (PDOException $e) {
    exit("PDO Error: " . $e->getMessage() . "<br>");
}