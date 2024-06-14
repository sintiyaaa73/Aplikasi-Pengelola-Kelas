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
    <div class="isi-judul">Tambah Ruangan</div>
</div>
<div class="halaman1">
    <div class="isi-halaman">
        <div class="isi">
            <div class="artikel">
                <!------------------------Proses Tambah Koordinator-------------------->
                <?php
                $pesan = '';
                if(isset($_POST['tambah'])){ 
                    $kode_ruangan     = $_POST['kode_ruangan'];
                    $lantai           = $_POST['lantai'];
                    $gedung           = $_POST['gedung'];
                    $fasilitas        = $_POST['fasilitas'];
                    $kondisi          = $_POST['kondisi'];

                    $cek = $koneksi->query("select*from ruangan where kode_ruangan='$kode_ruangan'"); 
                    if($cek->num_rows == 0){ 
                        $insert = $koneksi->query("insert into ruangan(
                                              kode_ruangan,
                                              lantai,
                                              gedung,
                                              fasilitas,
                                              kondisi)
                                          value(
                                              '$kode_ruangan',
                                              '$lantai',
                                              '$gedung',
                                              '$fasilitas',
                                              '$kondisi')") or die(mysqli_error($koneksi)); 
                        if($insert){ 
                            $pesan = '<p><b>DONE!</b>, Data berhasil ditambahkan.</p>'; 
                        }else{ 
                            $pesan = '<p><b>Upss</b>, Data gagal disimpan.</p>'; 
                        }
                    }else{ 
                        $pesan = '<p><b>WARNING!</b>, Kode Ruangan sudah terdaftar.</p>';
                    }
                }
                ?>

                <form method="post" action="">
                    <h3>Tambah Ruangan</h3>
                    <hr>
                    <?php echo $pesan; ?>
                    <fieldset class="filset">
                        <legend>Ruangan :</legend>
                        <input class="kotak" type="text" name="kode_ruangan" placeholder="Kode Ruangan" required="">
                        <input class="kotak" type="text" name="lantai" placeholder="Lantai Ruangan" required="">
                        <input class="kotak" type="text" name="gedung" placeholder="Gedung Ruangan" required="">
                        <textarea class="kotak" name="fasilitas" placeholder="Fasilitas" required=""></textarea>
                        <select name="kondisi" class="kotak" required="">
                            <option value="">Pilih Kondisi</option>
                            <option value="KOSONG">Kosong</option>
                            <option value="TERISI">Terisi</option>
                        </select>
                        <button type="submit" name="tambah" class="kotak" style="width: 120px;">Tambahkan</button>
                        <button type="button" class="kotak" style="width: 100px;" onclick="window.location.href='ruangan data.php';">Batal</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
