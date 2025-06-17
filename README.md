# 📘 Aplikasi Pencatatan Hutang

Aplikasi sederhana berbasis web untuk mencatat dan mengelola hutang seseorang, dilengkapi dengan detail barang yang dihitung, tanggal jatuh tempo, dan status pelunasan.

---

## ✨ Fitur Utama

- 🔐 Login sistem (dengan validasi username dan password)
- ➕ Tambah data hutang (termasuk alamat, tanggal, dan barang)
- ✏️ Edit dan 🗑️ hapus data
- 🔍 Filter data berdasarkan nama, status, atau tanggal jatuh tempo
- 📄 Tabel data dengan paginasi (maks 10 data per halaman)
- 📦 Penambahan beberapa barang per transaksi
- 📤 Logout user
- 💡 Tampilan bersih dan responsif

---

## 💻 Teknologi yang Digunakan

- HTML + CSS
- PHP (native)
- MySQL (struktur database sederhana)
- JavaScript (untuk tambah barang dinamis)

---

## ⚙️ Cara Install dan Jalankan

1. **Clone repo atau download zip**
2. **Import database**
   - Buka phpMyAdmin
   - Buat database misalnya `db_hutang`
   - Import file `data_hutang.sql` (terlampir)
3. **Konfigurasi koneksi**
   - Buka `koneksi.php`, sesuaikan:
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "hutang_barang";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

4. **Login**
   - Username: `admin`
   - Password: `admin123` *(disimpan dalam md5 di database)*

---

![gambar](https://github.com/user-attachments/assets/bf9ad903-1f11-46e2-91c4-cd36dd86cf11)


## 🚀 Rencana Pengembangan (Opsional)

- Export data ke PDF
- Notifikasi tempo jatuh tempo
- Sistem multi user
- Tampilan mobile responsive penuh

---

## 👤 Developer

- **Nama:** Robby Fernando
- **Posisi:** Fresh Graduate / Calon IT Support / UI Enthusiast
- **Kontak:** (opsional, bisa isi email atau LinkedIn)

---

## 📝 Lisensi

Proyek ini dibuat untuk pembelajaran dan portofolio pribadi. Bebas digunakan dan dimodifikasi.
