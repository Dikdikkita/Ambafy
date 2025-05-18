<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ambil semua lagu dari database
try {
    $stmt = $conn->prepare("SELECT * FROM songs ORDER BY id DESC");
    $stmt->execute();
    $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $songs = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Beranda - Ambafy</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="header">
        <h1>Selamat Datang di Ambafy</h1>
        <a href="settings.php">Pengaturan</a>
        <a href="favorite.php">Favorit</a>
        <a href="search.php">Cari Musik</a>
        <a href="player.php">Pemutar Musik</a>
        <a href="upload.php">Unggah Musik</a>
        <a href="search.php">Cari Musik</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <h2>Beranda - Ambafy</h2>
        <p>Rekomendasi Musik Terbaru</p>

        <div class="song-list">
            <?php if (count($songs) > 0): ?>
                <?php foreach ($songs as $song): ?>
                    <div class="song-item">
                        <img src="../<?php echo htmlspecialchars($song['cover_path']); ?>" class="cover" alt="Cover">
                        <div class="song-info">
                            <h3><?php echo htmlspecialchars($song['title']); ?></h3>
                            <p><?php echo htmlspecialchars($song['artist']); ?></p>
                            <a href="player.php?id=<?php echo $song['id']; ?>" class="btn">Putar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ada musik yang tersedia saat ini.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
