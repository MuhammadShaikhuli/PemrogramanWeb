<?php
$page_title = "Daftar Anggota";
require_once __DIR__ . '/../includes/koneksi.php';
include_once __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarAnggota = $pdo->query("SELECT * FROM anggota ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <h2>Daftar Anggota</h2>
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>
    <div class="search-box">
        <label for="search-input">Cari Anggota</label>
        <input type="text" id="search-input" placeholder="Ketik nama atau No. Anggota...">
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No. Anggota</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($daftarAnggota)): ?>
                <tr>
                    <td colspan="5">Belum ada data anggota. Silakan tambah lewat menu "Tambah Anggota".</td>
                </tr>
            <?php else: ?>
                <?php foreach ($daftarAnggota as $anggota): ?>
                <tr>
                    <td><?php echo htmlspecialchars($anggota['no_anggota']); ?></td>
                    <td><?php echo htmlspecialchars($anggota['nama']); ?></td>
                    <td><?php echo htmlspecialchars($anggota['alamat'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($anggota['no_hp'] ?? '-'); ?></td>
                    <td>
                        <!-- Tautan Edit (<a>) yang disamakan gayanya lewat kelas btn-edit -->
                        <a href="edit.php?id=<?php echo $anggota['id']; ?>" class="btn-edit">Edit</a>
                        
                        <!-- Form Hapus berbasis POST dengan pengaman kelas form-hapus -->
                        <form class="form-hapus" method="post" action="hapus.php" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">
                            <button type="submit" class="btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php include_once __DIR__ . '/../includes/footer.php'; ?>