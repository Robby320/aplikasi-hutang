<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Data Hutang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h2>Tambah Data Hutang</h2>

        <form class="form-input" method="POST" action="">
            <label>Nama</label>
            <input type="text" name="nama" required>

            <label>Alamat</label>
            <textarea name="alamat" rows="3" required></textarea>

            <label>Tanggal Hutang</label>
            <input type="date" name="tanggal_hutang" required>

            <label>Tanggal Jatuh Tempo</label>
            <input type="date" name="tanggal_jatuh" required>

            <label>Status</label>
            <select name="status" required>
                <option value="Belum">Belum</option>
                <option value="Lunas">Lunas</option>
            </select>

            <label>Jumlah Uang (Total)</label>
            <input type="number" name="jumlah_uang" required>

            <label>Barang yang Dihutang:</label>
            <div id="barang-list">
                <div class="form-barang">
                    <input type="text" name="nama_barang[]" placeholder="Nama Barang" required>
                    <input type="number" name="jumlah_barang[]" placeholder="Jumlah" required>
                </div>
            </div>

            <button type="button" onclick="tambahBarang()">+ Tambah Barang</button><br><br>

            <input type="submit" name="simpan" value="Simpan Data">
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
if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tanggal_hutang = $_POST['tanggal_hutang'];
    $tanggal_jatuh  = $_POST['tanggal_jatuh'];
    $status = $_POST['status'];
    $jumlah_uang = $_POST['jumlah_uang'];

    mysqli_query($koneksi, "INSERT INTO data_hutang (nama, alamat, tanggal_hutang, tanggal_jatuh, status, jumlah_uang) 
        VALUES ('$nama', '$alamat', '$tanggal_hutang', '$tanggal_jatuh', '$status', '$jumlah_uang')");

    $id_hutang = mysqli_insert_id($koneksi);

    foreach ($_POST['nama_barang'] as $i => $barang) {
        $jumlah = $_POST['jumlah_barang'][$i];
        mysqli_query($koneksi, "INSERT INTO detail_barang (id_hutang, nama_barang, jumlah_barang) 
            VALUES ('$id_hutang', '$barang', '$jumlah')");
    }

    echo "<script>alert('Data berhasil disimpan!'); window.location='index.php';</script>";
}
?>