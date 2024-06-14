<?php
session_start(); // Memulai sesi
include('../include/koneksi.php');

if (!isset($_SESSION['email'])) {
    // Jika sesi tidak ada, arahkan ke halaman login
    header("Location: ../login-koordinator.php");
    exit();
}

$email = $_SESSION['email']; // mengambil email dari session yang login

// Query untuk mengecek email
$cek = $koneksi->query("SELECT * FROM koordinator WHERE email='$email'");
if ($cek->num_rows == 0) {
    header("Location: ../login-koordinator.php");
    exit();
} else {
    $row = $cek->fetch_assoc();
    $nama = $row['nama'];
}
?>

<?php include('header.php'); // Menyertakan header ?>

<div class="judul">
    <div class="isi-judul"></div>
</div>
<div class="halaman1">
    <div class="isi-halaman">
        <div class="isi">
            <div class="artikel">
                <p>Selamat Datang <?php echo $nama; ?>.....</p>
            </div>
        </div>
        <div class="hapus"></div>
    </div>

<?php include('footer.php'); // Menyertakan footer ?>
