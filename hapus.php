<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus barang terlebih dahulu
    mysqli_query($koneksi, "DELETE FROM detail_barang WHERE id_hutang = $id");

    // Hapus data hutangnya
    mysqli_query($koneksi, "DELETE FROM data_hutang WHERE id = $id");

    echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
} else {
    echo "ID tidak ditemukan.";
}
