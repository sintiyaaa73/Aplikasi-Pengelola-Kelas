<?php
include('include/koneksi.php');

$pesan = '';

if(isset($_POST['tambah'])) { 
    // Proses registrasi
    $email            = $_POST['email'];
    $nim              = $_POST['nim'];
    $nama             = $_POST['nama'];
    $jenis_kelamin    = $_POST['jenis_kelamin'];
    $tempat_lahir     = $_POST['tempat_lahir'];
    $tanggal_lahir    = $_POST['tanggal_lahir'];
    $kelas            = $_POST['kelas'];
    $id_fakultas      = $_POST['id_fakultas'];
    $id_prodi         = $_POST['id_prodi'];
    $pass1            = $_POST['password1'];
    $pass2            = $_POST['password2'];
    
    $nama1 = $_FILES['foto']['name'];
    $x = explode('.', $nama1);
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['foto']['tmp_name'];
    
    move_uploaded_file($file_tmp, 'koordinator/foto/'.$nama1);
    $cek = $koneksi->query("SELECT * FROM koordinator natural join akun WHERE nim='$nim' OR email='$email'"); 
    if($cek->num_rows == 0){ 
        if($pass1 == $pass2){ 
            $pass = md5($pass1); 
            $insert = $koneksi->query("INSERT INTO koordinator(
                                      email,
                                      password,
                                      nim,
                                      nama,
                                      jenis_kelamin,
                                      tempat_lahir,
                                      tanggal_lahir,
                                      kelas,
                                      id_fakultas,
                                      id_prodi,
                                      foto)
                                  VALUES(
                                      '$email',
                                      '$pass',
                                      '$nim',
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
               $pesan = '<p><b>DONE!</b>, Registrasi berhasil, silahkan login.</p>'; 
               header("Location: login-koordinator.php");
                exit();
            }else{ 
               $pesan = '<p><b>Upss</b>, Gagal melakukan registrasi.</p>'; 
            }
        } else{
            $pesan = '<p><b>WARNING!</b>, Password tidak sama.</p>';
        }
    }else{ 
        $pesan = '<p><b>WARNING!</b>, NPM/Email sudah digunakan.</p>';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Registrasi</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body style="background: url('image/vokasi.png') no-repeat center center fixed; background-size: cover;">
    <div class="halaman">
        <div class="register-container">
            <h2>Registrasi</h2>
            <?php  echo $pesan; ?>
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
            					<button type="submit" name="tambah" class="kotak">Register</button>
                                <p>Sudah memiliki akun? <a href="login-koordinator.php">Login</a></p>
            				</fieldset>
        					</form>
						</div>
					</div>
            </form>
        </div>
    </div>
</body>
</html>
