<?php
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// --- Pagination & pencarian server-side ---
$perPage = 5;
$keyword = trim($_GET['q'] ?? '');
$page    = max(1, (int) ($_GET['page'] ?? 1));

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM anggota WHERE nama ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = (int) $hitung->fetchColumn();
} else {
    $totalRows = (int) $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
}

$totalPages = max(1, (int) ceil($totalRows / $perPage));
$page       = min($page, $totalPages);
$offset     = ($page - 1) * $perPage;

if ($keyword !== '') {
    $stmt = $pdo->prepare("SELECT * FROM anggota WHERE nama ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $stmt = $pdo->prepare("SELECT * FROM anggota ORDER BY id DESC LIMIT :limit OFFSET :offset");
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarAnggota = $stmt->fetchAll(PDO::FETCH_ASSOC);

$qs = $keyword !== '' ? '&q=' . urlencode($keyword) : '';
?>

<section class="card shadow-sm">
  <div class="card-body">
    <h2 class="card-title mb-3" style="color:#1d5b8a;">Daftar Anggota</h2>

    <?php if ($flash): ?>
      <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
    <?php endif; ?>

    <form method="get" action="list.php" class="search-box d-flex gap-2 align-items-end mb-3">
      <span>
        <label for="search-input">Cari Anggota</label><br>
        <input type="text" id="search-input" name="q" value="<?php echo e($keyword); ?>" placeholder="Ketik nama anggota..." />
      </span>
      <button type="submit" class="btn btn-sm" style="background-color:#1d5b8a; color:#fff;">Cari</button>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead style="background-color:#1d5b8a;">
          <tr class="text-white">
            <th rowspan="2">No. Anggota</th>
            <th rowspan="2">Nama</th>
            <th rowspan="2">Alamat</th>
            <th rowspan="2">No. HP</th>
            <th colspan="2">Jenis Kelamin</th>
            <th colspan="2">Aksi</th>
          </tr>
          <tr class="text-white">
            <th>Perempuan</th>
            <th>Laki-Laki</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($daftarAnggota)): ?>
            <tr>
              <td colspan="8">Belum ada data anggota. Silakan tambah lewat menu "Tambah Anggota".</td>
            </tr>
          <?php else: ?>
            <?php foreach ($daftarAnggota as $anggota): ?>
              <tr>
                <td><?php echo e($anggota['no_anggota']); ?></td>
                <td><?php echo e($anggota['nama']); ?></td>
                <td><?php echo e($anggota['alamat']); ?></td>
                <td><?php echo e($anggota['no_hp']); ?></td>
                <td><?php echo $anggota['jenis_kelamin'] === 'P' ? 'v' : ''; ?></td>
                <td><?php echo $anggota['jenis_kelamin'] === 'L' ? 'v' : ''; ?></td>
                <td>
                  <a href="edit.php?id=<?php echo (int) $anggota['id']; ?>" class="btn btn-warning btn-sm text-white btn-edit">Edit</a>
                </td>
                <td>
                  <form class="form-hapus d-inline" method="post" action="hapus.php"
                        data-nama="<?php echo e($anggota['nama']); ?>">
                    <input type="hidden" name="id" value="<?php echo (int) $anggota['id']; ?>">
                    <button type="submit" class="btn btn-danger btn-sm btn-hapus">Hapus</button>
                  </form>
                </td>
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
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>