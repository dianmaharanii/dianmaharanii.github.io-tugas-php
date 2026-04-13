<?php
// Koneksi PDO
$host = "localhost";
$db   = "kampus_db";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// ==============================
// PROSES UPDATE
// ==============================
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];

    $sql = "UPDATE mahasiswa SET nama = ?, jurusan = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama, $jurusan, $id]);

    $pesan = "Data berhasil diupdate!";
}

// ==============================
// AMBIL DATA
// ==============================
$stmt = $pdo->query("SELECT * FROM mahasiswa ORDER BY id ASC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ambil data berdasarkan ID (jika dipilih)
$editData = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE id = ?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
</head>
<body>

<h2>=== DATA MAHASISWA ===</h2>

<?php if (isset($pesan)) echo "<p>$pesan</p>"; ?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Jurusan</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($data as $row): ?>
    <tr>
        <td><?= $row['id']; ?></td>
        <td><?= $row['nama']; ?></td>
        <td><?= $row['jurusan']; ?></td>
        <td>
            <a href="?id=<?= $row['id']; ?>">Edit</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<hr>

<h3>=== UPDATE DATA ===</h3>

<form method="POST">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

    <label>Nama:</label><br>
    <input type="text" name="nama" value="<?= $editData['nama'] ?? '' ?>"><br><br>

    <label>Jurusan:</label><br>
    <input type="text" name="jurusan" value="<?= $editData['jurusan'] ?? '' ?>"><br><br>

    <button type="submit" name="update">Update</button>
</form>

</body>
</html>