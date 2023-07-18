<?php
  session_start();
  require "connect.php";
  if(empty($_SESSION['produk-kosong2'])){
    $_SESSION['produk-kosong2'] = '';
  }

  if(isset($_GET['produk-kosong'])){

      $_SESSION['produk-kosong2'] = $_GET['produk-kosong'];
      header("location:alltoko.php");

  }


  //buka_koneksi();
  if(!isset($_SESSION["user"]) || empty($_SESSION["user"])){
    echo "<script type='text/javascript'>alert('Anda belum login, login dulu !');</script>";
    header("location:login.php");
  } else {
   	//flush();
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>FastPrint - Price List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="assets/css/custom.min.css">
	<style>
      	.panel-heading .accordion-toggle:after {
            font-family: 'Glyphicons Halflings';
            content: "\e114";
            float: right;
            color: grey;
        }
        .panel-heading .accordion-toggle.collapsed:after {
            content: "\e080";
        }
		.link-list{
			margin: 0 auto;
			float: none;
		}
  		input#kode_lama {
            background: #CCC;
            width: 100%;
        }
	</style>
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <script src="axios.min.js"></script>

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

    <div class="container">
      <br>
      <div class="row" id='page-all'>
        <h3>
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

          List Produk &emsp;
        </h3>

        <!-- tempat untuk menampilkan data pricelist -->
        <div id="data-pl"></div>
        <div id="pl-report"></div>
      </div>

      <footer>
        <hr>
        <p>&copy; <?php echo date('Y'); ?> FastPrint Indonesia</p>
      </footer>
    </div>


    <!-- awal untuk modal dialog -->
      <div id="dialog-link" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="linkModalLabel" aria-hidden="true">
        <div class="col-md-10 col-sm-10 col-xs-10 link-list">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close glyphicon glyphicon-remove-circle" data-dismiss="modal" aria-hidden="true"></button>
                <h3 id="linkModalLabel">Daftar Link Produk E-Commerce</h3>
            </div>
            <!-- tempat untuk menampilkan form link -->
            <div class="link-body"></div>
            <div class="modal-footer">                
                <a href="link/" target="_blank" class="btn btn-success">Ke Link Manager ></a>
            </div>
          </div>
        </div> 
      </div>
    <!-- akhir kode modal dialog -->

    <script src="assets/js/jquery.min.js"></script>

    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Magnific Popup core JS file -->
    <script src="assets/js/jquery.magnific-popup.js"></script>
<!--
    <script src="assets/js/custom.js"></script>
-->
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>
    <script src="pricelist-all.js?<?=md5("YmdHis")?>"></script>

</body>
</html>
<?php } ?>
