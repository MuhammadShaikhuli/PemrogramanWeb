<?php
session_start();
require_once __DIR__ . '/../includes/koneksi.php';

$id = $_POST['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$judul     = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun     = $_POST['tahun'] ?? '';
$isbn      = trim($_POST['isbn'] ?? '');
$stok      = $_POST['stok'] ?? '';
$kategori  = trim($_POST['kategori'] ?? '');

$errors = [];

if ($judul === '') {
    $errors[] = "Judul wajib diisi.";
}
if ($pengarang === '') {
    $errors[] = "Pengarang wajib diisi.";
}
if (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2026) {
    $errors[] = "Tahun harus di antara 1900-2026.";
}
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}
if ($isbn !== '' && !preg_match('/^[0-9-]+$/', $isbn)) {
    $errors[] = "ISBN hanya boleh berisi angka dan tanda hubung (-).";
}

// Jika ada error validasi, kembalikan ke halaman edit dengan membawa ID
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode('<br>', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

try {
    // Jalankan query UPDATE dengan klausa WHERE yang aman
    $stmt = $pdo->prepare("
        UPDATE buku 
        SET judul = :judul, 
            pengarang = :pengarang, 
            tahun = :tahun, 
            isbn = :isbn, 
            stok = :stok, 
            kategori = :kategori 
        WHERE id = :id
    ");

    $stmt->execute([
        'judul'     => $judul,
        'pengarang' => $pengarang,
        'tahun'     => (int) $tahun,
        'isbn'      => $isbn,
        'stok'      => (int) $stok,
        'kategori'  => $kategori,
        'id'        => $id
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data buku berhasil diperbarui.'];
    header('Location: list.php');
    exit;

} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memperbarui data: ' . $e->getMessage()];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}