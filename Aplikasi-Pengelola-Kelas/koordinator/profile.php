<?php 
  include('../include/koneksi.php');
  session_start();
  
  // Pastikan variabel email telah diinisialisasi
  if (!isset($_SESSION['email'])) {
      // Redirect jika email belum diset (belum login)
      header("Location: ../login-koordinator.php");
      exit();
  }
  
  $email = $_SESSION['email'];
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
.artikel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
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
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: calc(100% - 22px); /* Adjusting for padding and border */
}
.kotak[type="button"], .kotak[type="submit"], .kotak[type="reset"], .button-link {
    background-color: #DC5F00;
    color: white;
    cursor: pointer;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    display: inline-block;
    text-align: center;
}
.kotak[type="button"]:hover, .kotak[type="submit"]:hover, .kotak[type="reset"]:hover, .button-link:hover {
    background-color: #555;
}

.button-group {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}
</style>

<div class="halaman1">
    <div class="isi-halaman">
        <div class="isi">
            <div class="artikel">
                <div class="artikel-header">
                    <h3>Profile</h3>
                    <div class="logout">
                        <ul>
                            <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
                <hr>
                <form method="post" action="">
                    <table class="tabel">
                        <?php   
                            $cek = $koneksi->query("SELECT * FROM koordinator 
                                                    NATURAL JOIN fakultas 
                                                    NATURAL JOIN prodi 
                                                    WHERE email='$email'"); 
                            if($cek->num_rows == 0){
                                echo '<tr class="tr1">
                                    <td class="td1" colspan="8"><center>Tidak ada data saat ini...</center></td>
                                </tr>';
                            } else {
                                while($erow = $cek->fetch_assoc()) {
                                    echo '<tr class="tr1">
                                            <td colspan="3"></td>
                                            <td rowspan="8" align="center">
                                                <a href="foto_edit.php?id_koordinator='.$erow['id_koordinator'].'" class="a">
                                                    <img src="foto/'.$erow['foto'].'" width="80px" height="100px">
                                                </a>
                                            </td>
                                          </tr>';
                                    echo '<tr class="tr1">
                                            <td width="100px"><b>NIM</b></td>
                                            <td>:</td>
                                            <td>'.$erow['nim'].'</td>
                                          </tr>';
                                    echo '<tr class="tr1">
                                            <td><b>Nama</b></td>
                                            <td>:</td>
                                            <td>'.$erow['nama'].'</td>
                                          </tr>';
                                    echo '<tr class="tr1">
                                            <td><b>Tanggal Lahir</b></td>
                                            <td>:</td>
                                            <td>'.$erow['tempat_lahir'].', '.$erow['tanggal_lahir'].'</td>
                                          </tr>';
                                    echo '<tr class="tr1">
                                            <td><b>Jenis Kelamin</b></td>
                                            <td>:</td>
                                            <td>'.$erow['jenis_kelamin'].'</td>
                                          </tr>';
                                    echo '<tr class="tr1">
                                            <td><b>Semester</b></td>
                                            <td>:</td>
                                            <td>'.$erow['kelas'].'</td>
                                          </tr>';
                                    echo '<tr class="tr1">
                                            <td><b>Jurusan</b></td>
                                            <td>:</td>
                                            <td>'.$erow['fakultas'].' - '.$erow['prodi'].'</td>
                                          </tr>';
                                    echo '<tr class="tr1">
                                            <td colspan="3">
                                                <div class="button-group">
                                                    <a href="profile edit.php?id_koordinator='.$erow['id_koordinator'].'" class="button-link">Edit Profil</a> 
                                                    <a href="password ganti.php?id_koordinator='.$erow['id_koordinator'].'" class="button-link">Ganti Password</a>
                                                </div>
                                            </td>
                                          </tr>';
                                }
                            }
                        ?>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php');?>
