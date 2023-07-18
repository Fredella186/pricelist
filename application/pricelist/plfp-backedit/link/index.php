<?php
	session_start();
    include "../connect.php";
    buka_koneksi();
	if(!isset($_SESSION["user"]) || empty($_SESSION["user"])){      
	  //var_dump($_SESSION['user']);
      echo "<script type='text/javascript'>alert('Anda belum login, login dulu !');</script>";
      header("location:../login.php");
    } else {
      //var_dump("Harusnya Bisa");exit;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>FastPrint - Link Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="../assets/css/bootstrap_jeti.min.css" media="screen">
    <link rel="stylesheet" href="../assets/css/custom.min.css">
    <link rel="stylesheet" href="../assets/css/theme.css">

    <!-- Magnification PopUp Plugin CSS -->
    <link rel="stylesheet" href="../assets/css/magnific-popup.css">
    <style>
        .tengah {
            text-align : center;
        }
    </style>
  </head>
  <body>
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand">FastPrint - Link Management</a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">E-Commerce <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <?php
                    $q = mysql_query("SELECT * FROM tb_ecommerce");
                    while($row = mysql_fetch_array($q)){
                        if($row['nama_ecomm'] == 'Tokopedia' || $row['nama_ecomm'] == 'Bukalapak'){
                ?>
                            <li class="dropdown-submenu">
                                <a href="#"><?php echo $row['nama_ecomm']; ?></a>
                                <ul class="dropdown-menu">
                                    <li><a target="_blank" href="<?php echo freeStringLower($row['nama_ecomm']); ?>_sby">Surabaya</a></li>
                                    <li><a target="_blank" href="<?php echo freeStringLower($row['nama_ecomm']); ?>_jkt">Jakarta</a></li>
                                </ul>
                            </li>
                <?php } else {echo "<li><a target='_blank' href='".freeStringLower($row['nama_ecomm'])."/'>".$row['nama_ecomm']."</a></li>";} } ?>
              </ul>
            </li><li>
              <a href="../" target="_blank">Price List</a>
            </li>
            <li><a class="btn-sm btn-danger" href="../logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">
      <br>
      <div class="row">
          <center><h3>Daftar Ceklis Link Produk</h3></center>
          <!-- Pencarian -->
          <div class="col-sm-3 pull-right">
            <div class="input-group">
              <input type="text" id="prependedInput" name="cari" class="form-control input-sm" placeholder="Cari...">
              <span class="input-group-btn">
                <button class="btn btn-default btn-sm" name="btnCari" id="btnCari"  type="button"><i class="glyphicon glyphicon-search"></i></button>
              </span>
            </div>
          </div>
          <!-- End Pencarian -->
<!--
        <div class="row-fluid">
          <div class="col-sm-3">
            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="cetak" data-toggle="dropdown" aria-haspopup="true">
              <i class="glyphicon glyphicon-print"></i>
              &nbsp; Cetak
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="cetak">
              <li><a href="#" onclick="location.href='pricelist.pdf.php?cat='+document.getElementById('view_data').value;" target="_blank" class="pdf"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;&nbsp;PDF</a></li>
              <li><a href="#" onclick="location.href='pricelist.excel.php?cat='+document.getElementById('view_data').value;" class="excel"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;&nbsp;Excel</a></li>
            </ul>
          </div>
        </div>
-->

        <!-- tempat untuk menampilkan data pricelist -->
        <div id="data-link"></div>
        <div id="pl-report"></div>
      </div>

      <footer>
        <hr>
        <p>&copy; <?php echo date('Y'); ?> FastPrint Indonesia</p>
      </footer>
    </div>

    <script src="../assets/js/jquery.min.js"></script>

    <script src="../assets/js/bootstrap.min.js"></script>

    <!-- Magnific Popup core JS file -->
    <script src="../assets/js/jquery.magnific-popup.js"></script>
<!--
    <script src="assets/js/custom.js"></script>
-->
    <script src="link.js"></script>

</body>
</html>
<?php } tutup_koneksi(); ?>
