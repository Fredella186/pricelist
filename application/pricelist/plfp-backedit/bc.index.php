<?php
  session_start();
  require "connect.php";
  // print_r($_SESSION);
  if(empty($_SESSION['produk-kosong'])){
    $_SESSION['produk-kosong'] = '';
  }

  if(isset($_GET['produk-kosong'])){

      $_SESSION['produk-kosong'] = $_GET['produk-kosong'];
      header("location:index.php");

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
    <link rel="shortcut icon" href="changeFavicon(this)" type="image/gif" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="assets/css/custom.min.css">
	<style>
      	.panel-heading .accordion-toggle:after {
            font-family: 'Glyphicons Halflings';
            content: "\e114";
            float: right;
            color: grey;
            /* display: inline-block; */
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
    .info-cek{
      position: fixed;
      bottom: 8px;
      left: 8px;
      padding: 8px;
      border-radius: 5px;
      color:white;
      z-index:4;
      display: none;
    }
    .btn-info-cek{
      text-decoration: none;
      color:#18bc9c;
      background-color: white;
      padding:2px;
      padding-left: 8px;
      padding-right: 8px;
      border-radius: 4px;
      margin-left: 8px;
      font-size: 22px;
    }
    .btn-info-cek:hover{
      text-decoration: none;
      background-color: #f39c12;
      color:black;
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
              <a href="jasa.php">Jasa</a>
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
              <input type="text" id="prependedInput" name="cari"  class="form-control input-sm" placeholder="Cari...">
              <span class="input-group-btn">
                <button class="btn btn-default btn-sm" name="btnCari" id="btnCari"  type="button"><i class="glyphicon glyphicon-search"></i></button>
              </span>
            </div>
          </div>
          <!-- End Pencarian -->

          List Produk &emsp;
        </h3>



        <div class="row-fluid">
          Tampilkan : &nbsp;
          <select onchange="" name="view_data" id="view_data">
            <option value="" selected>Semua Kategori</option>
            <option disabled>---------------------------------</option>
            <?php
              buka_koneksi();
              $qKat = mysql_query("SELECT * FROM tb_kategori") or die (mysql_error());
              //var_dump($qKat); exit;
              while($dataKat = mysql_fetch_array($qKat)){
                echo "<option value='".$dataKat['id_ktg']."'>".$dataKat['nama_ktg']."</option>";
              }
              tutup_koneksi();
            ?>
          </select>
          <div class="col-sm-3 pull-right">
            <?php
              if($_SESSION["hak_akses"] == 'Administrator' || $_SESSION["hak_akses"] == 'Accounting' || $_SESSION["hak_akses"] == 'Editor') {
            ?>
            <a href="#" id="0" class="tambah btn btn-info btn-sm" role="button" data-toggle="modal" data-target="#dialog-pl">
              <i class="glyphicon glyphicon-plus-sign"></i>&emsp;Tambah Data
            </a>
            <?php } ?>
            &emsp;
            <button class="btn btn-warning btn-sm dropdown-toggle pull-right" type="button" id="cetak" data-toggle="dropdown" aria-haspopup="true">
              <i class="glyphicon glyphicon-print"></i>
              &nbsp;Cetak
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="cetak">
              <li><a href="ex_pdf.php" target="_blank" class="pdf"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;&nbsp;PDF</a></li>
              <li><a href="#" onclick="location.href='pricelist.excel.php?cat='+document.getElementById('view_data').value;" class="excel"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;&nbsp;Excel</a></li>
              <li><a href="#" onclick="location.href='pricelist.excel.copy.php?cat='+document.getElementById('checkbox').value;" class="excel"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;&nbsp;Excel (Checklist)</a></li>
            </ul>
          </div>
        </div>

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
      <div id="dialog-pl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close glyphicon glyphicon-remove-circle" data-dismiss="modal" aria-hidden="true"></button>
                <h3 id="myModalLabel">Tambah Data Price List</h3>
            </div>
            <!-- tempat untuk menampilkan form pricelist -->
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button id="hidden-pricelist" class="btn btn-primary">Hidden</button>
                <button id="simpan-pricelist" class="btn btn-success">Simpan</button>
                <button id="salin-pricelist" class="btn btn-warning">Buat Salinan</button>
            </div>
          </div>
        </div>
      </div>
    <!-- akhir kode modal dialog -->
    
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

                <!-- untuk menampilkan data yang dicentang -->
                <div class="info-cek bg-success p-2" tabindex="-1" id="div-info-cek" style="z-index:3">
                  <span class="glyphicon glyphicon-check" style="font-size:22px"></span>
                  <span id="jumlah-centang-info" style="font-size:22px;margin-left:8px;"></span>
                </div>
            </div>
          </div>
        </div> 
      </div>
    <!-- akhir kode modal dialog -->
     <!-- awal untuk modal catatan -->
     <div id="modalcatatan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close glyphicon glyphicon-remove-circle" data-dismiss="modal" aria-hidden="true"></button>
                <h3 id="myModalLabel">Catatan Produk</h3>
            </div>
            <!-- tempat untuk menampilkan form pricelist -->
            <form class="form-horizontal" method="POST" action="pricelist.note.php" enctype="multipart/form-data" id="form-catatan_produk">
              <div class="form-group">
                <label for="txtDeskripsiProd" class="col-sm-2 control-label"></label>
                <div class="col-sm-12">
                  <input type="hidden" id="catatan" name="catatan">
                  <textarea name="catatan_produk" id="catatan_produk" class="form-control input-sm" rows="5" placeholder="Catatan Produk"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                  <button id="simpan-catatan" type="submit" class="btn btn-success">Simpan</button>
              </div>
            </form>
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
    <script src="pricelist.js?<?=md5("YmdHis")?>"></script>
    <script>
      var favicon_images = [
                    '//cdn.shopify.com/s/files/1/1764/2831/t/3/assets/favicon.png?9056248321425416510',
                    'assets/icons8-tags.gif'
                ],
                favicon_index = 0;
                
      function changeFavicon() {
          var link = document.querySelector("link[rel='shortcut icon']");
          link.href = favicon_images[favicon_index];
          favicon_index = (favicon_index + 1) % favicon_images.length;
          setTimeout(changeFavicon, 200);
      }
      changeFavicon();

    </script>
</body>
</html>
<?php } ?>
