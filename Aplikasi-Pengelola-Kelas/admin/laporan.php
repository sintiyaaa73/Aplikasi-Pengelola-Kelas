<?php
  include('../include/koneksi.php');
  include("include/akses admin.php"); 

          $email = $_SESSION['email']; // mengambil username dari session yang login
      
          $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email'"); // query memilih entri username pada database
          if(mysqli_num_rows($sql) == 0){
              header("Location:../index admin.php");
          }else{
           $row = mysqli_fetch_assoc($sql);
          }

          $nama = $row['nama'];
?>
<!-- Setting CSS bagian header/ kop -->
<style type="text/css">
  table.page_header {width: 1020px; border: none; background-color: #FFFFFF; border-bottom: solid 1mm #FFCC00; padding: 2mm }
  table.page_footer {width: 1020px; border: none; background-color: #FFFFCC; border-top: solid 1mm #FFCC00; padding: 2mm}
  h1 {color: #000033}
  h2 {color: #000055}
  h3 {color: #000077}
</style>
<!-- Setting Margin header/ kop -->
<page backtop="14mm" backbottom="14mm" backleft="1mm" backright="10mm">
  <page_header>
    <!-- Setting Header -->
    <table class="page_header">
      <tr>
        <td style="text-align: left;    width: 10%">UNSIKA</td>
        <td style="text-align: center;    width: 80%">LAPORAN KRITIK DAN SARAN RUANGAN GEDUNG H.OPPON</td>
        <td style="text-align: right;    width: 10%"><?php echo date('d/m/Y'); ?></td>
      </tr>
    </table>
  </page_header>
  <!-- Setting Footer -->
  <page_footer>
    <table class="page_footer">
      <tr>
        <td style="width: 33%; text-align: left">
          Universitas Singaperbangsa Karawang
        </td>
        <td style="width: 34%; text-align: center">
          Dicetak oleh: <?php echo $nama ?>
        </td>
        <td style="width: 33%; text-align: right">
          Halaman [[page_cu]]/[[page_nb]]
        </td>
      </tr>
    </table>
  </page_footer>
  <!-- Setting CSS Tabel data yang akan ditampilkan -->
  <style type="text/css">
  .tabel2 {
    border-collapse: collapse;
  }
  .tabel2 th, .tabel2 td {
      padding: 5px 5px;
      border: 1px solid #000;
  }
  </style>
  <table>
    <tr>
      <th rowspan="3"><img src="laporan/logo.png" style="width:120px;height:100px" /></th>
      <td align="center" style="width: 800px;"><font style="font-size: 18px"><br><b>SISTEM RUANGAN GEDUNG H.OPPON</b></font>
        <br><br>Universitas Singaperbangsa Karawang | Jalan H.S Ronggowaluyo Teluk Jambe Karawang 41361
        <br><br>Website : https://www.unsika.ac.id | E-mail : info@unsika.ac.id</td>
    </tr>
  </table>
  <hr><br><br>
  <table class="tabel2">
    <thead>
      <tr>
        <td style="text-align: center; background: #ddd"><b>No.</b></td>
        <td style="text-align: center; background: #ddd"><b>Kode Ruangan</b></td>
        <td style="text-align: center; background: #ddd"><b>Fasilitas</b></td>
        <td style="text-align: center; background: #ddd"><b>Komentar</b></td>
        <td style="text-align: center; background: #ddd"><b>Tanggal</b></td>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = mysqli_query($koneksi, "SELECT * FROM komentar natural join ruangan ORDER BY id_komentar ASC");  
      $i   = 1;
      while($data=mysqli_fetch_array($sql))
      {
      ?>
      <tr>
        <td style="text-align: center; width=50px;"><?php echo $i; ?></td>
        <td style="text-align: center; width=100px;"><?php echo $data['kode_ruangan']; ?></td>
        <td style="text-align: center; width=350px;"><?php echo $data['fasilitas']; ?></td>
        <td style="text-align: center; width=300px;"><?php echo $data['komentar']; ?></td>
        <td style="text-align: center; width=100px;"><?php echo $data['tanggal']; ?></td>
      </tr>
    <?php
    $i++;
    }
    ?>
    </tbody>
  </table>
</page>
<!-- Memanggil fungsi bawaan HTML2PDF -->
<?php
$content = ob_get_clean();
 include 'laporan/html2pdf.class.php';
 try
{
    $html2pdf = new HTML2PDF('L', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('laporan_ruangan.pdf', 'V');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>