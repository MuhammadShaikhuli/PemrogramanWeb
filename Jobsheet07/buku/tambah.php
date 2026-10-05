<?php
$page_title = "Tambah Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
    <h2>Tambah Buku Baru</h2>
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_tambah.php">
        <div>
            <label for="judul">Judul Buku:</label>
            <input type="text" id="judul" name="judul">
        </div>
        <div>
            <label for="pengarang">Pengarang:</label>
            <input type="text" id="pengarang" name="pengarang">
        </div>
        <div>
            <label for="tahun">Tahun Terbit:</label>
            <input type="number" id="tahun" name="tahun">
        </div>
        <div>
            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn">
        </div>
        <div>
            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stok">
        </div>
        <div>
            <label for="kategori">Kategori:</label>
            <input type="text" id="kategori" name="kategori">
        </div>
        <button type="submit">Simpan</button>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>