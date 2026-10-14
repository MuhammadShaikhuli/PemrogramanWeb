<?php
$page_title = "Edit Buku";
require_once __DIR__ . '/../includes/koneksi.php';
include_once __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

// Ambil data lama buku berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika buku tidak ditemukan, kembalikan ke list
if (!$buku) {
    header('Location: list.php');
    exit;
}
?>

<section>
    <h2>Edit Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_edit.php">
        
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($buku['id']); ?>">

        <div>
            <label for="judul">Judul Buku:</label>
            <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($buku['judul']); ?>" required>
        </div>

        <div>
            <label for="pengarang">Pengarang:</label>
            <input type="text" id="pengarang" name="pengarang" value="<?php echo htmlspecialchars($buku['pengarang']); ?>" required>
        </div>

        <div>
            <label for="tahun">Tahun Terbit:</label>
            <input type="number" id="tahun" name="tahun" value="<?php echo htmlspecialchars($buku['tahun']); ?>" required>
        </div>

        <div>
            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($buku['isbn'] ?? ''); ?>">
        </div>

        <div>
            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars($buku['stok']); ?>" required>
        </div>

        <div>
            <label for="kategori">Kategori:</label>
            <select id="kategori" name="kategori">
                <?php 
                $kategori_opsi = ['fiksi' => 'Fiksi', 'non-fiksi' => 'Non-Fiksi', 'referensi' => 'Referensi'];
                foreach ($kategori_opsi as $value => $label): 
                ?>
                    <option value="<?php echo $value; ?>" <?php echo ($buku['kategori'] === $value) ? 'selected' : ''; ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
</section>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>