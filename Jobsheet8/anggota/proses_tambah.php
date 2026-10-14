<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$nama          = trim($_POST['nama'] ?? '');
$no_anggota    = trim($_POST['no_anggota'] ?? '');
$alamat        = trim($_POST['alamat'] ?? '');
$no_hp         = trim($_POST['no_hp'] ?? '');
$jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');

$errors = [];

if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($no_anggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
}
if ($no_hp !== '' && !preg_match('/^[0-9+\-x]+$/', $no_hp)) {
    $errors[] = "No. HP hanya boleh berisi angka.";
}
if (!in_array($jenis_kelamin, ['L', 'P'], true)) {
    $errors[] = "Jenis kelamin tidak valid.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO anggota (nama, no_anggota, alamat, no_hp, jenis_kelamin)
         VALUES (:nama, :no_anggota, :alamat, :no_hp, :jenis_kelamin)
         RETURNING id"
    );
    $stmt->execute([
        'nama'          => $nama,
        'no_anggota'    => $no_anggota,
        'alamat'        => $alamat,
        'no_hp'         => $no_hp,
        'jenis_kelamin' => $jenis_kelamin,
    ]);
} catch (PDOException $e) {
    // Kode 23505 = pelanggaran UNIQUE (no_anggota kembar)
    if ($e->getCode() === '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'No. Anggota sudah dipakai, gunakan nomor lain.'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menyimpan data anggota.'];
    }
    header('Location: tambah.php');
    exit;
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;