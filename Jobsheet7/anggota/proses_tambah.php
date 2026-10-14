<?php
session_start();

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

if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

$_SESSION['anggota'][] = [
    'no_anggota'    => $no_anggota,
    'nama'          => $nama,
    'alamat'        => $alamat,
    'no_hp'         => $no_hp,
    'jenis_kelamin' => $jenis_kelamin,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;