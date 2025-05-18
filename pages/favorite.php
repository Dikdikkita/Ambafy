<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT songs.id, songs.title, songs.artist, songs.cover_path 
    FROM favorites 
    JOIN songs ON favorites.song_id = songs.id 
    WHERE favorites.user_id = :user_id
");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$favorites = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Favorit - Ambafy</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="favorites-container">
        <h2>Playlist Favorit Anda</h2>

        <?php if (count($favorites) > 0): ?>
            <ul class="favorites-list">
                <?php foreach ($favorites as $song): ?>
                    <li>
                        <img src="../<?php echo htmlspecialchars($song['cover_path']); ?>" class="cover" alt="Cover">
                        <span><?php echo htmlspecialchars($song['title']); ?> - <?php echo htmlspecialchars($song['artist']); ?></span>
                        <a href="player.php?id=<?php echo $song['id']; ?>">Play</a>
                        <a href="remove_favorite.php?id=<?php echo $song['id']; ?>">Hapus</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Tidak ada musik favorit.</p>
        <?php endif; ?>

        <a href="home.php">Kembali ke Beranda</a>
    </div>
</body>
</html>
