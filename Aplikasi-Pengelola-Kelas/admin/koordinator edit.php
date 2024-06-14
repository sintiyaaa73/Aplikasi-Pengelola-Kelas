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

<div class="isi-judul"></div>
<div class="halaman1">
    <div class="isi-halaman">
        <div class="isi">
            <div class="artikel">
<!------------------------Proses EditKoordinator-------------------->
<?php
$id_koordinator = $_GET['id_koordinator']; // Assignment ID koordinator
$cek = $koneksi->query("SELECT * FROM koordinator NATURAL JOIN fakultas NATURAL JOIN prodi WHERE id_koordinator='$id_koordinator'");

if($cek->num_rows == 0){
    echo "<p>Data koordinator tidak ditemukan.</p>";
} else {
    $erow = $cek->fetch_assoc();
    if(isset($_POST['simpan'])){ // Jika tombol 'Simpan' ditekan
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $tempat_lahir = $_POST['tempat_lahir'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $kelas = $_POST['kelas'];
        $id_fakultas = $_POST['id_fakultas'];
        $id_prodi = $_POST['id_prodi'];
        
        $update = $koneksi->query("UPDATE koordinator SET 
                                  nama='$nama',
                                  jenis_kelamin='$jenis_kelamin',
                                  tempat_lahir='$tempat_lahir',
                                  tanggal_lahir='$tanggal_lahir',
                                  kelas='$kelas',
                                  id_fakultas='$id_fakultas',
                                  id_prodi='$id_prodi'
                                  WHERE id_koordinator='$id_koordinator'") or die(mysqli_error());
if($update){ 
	echo "<script>
			alert('Data berhasil disimpan');
			window.location.href='koordinator data.php';
		  </script>";
} else { 
	echo "<script>
			alert('Data gagal disimpan, silahkan coba lagi');
		  </script>";
}
}
?>

<form method="post" action="" enctype="multipart/form-data">
    <div class="artikel">
        <fieldset class="filset">
            <legend>Identitas :</legend>
            <input class="kotak" type="text" name="nama" value="<?php echo $erow['nama']; ?>" required="">
            <input class="kotak" type="text" name="nim" value="<?php echo $erow['nim']; ?>" required="">
            <input class="kotak" type="text" name="tempat_lahir" value="<?php echo $erow['tempat_lahir']; ?>" required="">
            <input class="kotak" type="date" name="tanggal_lahir" value="<?php echo $erow['tanggal_lahir']; ?>" required="">   
            <select name="jenis_kelamin" class="kotak" value="<?php echo $erow['jenis_kelamin']; ?>" required="">
                <option value="">Jenis Kelamin</option>
                <option value="laki-laki" <?php if($erow['jenis_kelamin'] == 'laki-laki') echo 'selected'; ?>>Laki-laki</option>
                <option value="perempuan" <?php if($erow['jenis_kelamin'] == 'perempuan') echo 'selected'; ?>>Perempuan</option>
            </select>

            <select name="id_fakultas" class="kotak" id="fakultas" required="">
                <option>Pilih Fakultas</option>
                <?php 
                    $result = mysqli_query($koneksi, "SELECT * FROM fakultas");        
                    while ($fakultasRow = mysqli_fetch_array($result)) {    
                        $selected = ($fakultasRow['id_fakultas'] == $erow['id_fakultas']) ? 'selected' : '';
                        echo '<option value="'.$fakultasRow['id_fakultas'].'" '.$selected.'>'.$fakultasRow['fakultas'].'</option>';   
                    }      
                ?>
            </select>

            <select name="id_prodi" class="kotak" id="prodi" required="">
                <option>Pilih Program Studi</option>
                <?php 
                    $result = mysqli_query($koneksi, "SELECT * FROM prodi");        
                    while ($prodiRow = mysqli_fetch_array($result)) {    
                        $selected = ($prodiRow['id_prodi'] == $erow['id_prodi']) ? 'selected' : '';
                        echo '<option value="'.$prodiRow['id_prodi'].'" '.$selected.'>'.$prodiRow['prodi'].'</option>';   
                    }      
                ?>
            </select>

            <input class="kotak" type="text" name="kelas" value="<?php echo $erow['kelas']; ?>" required=""> 
            <div>
                <label>Foto saat ini:</label><br>
                <img src="path/to/images/<?php echo $erow['foto']; ?>" alt="Foto Koordinator" width="100">
                <input class="kotak" type="file" name="foto">
            </div>     
            <button type="submit" name="simpan" class="button">Simpan</button>
            <button type="button" class="button" onclick="window.location.href='koordinator data.php';">Batal</button>
        </fieldset>
    </div>
</form>

<?php } ?>

</div>
<?php include('footer.php'); ?>
<script type="text/javascript">
    <?php echo $jsArray; ?>  
    function changeValue(nik) {  
        document.getElementById('nm').value = user[nik].nama;  
    }
</script>
<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
<script>
    $("#fakultas").change(function(){
        var id_fakultas = $("#fakultas").val();
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "include/prodi.php",
            data: "fakul="+id_fakultas,
            success: function(msg){
                if(msg == ''){
                    alert('Tidak ada data Jurusan');
                } else {
                    $("#prodi").html(msg);
                }
            }
        });
    });
</script>
