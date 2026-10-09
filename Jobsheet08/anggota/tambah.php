<?php
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
    <h2>Tambah Anggota Baru</h2>
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>
    <form id="form-tambah" method="post" action="proses_tambah.php">
    <div>
        <label for="nim">NIM / ID Anggota:</label>
        <input type="text" id="nim" name="nim">
    </div>
    <div>
        <label for="nama">Nama Lengkap:</label>
        <input type="text" id="nama" name="nama">
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
    </div>
    <div>
        <label for="jurusan">Jurusan: </label>
        <input type="text" id="jurusan" name="jurusan">
    </div>
    <button type="submit">Simpan</button>
</form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>