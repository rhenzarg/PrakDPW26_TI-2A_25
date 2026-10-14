<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section class="card shadow-sm">
  <div class="card-body">
    <h2 class="card-title mb-3" style="color:#1d5b8a;">Tambah Anggota</h2>

    <?php if ($flash): ?>
      <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_tambah.php" novalidate>
      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" required />
      </div>

      <div class="mb-3">
        <label for="no_anggota" class="form-label">No. Anggota</label>
        <input type="text" class="form-control" id="no_anggota" name="no_anggota" required />
      </div>

      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <input type="text" class="form-control" id="alamat" name="alamat" />
      </div>

      <div class="mb-3">
        <label for="no_hp" class="form-label">No. HP</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" />
      </div>

      <div class="mb-3">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
          <option value="P">Perempuan</option>
          <option value="L">Laki-Laki</option>
        </select>
      </div>

      <button type="submit" class="btn" style="background-color:#1d5b8a; color:#fff;">Simpan</button>
    </form>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>