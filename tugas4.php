<?php
// Pastikan dijalankan via CLI
if (php_sapi_name() != "cli") {
    die("Jalankan di CLI!\n");
}

// Koneksi PDO
$host = "localhost";
$db   = "kampus_db";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Koneksi berhasil!\n\n";
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

echo "=== DATA MAHASISWA ===\n\n";

// ==============================
// SHOW DATA
// ==============================
$stmt = $pdo->prepare("SELECT * FROM mahasiswa ORDER BY id ASC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$data) {
    echo "Tidak ada data.\n";
    exit;
}

// tampilkan semua data
foreach ($data as $row) {
    echo "ID: {$row['id']} | Nama: {$row['nama']} | Jurusan: {$row['jurusan']}\n";
}

echo "\n=============================\n";

// ==============================
// PILIH DATA UNTUK UPDATE
// ==============================
echo "Masukkan ID yang ingin diupdate (default: 1): ";
$id = trim(fgets(STDIN));

// 🔥 TAMBAHAN DI SINI
if (empty($id)) {
    $id = 1; // otomatis pakai ID 1 kalau kosong
}

if (!is_numeric($id)) {
    echo "ID harus angka!\n";
    exit;
}

// ambil data berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE id = ?");
$stmt->execute([$id]);
$mhs = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mhs) {
    echo "Data tidak ditemukan!\n";
    exit;
}

// ==============================
// TAMPILKAN DATA LAMA
// ==============================
echo "\nData lama:\n";
echo "ID      : {$mhs['id']}\n"; // 🔥 tampilkan ID juga
echo "Nama    : {$mhs['nama']}\n";
echo "Jurusan : {$mhs['jurusan']}\n\n";

// ==============================
// INPUT DATA BARU
// ==============================
echo "Nama baru ({$mhs['nama']}): ";
$nama = trim(fgets(STDIN)) ?: $mhs['nama'];

echo "Jurusan baru ({$mhs['jurusan']}): ";
$jurusan = trim(fgets(STDIN)) ?: $mhs['jurusan'];

// ==============================
// UPDATE DATA
// ==============================
$sql = "UPDATE mahasiswa SET nama = ?, jurusan = ? WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nama, $jurusan, $id]);

// ==============================
// HASIL
// ==============================
if ($stmt->rowCount() > 0) {
    echo "\nData berhasil diupdate!\n";
} else {
    echo "\nTidak ada perubahan data.\n";
}
?>