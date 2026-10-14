<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Registrasi Petugas";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section class="card shadow-sm mx-auto" style="max-width:480px;">
  <div class="card-body">
    <h2 class="card-title mb-3" style="color:#1d5b8a;">Registrasi Petugas</h2>

    <?php if ($flash): ?>
      <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
    <?php endif; ?>

    <form method="post" action="proses_register.php">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama" name="nama" required />
      </div>

      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" maxlength="50" required />
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" minlength="6" required />
        <div class="form-text">Minimal 6 karakter.</div>
      </div>

      <button type="submit" class="btn" style="background-color:#1d5b8a; color:#fff;">Daftar</button>
      <p class="mt-3 mb-0">Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </form>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
