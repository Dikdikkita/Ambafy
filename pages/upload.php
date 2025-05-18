<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $album = $_POST['album'];
    $genre = $_POST['genre'];
    $uploaded_by = $_SESSION['user_id'];

    $musicFile = $_FILES['music'];
    $coverFile = $_FILES['cover'];

    $musicPath = "uploads/music/" . basename($musicFile['name']);
    $coverPath = "uploads/covers/" . basename($coverFile['name']);

    if (move_uploaded_file($musicFile['tmp_name'], "../" . $musicPath) &&
        move_uploaded_file($coverFile['tmp_name'], "../" . $coverPath)) {

        $stmt = $conn->prepare("INSERT INTO songs (title, artist, album, genre, file_path, cover_path, uploaded_by) 
                                VALUES (:title, :artist, :album, :genre, :file_path, :cover_path, :uploaded_by)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':artist', $artist);
        $stmt->bindParam(':album', $album);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':file_path', $musicPath);
        $stmt->bindParam(':cover_path', $coverPath);
        $stmt->bindParam(':uploaded_by', $uploaded_by);

        if ($stmt->execute()) {
            echo "Musik berhasil diunggah!";
        } else {
            echo "Gagal mengunggah musik!";
        }
    } else {
        echo "Gagal mengunggah file!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Unggah Musik - Ambafy</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="upload-container">
        <h2>Unggah Musik</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Judul Musik" required>
            <input type="text" name="artist" placeholder="Artis" required>
            <input type="text" name="album" placeholder="Album">
            <input type="text" name="genre" placeholder="Genre">
            <input type="file" name="music" accept="audio/*" required>
            <input type="file" name="cover" accept="image/*" required>
            <button type="submit">Unggah</button>
        </form>
    </div>
</body>
</html>
