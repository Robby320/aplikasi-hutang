<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';
$batas = 10;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$offset = ($halaman - 1) * $batas;
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Hutang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="logout-bar">
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
    <div class="container">
        <h2>Daftar Hutang</h2>
        <a class="btn tambah" href="tambah.php">+ Tambah Data</a>

        <form class="filter-form" method="GET">
            <input type="text" name="cari" placeholder="Cari nama..." value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">

            <select name="status">
                <option value="">-- Status --</option>
                <option value="Lunas" <?= (isset($_GET['status']) && $_GET['status'] == 'Lunas') ? 'selected' : '' ?>>Lunas</option>
                <option value="Belum" <?= (isset($_GET['status']) && $_GET['status'] == 'Belum') ? 'selected' : '' ?>>Belum</option>
            </select>

            <input type="date" name="tanggal_jatuh" value="<?= isset($_GET['tanggal_jatuh']) ? $_GET['tanggal_jatuh'] : '' ?>">

            <button type="submit" class="btn">Filter</button>
            <a href="index.php" class="btn reset">Reset</a>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Barang</th>
                    <th>Jumlah Uang</th>
                    <th>Tanggal Hutang</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $where = [];

                if (!empty($_GET['cari'])) {
                    $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);
                    $where[] = "nama LIKE '%$cari%'";
                }

                if (!empty($_GET['status'])) {
                    $status = mysqli_real_escape_string($koneksi, $_GET['status']);
                    $where[] = "status = '$status'";
                }

                if (!empty($_GET['tanggal_jatuh'])) {
                    $tgl = mysqli_real_escape_string($koneksi, $_GET['tanggal_jatuh']);
                    $where[] = "tanggal_jatuh = '$tgl'";
                }

                $query = "SELECT * FROM data_hutang";
                if (count($where) > 0) {
                    $query .= " WHERE " . implode(" AND ", $where);
                }
                $query .= " ORDER BY id DESC LIMIT $offset, $batas";

                $result = mysqli_query($koneksi, $query);
                // Hitung total data untuk pagination
                $query_count = "SELECT COUNT(*) as total FROM data_hutang";
                if (count($where) > 0) {
                    $query_count .= " WHERE " . implode(" AND ", $where);
                }
                $result_count = mysqli_query($koneksi, $query_count);
                $row_count = mysqli_fetch_assoc($result_count);
                $total_data = $row_count['total'];
                $total_halaman = ceil($total_data / $batas);


                if (mysqli_num_rows($result) > 0) {
                    while ($data = mysqli_fetch_assoc($result)) {
                        $id = $data['id'];
                        echo "<tr>";
                        echo "<td>{$data['nama']}</td>";
                        echo "<td>{$data['alamat']}</td>";

                        // Barang
                        $barang_q = mysqli_query($koneksi, "SELECT * FROM detail_barang WHERE id_hutang = $id");
                        echo "<td>";
                        while ($b = mysqli_fetch_assoc($barang_q)) {
                            echo "- {$b['nama_barang']} ({$b['jumlah_barang']})<br>";
                        }
                        echo "</td>";

                        echo "<td>Rp " . number_format($data['jumlah_uang'], 0, ',', '.') . "</td>";
                        echo "<td>{$data['tanggal_hutang']}</td>";
                        echo "<td>{$data['tanggal_jatuh']}</td>";
                        echo "<td>{$data['status']}</td>";
                        echo "<td>
                            <a class='btn edit' href='edit.php?id={$data['id']}'>Edit</a>
                            <a class='btn hapus' href='hapus.php?id={$data['id']}' onclick=\"return confirm('Yakin hapus data ini?')\">Hapus</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Data tidak ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <?php if ($total_halaman > 1): ?>
            <div class="pagination">
                <?php
                $prev = $halaman - 1;
                $next = $halaman + 1;
                $params = $_GET;
                ?>

                <?php if ($halaman > 1): ?>
                    <a href="?<?= http_build_query(array_merge($params, ['halaman' => $prev])) ?>">←</a>
                <?php endif; ?>

                <span><?= $halaman ?></span>

                <?php if ($halaman < $total_halaman): ?>
                    <a href="?<?= http_build_query(array_merge($params, ['halaman' => $next])) ?>">→</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>

</body>

</html>