<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sudahLogin = isset($_SESSION['user_id']);

$__jobsheetRoot = dirname(__DIR__);
$__scriptDir    = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel  = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base   = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);

$halaman = ($__rel === '' ? '' : $__rel . '/') . basename($_SERVER['SCRIPT_FILENAME']);

function e($teks) {
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SIMPUS-Mini<?php echo isset($page_title) ? ' | ' . e($page_title) : ''; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css" />
  </head>

  <body>
    <header class="navbar navbar-expand-lg navbar-dark" style="background-color:#1d5b8a;">
      <div class="container">
        <a class="navbar-brand fw-semibold" href="<?php echo $base; ?>index.php">SIMPUS-Mini</a>

        <button class="navbar-toggler" type="button" id="nav-toggle-btn" aria-label="Menu">
          <span class="navbar-toggler-icon"></span>
        </button>

        <nav class="collapse navbar-collapse" id="navMenu">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link <?php echo $halaman === 'index.php' ? 'active' : ''; ?>" href="<?php echo $base; ?>index.php">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo $halaman === 'buku/list.php' ? 'active' : ''; ?>" href="<?php echo $base; ?>buku/list.php">Daftar Buku</a>
            </li>
            <?php if ($sudahLogin): ?>
            <li class="nav-item">
              <a class="nav-link <?php echo $halaman === 'buku/tambah.php' ? 'active' : ''; ?>" href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo $halaman === 'anggota/list.php' ? 'active' : ''; ?>" href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo $halaman === 'anggota/tambah.php' ? 'active' : ''; ?>" href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a>
            </li>
            <?php endif; ?>
          </ul>

          <div class="auth-status ms-lg-3">
            <?php if ($sudahLogin): ?>
              <span><?php echo e($_SESSION['nama']); ?></span>
              <a href="<?php echo $base; ?>auth/logout.php">Logout</a>
            <?php else: ?>
              <a href="<?php echo $base; ?>auth/login.php">Login</a>
            <?php endif; ?>
          </div>
        </nav>
      </div>
    </header>

    <main class="container my-4">