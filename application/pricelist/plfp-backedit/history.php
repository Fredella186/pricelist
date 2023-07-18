<?php
  session_start();
    
  require "connect.php";
  buka_koneksi();
    // panggil berkas koneksi.php
?> 
<!DOCTYPE html> 
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Fast Print - Price List</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />

      <link rel="stylesheet" href="assets/css/bootstrap.min.css" media="screen">
      <link rel="stylesheet" href="assets/css/custom.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      <link href="assets/css/bootstrap2-toggle.css" rel="stylesheet">
      
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
            <a href="#" class="navbar-brand">FastPrint - Price List</a>
    </div>
    <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
               <li>
               <a href="index.php">Price List</a>
               </li>
               <li>
               <a href="alias.php">Nama Alias</a>
               </li>
               <li>
               <a href="alltoko.php">Stok Semua Cabang</a>
               </li>
               <li>
               <a href="produk_hidden.php">Produk Hidden</a>
               </li>
               <?php
               if($_SESSION["hak_akses"] == 'Administrator' || $_SESSION["hak_akses"] == 'Accounting' || $_SESSION["hak_akses"] == 'Editor') {
               ?>
               <li class="dropdown">
               <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">User <span class="caret"></span></a>
               <ul class="dropdown-menu" aria-labelledby="themes">
                  <li><a href="../default/">User</a></li>
                  <li><a href="../default/">Hak Akses</a></li>
               </ul>
               </li>
               <li><a href="link/" target="_blank">Link Manager</a></li>
               <?php } ?> 
               <?php
               if($_SESSION["menu_toko"] == 1) {
               ?>
               
               <li>
               <a href="history.php">History Ready</a>
               </li>
               
               <?php } ?>              
               <li><a class="btn-sm btn-danger" href="logout.php">Logout</a></li>
            </ul>
    </div>
  </div>
</div>
<br>
<div class='container'>
  <h3>History Ready & Kosong</h3>
  <table>
  <tr>
      <form action='' method='get'>
      <td>Tgl 1 :</td>
      <td style='padding:10px'>
         <input type="text" class='form-control' name='tgl' style='height:30px' id="datepicker"  value="<?=(isset($_GET['tgl']))?$_GET['tgl']:date("Y-m-d")?>">
         <input type="hidden" name='ctgl' value='1'>
      
      </td>
      <td>Tgl 2 :</td>
      <td style='padding:10px'><input type="text" class='form-control' name='tgl1' style='height:30px' id="datepicker2" value="<?=(isset($_GET['tgl2']))?$_GET['tgl2']:date("Y-m-d")?>"></td>
      <td style='padding:10px'><button class='btn btn-primary' style='height:30px;padding-top:2px'>Filter Tanggal</button></td>    
      </form>
   </tr>
   <tr>
      <form action='' method='get'>
         <td>Nama :</td>
         <input type="hidden" name='cnama' value='1'>
         <td style='padding:10px'><input type="text" name='nama' class='form-control' style='height:30px' value="<?=(isset($_GET['nama']))?$_GET['nama']:""?>" ></td>
         <td style='padding:10px'><button class='btn btn-primary' style='height:30px;padding-top:2px'>Cari</button></td>
      </form>
   </tr>
  <table>



  <table class='table table-bordered'>
    <tr class='bg-primary'>
       <th>No</th>
       <th>Nama Produk</th>
       <th>Tanggal</th>
       <th>Status</th>
    </tr>
    <?php
     $limit = 1;
     if(isset($_GET['cnama'])){
        $cari = '';
        $txtcari = explode(" ",$_GET['nama']);
        foreach ($txtcari as $key => $c) {
            
            if($key == 0){

               $cari .=" where judul_produk like '%{$c}%'";

            }else{

               $cari .=" and judul_produk like '%{$c}%'";

            }
                     

        }

        $qproduk ="SELECT kode_produk,judul_produk FROM `tb_pricelist` $cari limit 5";
        $sqlproduk = mysql_query($qproduk);

        if(mysql_num_rows($sqlproduk) == 0){
         
         $qproduk ="SELECT kode_produk,judul_produk FROM `tb_pricelist` where kode_produk = '{$_GET['nama']}'";
         $sqlproduk = mysql_query($qproduk);
         

        }

        $no =1;
        while ($produk = mysql_fetch_assoc($sqlproduk)) {
            // echo $produk['kode_produk'];
            $nama =  $produk['judul_produk'];
            $q="SELECT * FROM `tb_ready_toko` where id_produk like '%{$produk['kode_produk']}%' and toko = '{$_SESSION["kota"]}' ORDER BY `tb_ready_toko`.`tgl` DESC limit 10";
            $sqlready = mysql_query($q);
            while($fp = mysql_fetch_assoc($sqlready)){

               $iddd = explode(",",$fp['id_produk']);
               $tmpil = false;
               foreach ($iddd as $key => $d) {
                 
                  if($d == $produk['kode_produk']){
                     $tmpil = true;
                  }

               }

               if($tmpil){

                  $status = ($fp['status'] == 1)?"Ready":"Kosong";
                  echo "<tr>";
                     echo "<td>{$no}</td>";
                     echo "<td>{$nama}</td>";
                     echo "<td>{$fp['tgl']}</td>";
                     echo "<td>{$status}</td>";
                  echo "</tr>";

                  $no++;


               }


            }
        }



         
      
     }else{

         $tgl   = (isset($_GET['tgl']))?$_GET['tgl']:date("Y-m-d");
         $tgl2   = (isset($_GET['tgl2']))?$_GET['tgl2']:date("Y-m-d");
         $q="SELECT * FROM `tb_ready_toko` where tgl >= '$tgl' and tgl <= '$tgl2' and toko = '{$_SESSION["kota"]}' ORDER BY `tb_ready_toko`.`tgl` DESC";
         $produk = mysql_query($q);
         $no = 1;
         while($fp = mysql_fetch_assoc($produk)){
         
         $iddd = explode(",",$fp['id_produk']);
         foreach ($iddd as $key => $d) {
            $dp = mysql_query("SELECT judul_produk FROM `tb_pricelist` where kode_produk = '{$d}'");
            $fdp = mysql_fetch_assoc($dp);
            // print_r($fdp);
            $status = ($fp['status'] == 1)?"Ready":"Kosong";
            echo "<tr>";
               echo "<td>{$no}</td>";
               echo "<td>{$fdp['judul_produk']}</td>";
               echo "<td>{$fp['tgl']}</td>";
               echo "<td>{$status}</td>";
            echo "</tr>";

            $no++;

         }
         
      
      }

     }
      
    ?>

  </table>

</div>

<script>
$( function() {
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
} );

</script>
</body>
</html>