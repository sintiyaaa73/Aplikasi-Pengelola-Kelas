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
    .kotak {
        padding: 5px;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        background-color: #DC5F00;
        color: #fff;
        cursor: pointer;
        width: 100px;
        text-align: center;
        display: inline-block;
    }
    .cari {
        width: 10%;
        height: 30px;
        background-color: white
        margin: 10px 5px;
        border-radius: 20px;
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
	.kotak-aksi {
        background-color: #dc3545;
    }
    .kotak-aksi:hover {
        background-color: #c82333;
    }
</style>

			<div class="judul">
				<div class="isi-judul"></div>
			</div>

	<?php
      if(isset($_GET['aksi']) == 'aktif'){ 
        $id_koordinator = $_GET['id_koordinator'];

        $cek=$koneksi->query("select*from koordinator where id_koordinator='$id_koordinator'"); 
        if($cek->num_rows == 0){ 
          $pesan = ''; 
        }else{
        	$rowe 	  = $cek->fetch_assoc();
        	$email 	  = $rowe['email'];
        	$password = $rowe['password'];

        			$koneksi->query("update koordinator set status='aktif' where id_koordinator='$id_koordinator'") or die(mysqli_error());
          $insert = $koneksi->query("insert into akun(email,password) values ('$email','$password')") or die(mysqli_error());
          if($insert){
            $pesan = '<p><b>DONE!</b>, Data berhasil di Aktifkan.</p>';
          }else{ 
            $pesan = ' <p><b>DONT DELETE!</b>, Data gagal di Aktifkan.</p>';
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
							<td class="td2" align="left"><h3>Data Konfirmasi Akun</h3></td>
							<hr>
							<?php echo $pesan; ?>

							<table class="tabel">
								
	
								<?php   
      								$cek=$koneksi->query("select * from koordinator natural join fakultas natural join prodi where status='non-aktif' LIMIT $start,$perhalaman");
      								if($cek->num_rows == 0){
        								echo '<tr class="tr1">
            									<td class="td1" colspan="8"><center>Tidak ada data saat ini...</center></td>
	           								  </tr>';
									}else{
										echo '
											<tr class="tr1">
												<th class="th1">No</th>
												<th class="th1">NPM</th>
												<th class="th1">Nama</th>
												<th class="th1">Jenis Kelamin</th>
												<th class="th1">Kelas</th>
												<th class="th1">Jurusan</th>
												<th class="th1">Opsi</th>
											</tr>
										';
										$no=1;
										while($erow = $cek->fetch_assoc()) {
											extract($erow)
          									?>
          									<?php
											echo '<tr class="tr1">
													<td class="td1">'.$no.'</td>
													<td class="td1">'.$erow['npm'].'</td>
													<td class="td1">'.$erow['nama'].'</td>
													<td class="td1">'.$erow['jenis_kelamin'].'</td>
													<td class="td1">'.$erow['kelas'].'</td>
													<td class="td1">'.$erow['prodi'].'</td>
													<td class="td1">
													 <button class="kotak">
														<a href="akun.php?aksi=aktif&id_koordinator='.$erow['id_koordinator'].'" onclick="return confirm(\'Anda yakin akan mengaktifkan data '.$erow['nama'].'?\')" class="kotak-aksi kotak-aktif">AKTIFKAN</a>
													 </buutton>
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