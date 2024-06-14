<?php 
  include('../include/koneksi.php');
?>

<?php include('header.php'); ?>
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
}
.th1 {
    font-weight: bold;
}
.td1 {
    border-bottom: 1px solid black;
}
.td2 {
    padding: 10px;
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
	.kotak-hapus {
        background-color: #dc3545;
    }
    .kotak-hapus:hover {
        background-color: #c82333;
    }
.w3-panel {
    padding: 10px;
    margin-bottom: 10px;
}
.w3-pale-green {
    background-color: #d8f3dc;
}
.w3-border-green {
    border-left: 5px solid #2d6a4f;
}
.w3-pale-red {
    background-color: #f8d7da;
}
.w3-border-red {
    border-left: 5px solid #dc3545;
}
</style>

			<div class="judul">
				<div class="isi-judul"></div>
			</div>
	<?php
      if(isset($_GET['aksi']) == 'delete'){ 
        $id_komentar = $_GET['id_komentar']; 
        $cek=$koneksi->query("select*from komentar where id_komentar='$id_komentar'"); 
        if($cek->num_rows == 0){ 
          $errormsgh = ''; 
        }else{
        	      $delete = $koneksi->query("delete from komentar where id_komentar='$id_komentar'");
          if($delete){
            $errormsgh = '<div class="w3-panel w3-pale-green w3-leftbar w3-border-green">
                            <p><b>DONE!</b>, Data berhasil dihapus.</p>
                          </div>';
          }else{ 
            $errormsgh = '<div class="w3-panel w3-pale-red w3-leftbar w3-border-red">
                            <p><b>DONT DELETE!</b>, Data gagal dihapus.</p>
                          </div>';
          }
        }
      }else{
        $errormsgh = '';
      }
  	?>
	<?php
      //menghitung data yang akan di tampilkan pada tabel
      $perhalaman=5;
      $data=mysqli_query($koneksi, "select * from komentar");
      $jum=mysqli_num_rows($data);
      $halaman=ceil($jum/$perhalaman);
      $page=(isset($_GET['page']))?(int)$_GET['page']:1;
      $start=($page - 1) * $perhalaman;
  	?>
	
			<div class="halaman1">
				<div class="isi-halaman">
					<div class="isi">
						<div class="artikel">
							<td class="td2" align="left"><h3>Data Komentar Koordinator</h3></td>
							<hr>
							<?php echo $errormsgh; ?>
							<table class="tabel">
								<tr>
									<td class="td2" align="right">
										<form method="get" action="">
											<input type="text" class="cari" name="cari" placeholder="Cari data disini...">
											<button type="submit" class="button">Cari</button>
										</form>
									</td>
							</table>
							<table class="tabel">
								<tr class="tr1">
									<th class="th1">No</th>
									<th class="th1">Kode</th>
									<th class="th1">Komentar</th>
									<th class="th1">Opsi</th>
								</tr>
	
								<?php
								if(isset($_GET['cari'])){
        								$cari=$_GET['cari'];
        								$sql=$koneksi->query("select * from komentar where kode_ruangan like '%".$cari."%' ORDER BY kode_ruangan") or die($koneksi->error._LINE_);;
          							if($sql->num_rows == 0){
            							echo '';
          							}else{
            							$sql=$koneksi->query("select * from komentar where kode_ruangan like '%".$cari."%' ORDER BY kode_ruangan");
          							}
  								}else{    
      								$sql=$koneksi->query("select * from komentar natural join ruangan LIMIT $start,$perhalaman");
      							} 
      							if($sql->num_rows == 0){
        							echo '<tr class="tr1">
            								<td class="td1" colspan="8"><center>Tidak ada data saat ini...</center></td>
	           							  </tr>';
								}else{
									$no=1;
									while($erow = $sql->fetch_assoc()) {
											extract($erow)
          									?>
          									<?php
											echo '<tr class="tr1">
													<td class="td1">'.$no.'</td>
													<td class="td1">'.$erow['kode_ruangan'].'</td>
													<td class="td1">'.$erow['komentar'].'</td>
													<td class="td1">
													<button class="kotak">
														<a href="komentar.php?aksi=delete&id_komentar='.$erow['id_komentar'].'" onclick="return confirm(\'Anda yakin akan menghapus komentar data '.$erow['id_ruangan'].'?\')" " class="kotak-aksi kotak-hapus" >Hapus</a>
													</button>
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