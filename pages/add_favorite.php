<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login untuk menambahkan musik ke favorit.";
    exit();
}

$user_id = $_SESSION['user_id'];
$song_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($song_id) {
    // Cek apakah musik sudah ada di favorit
    $stmt = $conn->prepare("SELECT * FROM favorites WHERE user_id = :user_id AND song_id = :song_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':song_id', $song_id);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        // Jika belum ada, tambahkan ke favorit
        $stmt = $conn->prepare("INSERT INTO favorites (user_id, song_id) VALUES (:user_id, :song_id)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':song_id', $song_id);

        if ($stmt->execute()) {
            echo "Musik berhasil ditambahkan ke favorit.";
        } else {
            echo "Gagal menambahkan musik ke favorit.";
        }
    } else {
        echo "Musik ini sudah ada di daftar favorit.";
    }
} else {
    echo "ID musik tidak valid.";
}
