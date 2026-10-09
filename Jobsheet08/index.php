<?php
$page_title = "Beranda";
require __DIR__ . '/includes/koneksi.php';
include __DIR__ . '/includes/header.php';

$totalBuku    = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$totalAnggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
?>
<section>
    <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
    <p>Gunakan menu di atas untuk mengelola data buku dan anggota.</p>
</section>

<section>
    <h2>Statistik Perpustakaan</h2>
    <article>
        <h3>Total Buku</h3>
        <p><?php echo $totalBuku; ?></p>
    </article>
    <article>
        <h3>Total Anggota</h3>
        <p><?php echo $totalAnggota; ?></p>
    </article>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>