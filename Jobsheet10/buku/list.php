<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// --- Pagination & pencarian server-side ---
$perPage = 5;
$keyword = trim($_GET['q'] ?? '');
$page    = max(1, (int) ($_GET['page'] ?? 1));

// 1) Hitung total baris (mengikuti pencarian)
if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE judul ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = (int) $hitung->fetchColumn();
} else {
    $totalRows = (int) $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
}

$totalPages = max(1, (int) ceil($totalRows / $perPage));
$page       = min($page, $totalPages);          // cegah ?page=999
$offset     = ($page - 1) * $perPage;

// 2) Ambil data untuk halaman ini
if ($keyword !== '') {
    $stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $stmt = $pdo->prepare("SELECT * FROM buku ORDER BY id DESC LIMIT :limit OFFSET :offset");
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);

$qs = $keyword !== '' ? '&q=' . urlencode($keyword) : '';
?>

<section>
  <h2 class="mb-3">Daftar Buku</h2>

  <?php if ($flash): ?>
    <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
  <?php endif; ?>

  <form method="get" action="list.php" class="search-box d-flex gap-2 align-items-end mb-3">
    <span>
      <label for="search-input">Cari Judul Buku</label><br>
      <input type="text" id="search-input" name="q" value="<?php echo e($keyword); ?>" placeholder="Ketik judul buku..." />
    </span>
    <button type="submit" class="btn btn-sm" style="background-color:#1d5b8a; color:#fff;">Cari</button>
  </form>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-success">
        <tr>
          <th>Judul</th>
          <th>Pengarang</th>
          <th>Tahun</th>
          <th>Stok</th>
          <?php if ($sudahLogin): ?><th>Aksi</th><?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($daftarBuku)): ?>
          <tr>
            <td colspan="<?php echo $sudahLogin ? 5 : 4; ?>">Belum ada data buku. Silakan tambah <?php echo $sudahLogin ? 'lewat menu "Tambah Buku".' : ''; ?></td>
          </tr>
        <?php else: ?>
          <?php foreach ($daftarBuku as $buku): ?>
            <tr>
              <td><?php echo e($buku['judul']); ?></td>
              <td><?php echo e($buku['pengarang']); ?></td>
              <td><?php echo e($buku['tahun']); ?></td>
              <td><?php echo e($buku['stok']); ?></td>
              <?php if ($sudahLogin): ?>
              <td>
                <a href="edit.php?id=<?php echo (int) $buku['id']; ?>" class="btn btn-warning btn-sm text-white btn-edit">Edit</a>
                <button type="button" class="btn btn-info btn-sm">Detail</button>
                <form class="form-hapus d-inline" method="post" action="hapus.php"
                      data-nama="<?php echo e($buku['judul']); ?>">
                  <input type="hidden" name="id" value="<?php echo (int) $buku['id']; ?>">
                  <button type="submit" class="btn btn-danger btn-sm btn-hapus">Hapus</button>
                </form>
              </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <nav aria-label="Navigasi halaman">
    <ul class="pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
          <a class="page-link" href="list.php?page=<?php echo $i . $qs; ?>"><?php echo $i; ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>