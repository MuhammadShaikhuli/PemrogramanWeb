<?php
session_start();

$nim     = trim($_POST['nim'] ?? '');
$nama    = trim($_POST['nama'] ?? '');
$email   = trim($_POST['email'] ?? '');
$jurusan = trim($_POST['jurusan'] ?? '');

$errors = [];

// 1. Validasi NIM
if ($nim === '') {
    $errors[] = "NIM / ID Anggota wajib diisi.";
} elseif (!preg_match('/^[0-9a-zA-Z]+$/', $nim)) {
    $errors[] = "NIM hanya boleh berisi angka dan huruf.";
}

// 2. Validasi Nama
if ($nama === '') {
    $errors[] = "Nama lengkap wajib diisi.";
} elseif (strlen($nama) < 3) {
    $errors[] = "Nama minimal terdiri dari 3 karakter.";
}

// 3. Validasi Email
if ($email === '') {
    $errors[] = "Email wajib diisi.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}

// 4. Validasi Jurusan
if ($jurusan === '') {
    $errors[] = "Jurusan wajib diisi.";
}

// Jika terdapat eror validasi, simpan flash message dan kembali ke form
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode('<br>', $errors)];
    header('Location: tambah.php');
    exit;
}

// Simpan data jika semua validasi lolos
if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

$_SESSION['anggota'][] = [
    'nim'     => $nim,
    'nama'    => $nama,
    'email'   => $email,
    'jurusan' => $jurusan,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;