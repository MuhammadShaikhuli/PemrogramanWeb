<?php
session_start();

$nim = trim($_POST['nim'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$jurusan = trim($_POST['jurusan'] ?? '');

$errors = [];

if ($nim === '') {
    $errors[] = "NIM / ID Anggota wajib diisi.";
}
if ($nama === '') {
    $errors[] = "Nama lengkap wajib diisi.";
}
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}

// Jika ada eror validasi
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

// Menyimpan ke array session anggota
if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

$_SESSION['anggota'][] = [
    'nim' => $nim,
    'nama' => $nama,
    'email' => $email,
    'jurusan' => $jurusan,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;