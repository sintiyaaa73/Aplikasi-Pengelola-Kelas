<?php 
include('../include/koneksi.php');
session_start();
  
// Pastikan variabel email telah diinisialisasi dari sesi
if (!isset($_SESSION['email'])) {
    // Redirect jika email belum diset (belum login)
    header("Location: login-koordinator.php");
    exit();
}

$email = $_SESSION['email'];
?>

<?php include('header.php');?>

<style>
    .judul {
        color: #DC5F00;
        padding: 20px;
    }
    .isi-judul {
        margin: 0;
        font-size: 24px;
    }
    .halaman1 {
        padding: 20px;
    }
    .isi-halaman {
        background-color: #EEEEEE;
        padding: 20px;
        border-radius: 10px;
    }
    .artikel {
        margin-bottom: 20px;
    }
    .artikel h3 {
        margin: 0;
        font-size: 30px;
    }
    .tabel {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .tr1 {
        color: black;
    }
    .th1, .td1 {
        border: 5px solid #DC5F00;
        padding: 10px;
        text-align: left;
    }
    .th1 {
        font-weight: bold;
    }
    .td1 {
        border-bottom: 1px solid black;
    }
    .a {
        color: #DC5F00;
        text-decoration: none;
    }
    .a:hover {
        color: #fff;
    }
    .box {
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: calc(100% - 22px); /* Adjusting for padding and border */
    }
    .box[type="button"], .box[type="submit"], .box[type="reset"] {
        background-color: #DC5F00;
        color: white;
        cursor: pointer;
        width: 100px; /* Adjust the width */
    }
    .box[type="button"]:hover, .box[type="submit"]:hover, .box[type="reset"]:hover {
        background-color: #555;
    }
</style>

<?php
    if (isset($_POST['simpan'])) {
        $id_koordinator = $_POST['id_koordinator'];
        $id_ruangan     = $_POST['id_ruangan'];
        $komentar       = $_POST['komentar'];
        $tanggal        = $_POST['tanggal'];

        $insert = $koneksi->query("INSERT INTO komentar(id_koordinator, id_ruangan, komentar, tanggal) VALUES('$id_koordinator','$id_ruangan','$komentar','$tanggal')") or die(mysqli_error($koneksi));
        if($insert){
            $pesanko = "Terimakasih Telah Memberikan Saran.";
        }else{
            $pesanko = "Ups, Gagal Menberikan Saran!";
        }
    }else{
        $pesanko ="";
    }
?>

<?php
    if(isset($_GET['aksi']) && $_GET['aksi'] == 'aktif'){ 
        $id_ruangan = $_GET['id_ruangan'];

        $cek = $koneksi->query("SELECT * FROM ruangan WHERE id_ruangan='$id_ruangan'");
        if($cek->num_rows == 0){
            echo "";
        }else{
            $erow = $cek->fetch_assoc();
            $email = $erow['email'];
        }

        if($erow['kondisi']=='TERISI'){
            $update = $koneksi->query("UPDATE ruangan SET kondisi='KOSONG', email='' WHERE id_ruangan='$id_ruangan'") or die(mysqli_error());
     
            if($update){ 
                $pesan = 'Terimakasih, Silahkan meninggalkan ruangan.';
            }else{ 
                $pesan = 'Ups, Gagal mengubah kondisi ruangan silahkan coba lagi.';
            }
        }
    }else{
        $pesan = '';
    }
?>

<div class="halaman1">
    <div class="isi-halaman">
        <div class="isi">
            <div class="artikel">
                <h3>Data Ruangan Digunakan</h3>
                <hr>
                <?php echo $pesan; ?>
                <form method="post" action="">
                <table class="tabel">
                    <?php   
                        $cek=$koneksi->query("SELECT * FROM ruangan WHERE email='$email'"); 
                        if($cek->num_rows == 0){
                            echo '<tr class="tr1">
                                    <td class="td1" colspan="8"><center>Tidak ada data saat ini...</center></td>
                                  </tr>';
                        } else {
                            $no=1;
                            while($erow = $cek->fetch_assoc()) {
                                extract($erow)
                    ?>
                    <?php
                            echo '<tr class="tr1">
                                    <td width="100px"><b>Kode Ruangan</b></td>
                                    <td>:</td>
                                    <td>'.$erow['kode_ruangan'].'</td>
                                  </tr>
                                  <tr class="tr1">
                                    <td><b>Lantai</b></td>
                                    <td>:</td>
                                    <td>'.$erow['lantai'].'</td>
                                  </tr>
                                  <tr class="tr1">
                                    <td><b>Gedung</b></td>
                                    <td>:</td>
                                    <td>'.$erow['gedung'].'</td>
                                  </tr>
                                  <tr class="tr1">
                                    <td><b>Fasilitas</b></td>
                                    <td>:</td>
                                    <td>'.$erow['fasilitas'].'</td>
                                  </tr>
                                  <tr class="tr1">
                                    <td colspan="3">
                                        <b>
                                        <a href="ruangan terpilih.php?aksi=aktif&id_ruangan='.$erow['id_ruangan'].'" onclick="return confirm(\'Anda yakin akan meninggalkan ruangan '.$erow['kode_ruangan'].'?\')" class="a">Tinggalkan Ruangan</a>
                                        </b>
                                    </td>
                                    <input type="hidden" name="id_ruangan" value="'.$erow['id_ruangan'].'">
                                    <input type="hidden" name="tanggal" value="'. date("Y-m-d").'">
                                  </tr>';
                            $no++;
                            }
                    ?>
                                    <tr>
                                        <td colspan="3">
                                            <?php
                                            // Query untuk mendapatkan id_koordinator
                                            $koordinator_result = $koneksi->query("SELECT id_koordinator FROM koordinator WHERE email='$email'");
                                            $koordinator_row = $koordinator_result->fetch_assoc();
                                            ?>
                                                <input type="hidden" name="id_koordinator" value="<?php echo $koordinator_row['id_koordinator']; ?>">
                                                <textarea class="box" name="komentar" placeholder="Komentar" required=""></textarea>
                                                <button type="submit" name="simpan" class="box">Kirim</button>
                                            </form>
                                        </td>
                                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </div>
        </div>
        <?php include('footer.php');?>
