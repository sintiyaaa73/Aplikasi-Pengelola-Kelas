<?php 
  include('../include/koneksi.php');
?>
<?php include('header.php');?>

<style>
	/* Gaya untuk halaman dan isinya */
.halaman1 {
    padding: 20px;
}
.isi-halaman {
    background-color: #EEEEEE;
    padding: 20px;
    border-radius: 10px;
}
.isi {
    margin-bottom: 20px;
}
.artikel {
    margin-bottom: 20px;
}
.artikel h3 {
    margin: 0;
    font-size: 30px;
}
.logout {
    display: flex;
    align-items: center;
}
.logout ul {
    list-style: none;
    margin: 0;
    padding: 0;
}
.logout ul li {
    margin: 0;
}
.logout ul li a {
    font-size: 24px;
    color: #DC5F00;
    text-decoration: none;
    padding: 10px;
}
.logout ul li a:hover {
    color: #fff;
}

/* Gaya untuk tabel */
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
.td2 {
    padding: 10px;
}

/* Gaya untuk tautan */
.a {
    color: #DC5F00;
    text-decoration: none;
}
.a:hover {
    color: #fff;
}

/* Gaya untuk kotak input dan tombol */
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

.filset {
    border: 1px solid #DC5F00;
    border-radius: 5px;
    padding: 10px;
}
.filset legend {
    padding: 0 10px;
    font-weight: bold;
}

</style>
	<!------------------------Proses EditKoordinator-------------------->
	<?php
	  $id_koordinator = $_GET['id_koordinator'];
	  $cek = $koneksi->query("select*from koordinator natural join akun where id_koordinator='$id_koordinator'");
	  if($cek->num_rows == 0){
	  	header("Location: index.php");
	  }else{
	  	$row = $cek->fetch_assoc();
	  }

      if(isset($_POST['simpan'])){ 
        $passwordLama   = md5($_POST['passwordLama']);
        $passwordBaru   = $_POST['passwordBaru'];
        $passwordUlang  = $_POST['passwordUlang'];
        
        $cek = $koneksi->query("select*from koordinator natural join akun where password='$passwordLama'");
        	if($cek->num_rows == 1){
        		if($passwordBaru == $passwordUlang){
        			$pass = md5($passwordBaru);
        			$update = $koneksi->query("update koordinator set password='$pass' where id_koordinator='$id_koordinator'") or die(mysqli_error()); 
        					  $koneksi->query("update akun set password='$pass' where email='$email'") or die(mysqli_error());
        			if($update){ 
	          			$pesan = '<p>Password berhasil di ubah,  kembali ke <a href="profile.php" class="a"> -> Profile. </a></p>';
        			}else{ 
           				$pesan = '<p>Password gagal di ubah, silahkan coba lagi. Atau kembali ke <a href="profile.php" class="a"> -> Profile. </a></p>'; 
        			}

        		}else{
        			$pesan = '<p>Password tidak sama!, Pastikan Passsword Baru dengan Password Ulang sama.</p>';
        		}
        	}else{
        		$pesan = '<p>Password gagal dirubah.</p>';
        	}
        		
      }else{
         $pesan='';
      }

    ?>


				<form method="post" action="">
            	  <h3>Ganti Password</h3>
            	    <hr>
                    <?php echo $pesan; ?>	
					<fieldset class="filset">
                      <legend>Password :</legend>
            			<input class="kotak" type="password" name="passwordLama" placeholder="Password Lama" required="">
            			<input class="kotak" type="password" name="passwordBaru" placeholder="Password Baru" required="">
            			<input class="kotak" type="password" name="passwordUlang" placeholder="Ulangi Password Baru" required="">
            			    
            			<button type="submit" name="simpan" class="button">Simpan</button>
            			<button type="reset"  class="button" onclick="window.location.href='profile.php';">Batal</button>
            		</fieldset>
        		</form>
						</div>
					</div>
					
					<?php include('footer.php');?>