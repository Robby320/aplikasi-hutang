<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = md5($_POST['password']);

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
    if (mysqli_num_rows($cek) == 1) {
        $_SESSION['login'] = true;
        header("Location: index.php");
    } else {
        echo "<script>alert('Login gagal! Username atau password salah.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-page">
        <div class="login-box">
            <h2>Aplikasi Pencatatan Hutang</h2>
            <h2>Login</h2>

            <?php if (isset($error)) : ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>

            <form method="POST">
                <label for="username">Username</label>
                <input type="text" name="username" required>

                <label for="password">Password</label>
                <input type="password" name="password" required>

                <input type="submit" name="login" value="Login">
            </form>
        </div>
    </div>
</body>


</html>