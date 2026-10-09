<?php
require __DIR__ . '/includes/koneksi.php';

$jsonPath = __DIR__ . '/data/buku.json';

if (!file_exists($jsonPath)) {
    die("File data/buku.json tidak ditemukan!");
}

$jsonData = file_get_contents($jsonPath);
$bukuList = json_decode($jsonData, true);

if (empty($bukuList)) {
    die("Data JSON kosong atau format tidak valid.");
}

$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, stok)
     VALUES (:judul, :pengarang, :tahun, :stok)"
);

$berhasil = 0;

foreach ($bukuList as $buku) {
    $stmt->execute([
        'judul'     => $buku['judul'] ?? '',
        'pengarang' => $buku['pengarang'] ?? '',
        'tahun'     => (int) ($buku['tahun'] ?? 0),
        'stok'      => (int) ($buku['stok'] ?? 0),
    ]);
    $berhasil++;
}

echo "Migrasi selesai! Total $berhasil data buku berhasil dipindahkan ke PostgreSQL.";