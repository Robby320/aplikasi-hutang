<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM data_hutang WHERE id = $id"));
$barang = mysqli_query($koneksi, "SELECT * FROM detail_barang WHERE id_hutang = $id");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Hutang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h2>Edit Data Hutang</h2>

        <form class="form-input" method="POST" action="">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= $data['nama'] ?>" required>

            <label>Alamat</label>
            <textarea name="alamat" rows="3" required><?= $data['alamat'] ?></textarea>

            <label>Tanggal Hutang</label>
            <input type="date" name="tanggal_hutang" value="<?= $data['tanggal_hutang'] ?>" required>

            <label>Tanggal Jatuh Tempo</label>
            <input type="date" name="tanggal_jatuh" value="<?= $data['tanggal_jatuh'] ?>" required>

            <label>Status</label>
            <select name="status" required>
                <option value="Belum" <?= $data['status'] == 'Belum' ? 'selected' : '' ?>>Belum</option>
                <option value="Lunas" <?= $data['status'] == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
            </select>

            <label>Jumlah Uang</label>
            <input type="number" name="jumlah_uang" value="<?= $data['jumlah_uang'] ?>" required>

            <label>Barang yang Dihutang:</label>
            <div id="barang-list">
                <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
                    <div class="form-barang">
                        <input type="text" name="nama_barang[]" value="<?= $b['nama_barang'] ?>" required>
                        <input type="number" name="jumlah_barang[]" value="<?= $b['jumlah_barang'] ?>" required>
                    </div>
                <?php } ?>
            </div>

            <button type="button" onclick="tambahBarang()">+ Tambah Barang</button><br><br>

            <input type="submit" name="update" value="Update Data">
        </form>

        <a href="index.php" class="btn-kembali">← Kembali ke Daftar</a>
    </div>

    <script>
        function tambahBarang() {
            const barangList = document.getElementById('barang-list');
            const div = document.createElement('div');
            div.classList.add('form-barang');
            div.innerHTML = `
            <input type="text" name="nama_barang[]" placeholder="Nama Barang" required>
            <input type="number" name="jumlah_barang[]" placeholder="Jumlah" required>
            <button type="button" class="hapus-barang" onclick="hapusBarang(this)">Hapus</button>
        `;
            barangList.appendChild(div);
        }

        function hapusBarang(button) {
            const item = button.parentElement;
            item.remove();
        }
    </script>


</body>

</html>

<?php
if (isset($_POST['update'])) {
    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tanggal_hutang = $_POST['tanggal_hutang'];
    $tanggal_jatuh  = $_POST['tanggal_jatuh'];
    $status = $_POST['status'];
    $jumlah_uang = $_POST['jumlah_uang'];

    mysqli_query($koneksi, "UPDATE data_hutang SET 
        nama='$nama',
        alamat='$alamat',
        tanggal_hutang='$tanggal_hutang',
        tanggal_jatuh='$tanggal_jatuh',
        status='$status',
        jumlah_uang='$jumlah_uang'
        WHERE id = $id");

    mysqli_query($koneksi, "DELETE FROM detail_barang WHERE id_hutang = $id");

    foreach ($_POST['nama_barang'] as $i => $barang) {
        $jumlah = $_POST['jumlah_barang'][$i];
        mysqli_query($koneksi, "INSERT INTO detail_barang (id_hutang, nama_barang, jumlah_barang) 
            VALUES ('$id', '$barang', '$jumlah')");
    }

    echo "<script>alert('Data berhasil diupdate!'); window.location='index.php';</script>";
}
?>