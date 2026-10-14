<?php
$page_title = "Edit Anggota";
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

// Ambil data lama anggota berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
$stmt->execute(['id' => $id]);
$anggota = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika anggota tidak ditemukan, kembalikan ke list
if (!$anggota) {
    header('Location: list.php');
    exit;
}
?>

<section>
    <h2>Edit Anggota</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_edit.php">
        <!-- Kotak tersembunyi untuk membawa ID baris yang diubah -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($anggota['id']); ?>">

        <div>
            <label for="no_anggota">No. Anggota / NIM:</label>
            <input type="text" id="no_anggota" name="no_anggota" value="<?php echo htmlspecialchars($anggota['no_anggota']); ?>" required>
        </div>

        <div>
            <label for="nama">Nama Lengkap:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($anggota['nama']); ?>" required>
        </div>

        <div>
            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($anggota['alamat'] ?? ''); ?>">
        </div>

        <div>
            <label for="no_hp">No. HP:</label>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($anggota['no_hp'] ?? ''); ?>">
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
</section>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>