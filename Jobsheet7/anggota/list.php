<?php
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarAnggota = $_SESSION['anggota'] ?? [];
?>

<section class="card shadow-sm">
  <div class="card-body">
    <h2 class="card-title mb-3" style="color:#1d5b8a;">Daftar Anggota</h2>

    <?php if ($flash): ?>
      <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
    <?php endif; ?>

    <div class="search-box">
      <label for="search-input">Cari Anggota</label>
      <input type="text" id="search-input" placeholder="Ketik nama anggota..." />
    </div>

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
                <td><button type="button" class="btn btn-warning btn-sm text-white">Edit</button></td>
                <td><button type="button" class="btn btn-danger btn-sm btn-hapus">Hapus</button></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>