<?php
$page_title = "Edit Anggota";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
$stmt->execute(['id' => $id]);
$anggota = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$anggota) {
    header('Location: list.php');
    exit;
}
?>

<section class="card shadow-sm">
  <div class="card-body">
    <h2 class="card-title mb-3" style="color:#1d5b8a;">Edit Anggota</h2>

    <?php if ($flash): ?>
      <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_edit.php" novalidate>
      <input type="hidden" name="id" value="<?php echo (int) $anggota['id']; ?>">

      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo e($anggota['nama']); ?>" required />
      </div>

      <div class="mb-3">
        <label for="no_anggota" class="form-label">No. Anggota</label>
        <input type="text" class="form-control" id="no_anggota" name="no_anggota" value="<?php echo e($anggota['no_anggota']); ?>" required />
      </div>

      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo e($anggota['alamat']); ?>" />
      </div>

      <div class="mb-3">
        <label for="no_hp" class="form-label">No. HP</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo e($anggota['no_hp']); ?>" />
      </div>

      <div class="mb-3">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
          <?php foreach (['P' => 'Perempuan', 'L' => 'Laki-Laki'] as $value => $label): ?>
            <option value="<?php echo $value; ?>" <?php echo $anggota['jenis_kelamin'] === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn" style="background-color:#1d5b8a; color:#fff;">Simpan Perubahan</button>
      <a href="list.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>