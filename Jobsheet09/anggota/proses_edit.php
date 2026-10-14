<?php
session_start();
require_once __DIR__ . '/../includes/koneksi.php';

$id = $_POST['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$no_anggota = trim($_POST['no_anggota'] ?? '');
$nama       = trim($_POST['nama'] ?? '');
$alamat     = trim($_POST['alamat'] ?? '');
$no_hp      = trim($_POST['no_hp'] ?? '');

$errors = [];

if ($no_anggota === '') {
    $errors[] = "Nomor Anggota / NIM wajib diisi.";
}
if ($nama === '') {
    $errors[] = "Nama lengkap wajib diisi.";
} elseif (strlen($nama) < 3) {
    $errors[] = "Nama minimal terdiri dari 3 karakter.";
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
        UPDATE anggota 
        SET no_anggota = :no_anggota, 
            nama = :nama, 
            alamat = :alamat, 
            no_hp = :no_hp 
        WHERE id = :id
    ");

    $stmt->execute([
        'no_anggota' => $no_anggota,
        'nama'       => $nama,
        'alamat'     => $alamat,
        'no_hp'      => $no_hp,
        'id'         => $id
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data anggota berhasil diperbarui.'];
    header('Location: list.php');
    exit;

} catch (PDOException $e) {
    // Tangkap error duplikat No. Anggota / Unique constraint violation PostgreSQL (23505)
    if ($e->getCode() === '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'No. Anggota sudah dipakai, gunakan nomor lain.'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memperbarui data: ' . $e->getMessage()];
    }
    
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}