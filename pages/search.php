<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$search = isset($_GET['q']) ? $_GET['q'] : '';
$songs = [];

if ($search) {
    $stmt = $conn->prepare("SELECT * FROM songs WHERE title LIKE :search OR artist LIKE :search");
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();
    $songs = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cari Musik - Ambafy</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="search-container">
        <h2>Cari Musik</h2>
        <form method="GET">
            <input type="text" name="q" placeholder="Cari musik atau artis..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Cari</button>
        </form>

        <?php if ($search && count($songs) > 0): ?>
            <h3>Hasil Pencarian:</h3>
            <ul>
                <?php foreach ($songs as $song): ?>
                    <li>
                        <a href="player.php?id=<?php echo $song['id']; ?>">
                            <?php echo htmlspecialchars($song['title']); ?> - <?php echo htmlspecialchars($song['artist']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php elseif ($search): ?>
            <p>Tidak ada hasil ditemukan.</p>
        <?php endif; ?>
    </div>
</body>
</html>
