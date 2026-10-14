<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

$totalBuku    = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$totalAnggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
?>

<section class="mb-4">
  <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
  <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan.</p>
</section>

<section>
  <h2 class="mb-3">Ringkasan</h2>
  <div class="row g-3">
    <div class="col-md-6 col-lg-3">
      <div class="card text-center h-100">
        <div class="card-body">
          <h5 class="card-title">Total Buku</h5>
          <p class="display-6"><?php echo $totalBuku; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="card text-center h-100">
        <div class="card-body">
          <h5 class="card-title">Total Anggota</h5>
          <p class="display-6"><?php echo $totalAnggota; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="card text-center h-100">
        <div class="card-body">
          <h5 class="card-title">Sedang Dipinjam</h5>
          <p class="display-6">3</p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="card text-center h-100">
        <div class="card-body">
          <h5 class="card-title">Buku Terlambat</h5>
          <p class="display-6">1</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>