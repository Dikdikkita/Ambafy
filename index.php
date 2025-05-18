<?php
session_start();
require_once 'config/db.php';

// Jika user sudah login, langsung arahkan ke home.php
if (isset($_SESSION['user_id'])) {
    header('Location: pages/home.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ambafy - Streaming Musik Terbaik</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="index-container">
        <h1>Selamat Datang di Ambafy</h1>
        <p>Streaming musik favoritmu kapan saja, di mana saja.</p>

        <div class="auth-links">
            <a href="pages/login.php" class="btn">Login</a>
            <a href="pages/signup.php" class="btn">Sign Up</a>
        </div>

        <div class="features">
            <h2>Fitur Utama:</h2>
            <ul>
                <li>Pemutar Musik Interaktif</li>
                <li>Rekomendasi Musik Terbaik</li>
                <li>Playlist Favorit Pribadi</li>
                <li>Pencarian Musik Berdasarkan Judul & Artis</li>
                <li>Pengaturan Akun Pengguna</li>
            </ul>
        </div>
    </div>
</body>
</html>
