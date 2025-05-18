<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login untuk menghapus musik dari favorit.";
    exit();
}

$user_id = $_SESSION['user_id'];
$song_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($song_id) {
    $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = :user_id AND song_id = :song_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':song_id', $song_id);

    if ($stmt->execute()) {
        echo "Musik berhasil dihapus dari favorit.";
    } else {
        echo "Gagal menghapus musik dari favorit.";
    }
} else {
    echo "ID musik tidak valid.";
}
