<?php 
  include('../include/koneksi.php');
?>

<?php include('header.php'); ?>

			<div class="judul">
				<div class="isi-judul"></div>
			</div>

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
        padding: 5px 10px;
		text-decoration: none;
        border: none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        text-align: center;
        display: inline-block;
        margin: 2px;
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

	<?php
      if(isset($_GET['aksi']) == 'delete'){ 
        $id_koordinator = $_GET['id_koordinator']; 
        $cek=$koneksi->query("select*from koordinator where id_koordinator='$id_koordinator'"); 
        if($cek->num_rows == 0){ 
          $pesan = ''; 
        }else{
        	$rowe = $cek->fetch_assoc();
        	$email = $rowe['email'];

          		    $koneksi->query("delete from akun where email='$email'");
          $delete = $koneksi->query("delete from koordinator where id_koordinator='$id_koordinator'");
          if($delete){
            $pesan = '<p><b>DONE!</b>, Data berhasil dihapus.</p>';
          }else{ 
            $pesan = ' <p><b>DONT DELETE!</b>, Data gagal dihapus.</p>';
          }
        }
      }else{
        $pesan = '';
      }
  	?>
	<?php
      //menghitung data yang akan di tampilkan pada tabel
      $perhalaman=5;
      $data=mysqli_query($koneksi, "select * from koordinator");
      $jum=mysqli_num_rows($data);
      $halaman=ceil($jum/$perhalaman);
      $page=(isset($_GET['page']))?(int)$_GET['page']:1;
      $start=($page - 1) * $perhalaman;
  	?>
	
			<div class="halaman1">
				<div class="isi-halaman">
					<div class="isi">
						<div class="artikel">
							<td class="td2" align="left"><h3>Data Koordinator</h3></td>
							<hr>
							<?php echo $pesan; ?>
							<table class="tabel">
								<tr>
									<td class="td2" align="right">
										<form method="get" action="">
											<input type="text" class="cari" placeholder="Cari data disini...">
											<button type="submit" class="button">Cari</button>
											<input type="button" class="button" value="Tambah" onclick="window.location = 'koordinator tambah.php';"/>
										</form>
									</td>
							</table>
							<table class="tabel">
								<tr class="tr1">
									<th class="th1">No</th>
									<th class="th1">NIM</th>
									<th class="th1">Nama</th>
									<th class="th1">Jenis Kelamin</th>
									<th class="th1">Kelas</th>
									<th class="th1">Jurusan</th>
									<th class="th1">Opsi</th>
								</tr>
	
								<?php
								if(isset($_GET['cari'])){
        								$cari=$_GET['cari'];
        								$cek=$koneksi->query("select * from koordinator natural join fakultas natural join prodi where nama like '%".$cari."%' 
        														  or nim like '%".$cari."'
        														  or jenis_kelamin like '%".$cari."%'
        														  or tanggal_lahir like '%".$cari."%'
        														  or kelas like '%".$cari."%'
        														  or fakultas like '%".$cari."%'
        														  or prodi like '%".$cari."%' ORDER BY nama") 
        														  or die($koneksi->error._LINE_);;
          							if($cek->num_rows == 0){
            							echo '';
          							}else{
            							$cek=$koneksi->query("select * from koordinator natural join fakultas natural join prodi 				   	where nama like '%".$cari."%'
            													  or nim like '%".$cari."'
            													  or jenis_kelamin like '%".$cari."%'
            													  or tanggal_lahir like '%".$cari."%'
            													  or kelas like '%".$cari."%'
            													  or fakultas like '%".$cari."%'
            													  or prodi like '%".$cari."%' ORDER BY nama");
          							}
  								}else{    
      								$cek=$koneksi->query("select * from koordinator natural join fakultas natural join prodi LIMIT $start,$perhalaman");
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
													<td class="td1">'.$erow['nim'].'</td>
													<td class="td1">'.$erow['nama'].'</td>
													<td class="td1">'.$erow['jenis_kelamin'].'</td>
													<td class="td1">'.$erow['kelas'].'</td>
													<td class="td1">'.$erow['prodi'].'</td>
													<td class="td1">
														<a href="koordinator edit.php?id_koordinator='.$erow['id_koordinator'].'" class="kotak-aksi kotak-edit">Edit</a>
														
														<a href="koordinator data.php?aksi=delete&id_koordinator='.$erow['id_koordinator'].'" onclick="return confirm(\'Anda yakin akan menghapus data '.$erow['nama'].'?\')" class="kotak-aksi kotak-hapus">Hapus</a>
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