<?php
$page_title = "Edit Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    header('Location: list.php');
    exit;
}
?>

<section class="card shadow-sm">
  <div class="card-body">
    <h2 class="card-title mb-3" style="color:#1d5b8a;">Edit Buku</h2>

    <?php if ($flash): ?>
      <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_edit.php" novalidate>
      <input type="hidden" name="id" value="<?php echo (int) $buku['id']; ?>">

      <div class="mb-3">
        <label for="judul" class="form-label">Judul</label>
        <input type="text" class="form-control" id="judul" name="judul" value="<?php echo e($buku['judul']); ?>" required />
      </div>

      <div class="mb-3">
        <label for="pengarang" class="form-label">Pengarang</label>
        <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?php echo e($buku['pengarang']); ?>" required />
      </div>

      <div class="mb-3">
        <label for="tahun" class="form-label">Tahun Terbit</label>
        <input type="number" class="form-control" id="tahun" name="tahun" min="1900" max="2026" value="<?php echo e($buku['tahun']); ?>" required />
      </div>

      <div class="mb-3">
        <label for="isbn" class="form-label">ISBN</label>
        <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo e($buku['isbn']); ?>" />
      </div>

      <div class="mb-3">
        <label for="stok" class="form-label">Stok</label>
        <input type="number" class="form-control" id="stok" name="stok" min="0" value="<?php echo e($buku['stok']); ?>" required />
      </div>

      <div class="mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <select class="form-select" id="kategori" name="kategori">
          <?php foreach (['fiksi' => 'Fiksi', 'non-fiksi' => 'Non-Fiksi', 'referensi' => 'Referensi'] as $value => $label): ?>
            <option value="<?php echo $value; ?>" <?php echo $buku['kategori'] === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn" style="background-color:#1d5b8a; color:#fff;">Simpan Perubahan</button>
      <a href="list.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>