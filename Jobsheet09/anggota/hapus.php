<?php
session_start();
require_once __DIR__ . '/../includes/koneksi.php';

// Sengaja hanya menerima POST (bukan GET) untuk keamanan dari crawler / preview link
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id'] ?? null;

if ($id) {
    // Jalankan perintah DELETE dengan prepared statement
    $stmt = $pdo->prepare("DELETE FROM anggota WHERE id = :id");
    $stmt->execute(['id' => $id]);

    $_SESSION['flash'] = [
        'type' => 'success', 
        'pesan' => 'Anggota berhasil dihapus.'
    ];
}

header('Location: list.php');
exit;