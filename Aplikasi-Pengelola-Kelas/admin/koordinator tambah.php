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
}
.a:hover {
    color: #fff;
}
.kotak {
    width: 99%;
    padding: 10px;
    margin: 10px -3px;
    border: 1px solid #ccc;
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
fieldset.filset {
    border: 1px solid #DC5F00;
    padding: 10px;
}
legend {
    color: #DC5F00;
    font-weight: bold;
}
</style>

			<div class="judul">
				<div class="isi-judul"></div>
			</div>
			<div class="halaman1">
				<div class="isi-halaman">
				
					<div class="isi">
						<div class="artikel">
	<!------------------------Proses Tambah Koordinator-------------------->
	<?php
      if(isset($_POST['tambah'])){ 
        $email            = $_POST['email'];
        $npm              = $_POST['npm'];
        $nama             = $_POST['nama'];
        $jenis_kelamin    = $_POST['jenis_kelamin'];
        $tempat_lahir     = $_POST['tempat_lahir'];
        $tanggal_lahir    = $_POST['tanggal_lahir'];
        $kelas 			      = $_POST['kelas'];
        $id_fakultas      = $_POST['id_fakultas'];
        $id_prodi		      = $_POST['id_prodi'];
        $pass1            = $_POST['password1'];
        $pass2            = $_POST['password2'];
        
        $nama1 = $_FILES['foto']['name'];
        $x = explode('.', $nama1);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['foto']['tmp_name'];
        
        move_uploaded_file($file_tmp, '../koordinator/foto/'.$nama1);
        $cek = $koneksi->query("select*from koordinator natural join akun where npm='$npm' OR email='$email'");
        if($cek->num_rows == 0){
          if($pass1 == $pass2){ 
            $pass = md5($pass1); 
            $insert = $koneksi->query("insert into koordinator(
                                      email,
                                      password,
                                      npm,
                                      nama,
                                      jenis_kelamin,
                                      tempat_lahir,
                                      tanggal_lahir,
                                      kelas,
                                      id_fakultas,
                                      id_prodi,
                                      foto)
                                  values(
                                      '$email',
                                      '$pass',
                                      '$npm',
                                      '$nama',
                                      '$jenis_kelamin',
                                      '$tempat_lahir',
                                      '$tanggal_lahir',
                                      '$kelas',
                                      '$id_fakultas',
                                      '$id_prodi',
                                      '$nama1')") or die(mysqli_error());
                       $koneksi->query("insert into akun(email,password) values('$email','$pass')") or die(mysqli_error());
            if($insert){ 
               $pesan = '<p><b>DONE!</b>, Data berhasil ditambahkan.</p>';
            }else{ 
               $pesan = '<p><b>Upss</b>, Data gagal disimpan.</p>';
            }
          } else{ 
              $pesan = '<p><b>WARNING!</b>, Password tidak sama.</p>';
          }
        }else{ 
            $pesan = '<p><b>WARNING!</b>, NPM/Email sudah digunakan.</p></div></div>';
        }
      }else{
        $pesan = '';
      }
  ?>

<form method="post" action="" enctype="multipart/form-data">
                <fieldset class="filset">
                    <legend>Akun :</legend>
                    <input class="kotak" type="text" name="email" placeholder="Email" required="">
                    <input class="kotak" type="password" name="password1" placeholder="Password" required="">
                    <input class="kotak" type="password" name="password2" placeholder="Ulangi Password" required="">
                </fieldset>

                <div class="artikel">
							<fieldset class="filset">
                      		  <legend>Identitas :</legend>
            					<input class="kotak" type="text" name="nama" placeholder="Nama Lengkap" required="">
            					<input class="kotak" type="text" name="nim" placeholder="Nomor Induk Mahasiswa" required="">
            					<input class="kotak" type="text" name="tempat_lahir" placeholder="Tempat Lahir" required="">
            					<input class="kotak" type="date" name="tanggal_lahir" placeholder="Tanggal Lahir-Tahun-Bulan-Tanggal" required="">   
            					<select name="jenis_kelamin" class="kotak" required="">
            						<option value="">Jenis Kelamin</option>
            						<option value="laki-laki">Laki-laki</option>
            						<option value="perempuan">Perempuan</option>
            					</select>

            					<select name="id_fakultas" class="kotak" id="fakultas" required="">
            						<option>Pilih Fakultas</option>
            						<?php 
						   				$result = mysqli_query($koneksi, "select*from fakultas");        
								 			while ($erow = mysqli_fetch_array($result))
											 {    
									 			echo '<option value="'.$erow['id_fakultas'].'">'.$erow['fakultas'].'</option>';   
								 			}      
									?>
            					</select>

                                <select name="id_prodi" class="kotak" id="prodi" required="">
            						<option>Pilih Program Studi</option>
            						<?php 
						   				$result = mysqli_query($koneksi, "select*from prodi");        
								 			while ($erow = mysqli_fetch_array($result))
											 {    
									 			echo '<option value="'.$erow['id_prodi'].'">'.$erow['prodi'].'</option>';   
								 			}      
									?>
            					</select>

                                <input class="kotak" type="text" name="kelas" placeholder="Kelas" required=""> 

            					<input class="kotak" type="file" name="foto" required="">     
            					<button type="submit" name="tambah" class="button">Tambahkan</button>
            					<button type="submit" class="button" onclick="window.location.href='koordinator data.php';">Batal</button>
            				</fieldset>
        					</form>
						</div>
					</div>
				</div>
			</div>
		
			<?php include('footer.php'); ?>
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>

		<script>
		    $("#fakultas").change(function(){
        		// variabel dari nilai combo box Fakultas
       			var id_fakultas = $("#fakultas").val();
        		// mengirim dan mengambil data
        		$.ajax({
            		type: "POST",
            		dataType: "html",
            		url: "include/prodi.php",
            		data: "fakul="+id_fakultas,
            		success: function(msg){
                		// jika tidak ada data
                		if(msg == ''){
                		    alert('Tidak ada data Jurusan');
                		}
                		// jika dapat mengambil data,, tampilkan di combo box jurusan
                		else{
                    		$("#prodi").html(msg);
                		}
            		}
        		});
    		});
		</script>