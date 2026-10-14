<?php
$page_title = "Daftar Buku";
require_once __DIR__ . '/../includes/koneksi.php';
include_once __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// 1. Konfigurasi Pagination & Pencarian
$perPage = 3; // 5 baris per halaman
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

// 2. Query berdasarkan ada/tidaknya kata kunci pencarian
if ($keyword !== '') {
    // Hitung total baris yang sesuai dengan pencarian (Judul OR Pengarang)
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE judul ILIKE :kw1 OR pengarang ILIKE :kw2");
    $hitung->execute([
        'kw1' => '%' . $keyword . '%',
        'kw2' => '%' . $keyword . '%'
    ]);
    $totalRows = $hitung->fetchColumn();

    // Ambil data buku dengan LIMIT, OFFSET, dan pencarian multi-kolom (ILIKE ... OR ...)
    $stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :kw1 OR pengarang ILIKE :kw2 ORDER BY id DESC LIMIT :limit OFFSET :offset");
    
    // Bind nilai untuk pencarian
    $stmt->bindValue('kw1', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->bindValue('kw2', '%' . $keyword . '%', PDO::PARAM_STR);
    
    // Bind nilai untuk pagination (Wajib PDO::PARAM_INT)
    $stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Query standar jika tidak ada kata kunci pencarian
    $totalRows = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM buku ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 3. Hitung total halaman (minimal 1)
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

<section>
    <h2>Daftar Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <!-- Form Pencarian Sisi Server (method="get") -->
    <form method="get" action="list.php" class="search-box">
        <span>
            <label for="search-input">Cari Judul Buku</label>
            <input type="text" id="search-input" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Ketik judul buku lalu tekan Cari...">
        </span>
        <button type="submit">Cari</button>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Tanggal Ditambahkan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($daftarBuku)): ?>
                <tr>
                    <td colspan="6">Belum ada data buku yang sesuai.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($daftarBuku as $buku): ?>
                <tr>
                    <td><?php echo htmlspecialchars($buku['judul']); ?></td>
                    <td><?php echo htmlspecialchars($buku['pengarang']); ?></td>
                    <td><?php echo htmlspecialchars($buku['tahun']); ?></td>
                    <td><?php echo htmlspecialchars($buku['stok']); ?></td>
                    <td><?php echo !empty($buku['tanggal_ditambahkan']) ? date('d-m-Y H:i', strtotime($buku['tanggal_ditambahkan'])) : '-'; ?></td>
                    <td>
                        <!-- Tautan Edit -->
                        <a href="edit.php?id=<?php echo $buku['id']; ?>" class="btn-edit">Edit</a>
                        
                        <!-- Form Hapus (POST) -->
                        <form class="form-hapus" method="post" action="hapus.php" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
                            <button type="submit" class="btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- 4. Navigasi Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav class="pagination" style="margin-top: 1rem; display: flex; gap: 0.5rem;">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>" 
                   class="<?php echo $i === $page ? 'active' : ''; ?>"
                   style="padding: 0.4rem 0.75rem; border: 1px solid #cdd4da; border-radius: 4px; text-decoration: none; <?php echo $i === $page ? 'background-color: #8a521d; color: #fff;' : 'color: #8a521d;'; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </nav>
    <?php endif; ?>
</section>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>