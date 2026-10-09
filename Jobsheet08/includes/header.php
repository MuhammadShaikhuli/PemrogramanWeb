<?php
session_start();
$_jobsheetRoot = dirname(__DIR__);
$_scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$_rel = ltrim(str_replace('\\', '/', substr($_scriptDir, strlen($_jobsheetRoot))), '/');
$base = $_rel === '' ? '' : str_repeat('../', substr_count($_rel, '/') + 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPUS-Mini<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
<header>
    <h1>SIMPUS-Mini</h1>
    <button type="button" id="nav-toggle-btn" class="menu-btn" aria-label="Toggle Navigation">&#9776;</button>
    <nav>
        <ul>
            <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
            <li><a href="<?php echo $base; ?>buku/list.php">Daftar Buku</a></li>
            <li><a href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a></li>
            <li><a href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
            <li><a href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
        </ul>
    </nav>
</header>
<main>