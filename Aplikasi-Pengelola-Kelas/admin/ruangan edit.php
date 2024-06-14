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
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: calc(100% - 22px); /* Adjusting for padding and border */
    }
    .kotak[type="button"], .kotak[type="submit"], .kotak[type="reset"] {
        background-color: #DC5F00;
        color: white;
        cursor: pointer;
    }
    .kotak[type="button"]:hover, .kotak[type="submit"]:hover, .kotak[type="reset"]:hover {
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
<!------------------------Proses Edit Koordinator-------------------->
<?php

$id_ruangan = $_GET['id_ruangan']; 
$cek = $koneksi->query("SELECT * FROM ruangan WHERE id_ruangan='$id_ruangan'"); 
if($cek->num_rows == 0){
    echo "";
}else{
    $erow = $cek->fetch_assoc();
}
if(isset($_POST['simpan'])){ 
    $kode_ruangan = $_POST['kode_ruangan'];
    $lantai       = $_POST['lantai'];
    $gedung       = $_POST['gedung'];
    $fasilitas    = $_POST['fasilitas'];
    $kondisi      = $_POST['kondisi'];
    
    $update = $koneksi->query("UPDATE ruangan SET 
                              kode_ruangan='$kode_ruangan',
                              lantai='$lantai',
                              gedung='$gedung',
                              fasilitas='$fasilitas',
                              kondisi='$kondisi'
                              WHERE id_ruangan='$id_ruangan'") or die(mysqli_error($koneksi)); 
if($update){ 
    echo "<script>
            alert('Data berhasil disimpan');
            window.location.href='ruangan data.php';
          </script>";
} else { 
    echo "<script>
            alert('Data gagal disimpan, silahkan coba lagi');
          </script>";
}
}
?>

<div class="halaman1">
    <div class="isi-halaman">
        <div class="isi">
            <div class="artikel">
                <form method="post" action="">
                    <h3>Edit Ruangan</h3>
                    <hr>   
                    <fieldset class="filset">
                        <legend>Ruangan :</legend>
                        <input class="kotak" type="text" name="kode_ruangan" value="<?php echo $erow['kode_ruangan']; ?>" placeholder="Kode Ruangan" required="">
                        <input class="kotak" type="text" name="lantai" value="<?php echo $erow['lantai']; ?>" placeholder="Lantai Ruangan" required="">
                        <input class="kotak" type="text" name="gedung" value="<?php echo $erow['gedung']; ?>" placeholder="Gedung Ruangan" required="">
                        <textarea class="kotak" name="fasilitas" placeholder="Fasilitas"><?php echo $erow['fasilitas']; ?></textarea>  
                        <select name="kondisi" class="kotak" required="">
                            <option value="<?php echo $erow['kondisi']; ?>"><?php echo $erow['kondisi']; ?></option>
                            <option value="KOSONG">Kosong</option>
                            <option value="TERISI">Terisi</option>
                        </select>
                        <button type="submit" name="simpan" class="kotak" style="width: 100px;">Simpan</button>
                        <button type="button" class="kotak" style="width: 100px;" onclick="window.location.href='ruangan data.php';">Batal</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
