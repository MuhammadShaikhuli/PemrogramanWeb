<?php
session_start();
require_once __DIR__ . '/../includes/koneksi.php';

// Sengaja hanya menerima POST (bukan GET) agar penghapusan tidak bisa
// dipicu tanpa sengaja lewat link biasa atau preview crawler.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id'] ?? null;

if ($id) {
    // Jalankan perintah DELETE dengan prepared statement
    $stmt = $pdo->prepare("DELETE FROM buku WHERE id = :id");
    $stmt->execute(['id' => $id]);

    // Set flash message sukses
    $_SESSION['flash'] = [
        'type' => 'success', 
        'pesan' => 'Buku berhasil dihapus.'
    ];
}

header('Location: list.php');
exit;