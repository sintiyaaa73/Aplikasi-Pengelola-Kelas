<?php
session_start(); // Memulai sesi

include('include/koneksi.php');

if(isset($_POST['login'])) { 
    // Proses login
    $email = mysqli_real_escape_string($koneksi, htmlentities($_POST['email']));
    $pass  = mysqli_real_escape_string($koneksi, htmlentities(md5($_POST['password'])));

    $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email' AND password='$pass'") or die(mysqli_error($koneksi));
    if(mysqli_num_rows($sql) == 0){
        echo '<center><span>User tidak ditemukan</span></center>';
    }else{
        $row = mysqli_fetch_assoc($sql);
        if($row){
            $_SESSION['email'] = $email;
            header("Location: admin/index.php");
            exit(); // Menghentikan eksekusi setelah redirect
        }else{
            echo '<center><div class="alert alert-danger">Upss...!!! Login gagal.</div></center>';
        }
    }
}
?>

<!DOCTYPE html> 
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body style="background: url('image/vokasi.png') no-repeat center center fixed; background-size: cover;">
    <div class="halaman">
        <div class="login-container">
            <div class="icon">
                <i class="fas fa-door-open"></i>
            </div>
            <h2>Login</h2>
            <!-- Form login -->
            <form method="post" action="">
                <input class="kotak" type="text" name="email" placeholder="Email" required="">
                <input class="kotak" type="password" name="password" placeholder="Password" required="">
                <button type="submit" name="login" class="kotak">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
