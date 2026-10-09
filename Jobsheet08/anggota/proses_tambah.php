<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$nama       = trim($_POST['nama'] ?? '');
$no_anggota = trim($_POST['no_anggota'] ?? $_POST['nim'] ?? '');
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

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode('<br>', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO anggota (nama, no_anggota, alamat, no_hp)
     VALUES (:nama, :no_anggota, :alamat, :no_hp)
     RETURNING id"
);

$stmt->execute([
    'nama'       => $nama,
    'no_anggota' => $no_anggota,
    'alamat'     => $alamat,
    'no_hp'      => $no_hp,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;