<?php 
  include('../include/koneksi.php');
?>

<?php include('header.php'); ?>

<div class="judul">
    <div class="isi-judul"></div>
</div>
<?php
  if(isset($_GET['aksi']) && $_GET['aksi'] == 'delete'){ 
    $id_ruangan = $_GET['id_ruangan']; 
    $cek=$koneksi->query("SELECT * FROM ruangan WHERE id_ruangan='$id_ruangan'"); 
    if($cek->num_rows == 0){ 
      $pesan = ''; 
    }else{
      $koneksi->query("DELETE FROM komentar WHERE id_ruangan='$id_ruangan'");
      $delete=$koneksi->query("DELETE FROM ruangan WHERE id_ruangan='$id_ruangan'");
      if($delete){
        $pesan = '<p><b>DONE!</b>, Data berhasil dihapus.</p>';
      }else{ 
        $pesan = '<p><b>ERROR!</b>, Data gagal dihapus.</p>';
      }
    }
  }else{
    $pesan = '';
  }
?>
<?php
  //menghitung data yang akan di tampilkan pada tabel
  $perhalaman=5;
  $data=mysqli_query($koneksi, "SELECT * FROM ruangan");
  $jum=mysqli_num_rows($data);
  $halaman=ceil($jum/$perhalaman);
  $page=(isset($_GET['page']))?(int)$_GET['page']:1;
  $start=($page - 1) * $perhalaman;
?>

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
        color: white;
    }
    .th1 {
        font-weight: bold;
    }
    .td1 {
        border-bottom: 1px solid black;
    }
    .a {
        color: #DC5F00;
    }
    .a:hover {
        color: #fff;
    }
    .cari {
        width: 10%;
        height: 15px;
        padding: 10px;   
        background-color: white
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
        padding: 5px;
        width: 100px;
        height: 100px;
		text-decoration: none;
        border: none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        text-align: center;
        margin: 5px;
    }
    .kotak-edit {
        background-color: #28a745;
    }
    .kotak-edit:hover {
        background-color: #218838;
    }
    .kotak-hapus {
        background-color: #dc3545;
    }
    .kotak-hapus:hover {
        background-color: #c82333;
    }
</style>

<div class="halaman1">
    <div class="isi-halaman">
        <div class="isi">
            <div class="artikel">
                <td class="td2" align="left"><h3>Data Ruangan</h3></td>
                <hr>
                <?php echo $pesan; ?>
                <table class="tabel">
								<tr>
									<td class="td2" align="right">
										<form method="get" action="">
											<input type="text" class="cari" placeholder="Cari data disini...">
											<button type="submit" class="button">Cari</button>
											<input type="button" class="button" value="Tambah" onclick="window.location = 'ruangan tambah.php';"/>
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
                        <th class="th1">Kondisi</th>
                        <th class="th1">Opsi</th>
                    </tr>
                    <!-- Data Tabel -->
                    <?php
                    if(isset($_GET['cari'])){
                        $cari=$_GET['cari'];
                        $cek=$koneksi->query("SELECT * FROM ruangan WHERE 
                                             kode_ruangan LIKE '%".$cari."%' 
                                             OR lantai LIKE '%".$cari."%'
                                             OR gedung LIKE '%".$cari."%'
                                             OR fasilitas LIKE '%".$cari."%'
                                             OR kondisi LIKE '%".$cari."%' ORDER BY kode_ruangan") 
                                             or die($koneksi->error._LINE_);;
                        if($cek->num_rows == 0){
                            echo '';
                        }else{
                            $cek=$koneksi->query("SELECT * FROM ruangan WHERE
                                                 kode_ruangan LIKE '%".$cari."%'
                                                 OR lantai LIKE '%".$cari."'
                                                 OR gedung LIKE '%".$cari."%'
                                                 OR fasilitas LIKE '%".$cari."%'
                                                 OR kondisi LIKE '%".$cari."%' ORDER BY kode_ruangan");
                        }
                    }else{    
                        $cek=$koneksi->query("SELECT * FROM ruangan LIMIT $start,$perhalaman");
                    } 
                    if($cek->num_rows == 0){
                        echo '<tr class="tr1">
                                  <td class="td1" colspan="8"><center>Tidak ada data saat ini...</center></td>
                              </tr>';
                    }else{
                        $no=1;
                        while($erow = $cek->fetch_assoc()) {
                            extract($erow)
                    ?>
                    <?php
                        echo '<tr class="tr1">
                                <td class="td1">'.$no.'</td>
                                <td class="td1">'.$erow['kode_ruangan'].'</td>
                                <td class="td1">'.$erow['lantai'].'</td>
                                <td class="td1">'.$erow['gedung'].'</td>
                                <td class="td1">'.$erow['fasilitas'].'</td>
                                <td class="td1">'.$erow['kondisi'].'</td>
                                <td class="td1">
                                    <a href="ruangan edit.php?id_ruangan='.$erow['id_ruangan'].'" class="kotak-aksi kotak-edit">Edit</a>
                                    <a href="ruangan data.php?aksi=delete&id_ruangan='.$erow['id_ruangan'].'" onclick="return confirm(\'Anda yakin akan menghapus data '.$erow['kode_ruangan'].'?\')" class="kotak-aksi kotak-hapus">Hapus</a>
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

<?php include('footer.php'); ?>
