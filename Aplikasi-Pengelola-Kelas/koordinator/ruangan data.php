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
    background-color: #686D76;
    color: white;
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
.cari {
    width: 10%;
    height: 15px;
    padding: 10px;   
    background-color: white;
    margin: 10px 5px;
    border-radius: 5px;
}
.button {
    background-color: #DC5F00;
    width: 100px;
    padding: 10px;
    margin: 10px 5px;
    border-radius: 5px;
    color: white;
    cursor: pointer;
}
.button:hover{
    background-color: #555;
}
.kotak-aksi {
    width: 80px;
    height: 30px;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    text-align: center;
    display: inline-block;
}
.kotak-gunakan {
    background-color: #28a745;
}
.kotak-gunakan:hover {
    background-color: #218838;
}

</style>

<?php
  if(isset($_GET['aksi']) == 'aktif'){ 
    $id_ruangan = $_GET['id_ruangan'];

    $cek = $koneksi->query("select * from ruangan where id_ruangan='$id_ruangan'");
    if($cek->num_rows == 0){
        echo "";
    }else{
        $erow = $cek->fetch_assoc();
    }

    if($erow['kondisi']=='KOSONG'){
        $cek = $koneksi->query("select * from ruangan where email='$email'");

        if($cek->num_rows == 0){
            $update = $koneksi->query("update ruangan set kondisi='TERISI', email='$email' where id_ruangan='$id_ruangan'") or die(mysqli_error());
            if($update){
                $pesan = '<p><b>DONE!</b>, Ruangan berhasil di pilih.</p>';
            }else{ 
                $pesan = ' <p><b>Ups!</b>, Ruangan tidak bisa di pilih.</p>';
            }
        }else{
            $pesan = 'Anda sudah memilih ruangan, Lihat Ruangan <a href="ruangan_terpilih.php" class="a">Terpilih.</a>';
        }

    }else if($erow['kondisi']=='TERISI'){
        $update = $koneksi->query("update ruangan set kondisi='KOSONG', email='' where id_ruangan='$id_ruangan'") or die(mysqli_error());

        if($update){ 
            $pesan = 'Berhasil mengubah kondisi ruangan. Kembali ke <a href="ruangan_data.php" class="a">Data Ruangan.</a> atau <a href="ruangan_terpilih.php" class="a">Ruangan Terpilih.</a>';
        }else{ 
            $pesan = 'Ups, Gagal mengubah kondisi ruangan silahkan coba lagi.';
        }
    }
  }else{
    $pesan = '';
  }
?>
<?php
  //menghitung data yang akan di tampilkan pada tabel
  $perhalaman=5;
  $data=mysqli_query($koneksi, "select * from ruangan");
  $jum=mysqli_num_rows($data);
  $halaman=ceil($jum/$perhalaman);
  $page=(isset($_GET['page']))?(int)$_GET['page']:1;
  $start=($page - 1) * $perhalaman;
?>

<div class="halaman1">
    <div class="isi-halaman">
        <div class="isi">
            <div class="artikel">
                <h3>Data Ruangan Kosong</h3>
                <hr>
                <?php echo $pesan; ?>
                <table class="tabel">
                    <tr>
                        <td class="td2" align="right">
                            <form method="get" action="">
                                <input type="text" class="cari" name="cari" style="width: 200px;" placeholder="Cari data disini...">
                                <button type="submit" class="button" style="width: 67px;">Cari</button>
                            </form>
                        </td>
                </table>
                <table class="tabel">
                    <tr class="tr1">
                        <th class="th1">No</th>
                        <th class="th1">Kode</th>
                        <th class="th1">Lantai</th>
                        <th class="th1">Gedung</th>
                        <th class="th1">Fasilitas</th>
                        <th class="th1">Aksi</th>
                    </tr>

                    <?php
                    if(isset($_GET['cari'])){
                        $cari=$_GET['cari'];
                        $cek=$koneksi->query("select * from ruangan where 
                                                 kode_ruangan like '%".$cari."%' and kondisi='KOSONG'
                                              or lantai like '%".$cari."' and kondisi='KOSONG'
                                              or gedung like '%".$cari."%' and kondisi='KOSONG'
                                              or fasilitas like '%".$cari."%' 
                                              and kondisi='KOSONG' ORDER BY kode_ruangan") 
                                              or die($koneksi->error._LINE_);;
                        if($cek->num_rows == 0){
                            echo '';
                        }else{
                            $cek=$koneksi->query("select * from ruangan where
                                                     kode_ruangan like '%".$cari."%' and kondisi='KOSONG'
                                                  or lantai like '%".$cari."' and kondisi='KOSONG'
                                                  or gedung like '%".$cari."%' and kondisi='KOSONG'
                                                  or fasilitas like '%".$cari."%'
                                                  and kondisi='KOSONG' ORDER BY kode_ruangan");
                        }
                    }else{    
                        $cek=$koneksi->query("select * from ruangan where kondisi='KOSONG' LIMIT $start,$perhalaman");
                    } 
                    if($cek->num_rows == 0){
                        echo '<tr class="tr1">
                                <td class="td1" colspan="6"><center>Tidak ada data saat ini...</center></td>
                              </tr>';
                    }else{
                        $no=1;
                        while($erow = $cek->fetch_assoc()) {
                            echo '<tr class="tr1">
                                    <td class="td1">'.$no.'</td>
                                    <td class="td1">'.$erow['kode_ruangan'].'</td>
                                    <td class="td1">'.$erow['lantai'].'</td>
                                    <td class="td1">'.$erow['gedung'].'</td>
                                    <td class="td1">'.$erow['fasilitas'].'</td>
                                    <td class="td1" align="center">
                                      <a href="ruangan data.php?aksi=aktif&id_ruangan='.$erow['id_ruangan'].'" onclick="return confirm(\'Anda yakin akan menggunakan ruangan '.$erow['kode_ruangan'].'?\')" class="kotak-aksi kotak-gunakan">Gunakan</a>
                                    </td>
                                  </tr>';
                            $no++;
                        }
                    }
                    ?>
                    
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php');?>
