<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$song_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$song_id) {
    echo "ID musik tidak valid.";
    exit();
}

// Ambil informasi lagu berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM songs WHERE id = :id");
$stmt->bindParam(':id', $song_id);
$stmt->execute();
$song = $stmt->fetch();

if (!$song) {
    echo "Musik tidak ditemukan!";
    exit();
}

// Cek apakah lagu ini ada di playlist favorit
$stmt = $conn->prepare("
    SELECT songs.id 
    FROM favorites 
    JOIN songs ON favorites.song_id = songs.id 
    WHERE favorites.user_id = :user_id 
    ORDER BY favorites.id ASC
");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$fav_songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cari index lagu saat ini dalam playlist favorit
$current_index = array_search($song_id, array_column($fav_songs, 'id'));

// Tentukan lagu berikutnya dan sebelumnya
$prev_id = ($current_index > 0) ? $fav_songs[$current_index - 1]['id'] : null;
$next_id = ($current_index < count($fav_songs) - 1) ? $fav_songs[$current_index + 1]['id'] : null;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($song['title']); ?> - Pemutar Musik - Ambafy</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="player-container">
        <h2><?php echo htmlspecialchars($song['title']); ?></h2>
        <p><?php echo htmlspecialchars($song['artist']); ?> - <?php echo htmlspecialchars($song['album']); ?></p>

        <div class="player">
            <img src="../<?php echo htmlspecialchars($song['cover_path']); ?>" alt="Cover" class="cover">
            
            <audio id="audioPlayer" controls autoplay>
                <source src="../<?php echo htmlspecialchars($song['file_path']); ?>" type="audio/mpeg">
                Browser Anda tidak mendukung pemutar audio.
            </audio>
        </div>

        <div class="player-controls">
            <?php if ($prev_id): ?>
                <a href="player.php?id=<?php echo $prev_id; ?>" class="btn">Sebelumnya</a>
            <?php endif; ?>

            <a href="add_favorite.php?id=<?php echo $song['id']; ?>" class="btn">Tambah ke Favorit</a>

            <?php if ($next_id): ?>
                <a href="player.php?id=<?php echo $next_id; ?>" class="btn">Berikutnya</a>
            <?php endif; ?>
        </div>

        <a href="home.php" class="btn">Kembali ke Beranda</a>
    </div>

    <script>
        const audioPlayer = document.getElementById('audioPlayer');

        // Jika musik selesai, otomatis pindah ke lagu berikutnya jika ada
        audioPlayer.onended = function() {
            <?php if ($next_id): ?>
                window.location.href = "player.php?id=<?php echo $next_id; ?>";
            <?php endif; ?>
        };
    </script>
</body>
</html>
