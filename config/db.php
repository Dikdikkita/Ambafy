<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ambafy";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Koneksi berhasil";
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
