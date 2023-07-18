<?php
    session_start();
    require "plfp-backedit/connect.php";
	buka_koneksi();
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

    <link rel="stylesheet" href="assets/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/magnific-popup.min.css">
	<style>
      	.panel-heading .accordion-toggle:after {
            font-family: 'Glyphicons Halflings';
            content: "\e114";
            float: right;
            color: grey;
            font-size:12px;
        }
        .panel-heading .accordion-toggle.collapsed:after {
            content: "\e080";
        }
		.link-list{
			margin: 0 auto;
			float: none;
		}
	</style>
  </head>
  <body>
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand">FastPrint - Price List</a>
        </div>
        <!--div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li>
              <a href="#">Price List</a>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">User <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a href="../default/">User</a></li>
                <li><a href="../default/">Hak Akses</a></li>
              </ul>
            </li>
            <li><a href="link/" target="_blank">Link Manager</a></li>           
            <li><a class="btn-sm btn-danger" href="logout.php">Logout</a></li>
          </ul>
        </div-->
      </div>
    </div>

    <div class="container">
      <br>
      <div class="bs-docs-section">
        <div class="row">
          <br />
          <br />
          <br />
          <div class="col-lg-12">
          <!--Tampilkan : &nbsp;
          <select onchange="" name="view_data" id="view_data">
            <option value="" selected>Semua Kategori</option>
            <option disabled>---------------------------------</option>
            <?php
              $qKat = mysql_query("SELECT * FROM tb_kategori") or die (mysql_error());
              //~ var_dump($qKat);
              while($dataKat = mysql_fetch_array($qKat)){
                echo "<option value='".$dataKat['id_ktg']."'>".$dataKat['nama_ktg']."</option>";
              }              
            ?>
          </select> -->
            
            <h3>Price List Produk Fast Print Indonesia</h3>
            <table class="table table-striped table-hover table-bordered" id="table_id" cellspacing=0>
              <thead>
              <tr class="success">
                  <th style="text-align:center; width:20px;">#</th>
                  <th style="text-align:center; width:55px;">Gambar</th>
                  <th style="text-align:center; width:250px;">Judul</th>
                  <th style="text-align:center; width:130px;">Kategori</th>
                  <th style="text-align:center; width:170px;">Harga</th>
                  <th style="text-align:center; width:30px;">Berat</th>
              </tr>
              </thead>
              <tbody>
                <?php
                	$no = 1;
					$query = mysql_query("SELECT * FROM tb_pricelist ORDER BY update_time DESC");
					while($data = mysql_fetch_array($query))
          			{
                ?>
                <tr>
                    <td style="text-align:center;"><?php echo $no; ?></td>
                    <td>
                        <a class="image-popup-no-margins" href="<?php echo "plfp-backedit/" . IMG_PATH . $data['gambar_produk']; ?>"><img src="<?php echo "plfp-backedit/" . IMG_PATH . $data['gambar_produk']; ?>" style="width:70px; height:70px;" /></a>
                    </td>
                    <td><a href="#" style="text-decoration:none;color:black;" data-toggle="tooltip" title="<?php echo $data['deskripsi_produk']; ?>"><?php echo $data['judul_produk']."<br>SKU : ".$data['kode_produk']; ?></a></td>
                    <td>
                        <?php
                            $dataKtg = mysql_fetch_array(mysql_query("SELECT * FROM tb_kategori WHERE id_ktg = '".$data['ktg_produk']."'"));
                            echo $dataKtg['nama_ktg'];
                        ?>
                    </td>
                    <td class="harga-tingkat" style="width: 25%;">
                      	<div class="panel-group" id="accordion">
                        <div class="panel panel-default" id="panel<?php echo $data['kode_produk']; ?>">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a class="accordion-toggle collapsed" aria-expanded="false" data-toggle="collapse" data-parent="accordion" href="#collapse<?php echo $data['kode_produk']; ?>" style="text-decoration:none;">
                                      <strong><?php echo rupiah($data['harga']); ?></strong>
                                    </a>
                                </h5>
                            </div>

                            <div id="collapse<?php echo $data['kode_produk']; ?>" class="panel-collapse collapse">
                                <div class='table-responsive'>
                                    <table class="table table-bordered table-striped table-hover">
                                        <tr class="warning">
                                            <th style="text-align:center;">Qty</th>
                                            <th style="text-align:center;">Harga</th>
                                        </tr>
                                        <?php
                                            $qGrosir = mysql_query("SELECT * FROM tb_wholesale WHERE id_produk = '".$data['kode_produk']."' ORDER BY id_wholesale ASC");
                                            while($datas = mysql_fetch_array($qGrosir)){
                                        ?>
                                        <tr>
                                            <td><?php echo $datas['rentang_qty']." pcs"; ?></td>
                                            <td><?php echo rupiah($datas['harga_wholesale']); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                      </div>
                    </td>                    
                    <td style="width: 6%;"><?php echo berat($data['berat_produk']); ?></td>                    
                </tr>
                <?php $no++; } ?>
              </tbody>
          </table>
            
          </div>
        </div>
      </div>

      <footer>
        <hr>
        <p>&copy; <?php echo date('Y'); ?> FastPrint Indonesia</p>
      </footer>
    </div>
    

    <script src="assets/jquery.min.js"></script>
    <script src="assets/bootstrap.min.js"></script>
    <script src="assets/jquery.dataTables.min.js"></script>
    <script src="assets/jquery.magnific-popup.min.js"></script>
    
    <script>
      	$('.image-popup-no-margins').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            fixedContentPos: true,
            mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
            image: {
                verticalFit: true
            },
            zoom: {
                enabled: true,
                duration: 300 // don't foget to change the duration also in CSS
            }
        });
      
    	$(document).ready(function() {
          	$('[data-toggle="tooltip"]').tooltip({
                placement : 'bottom'
            });
          	
            $('#table_id').DataTable( {
                "language" : {
                      "sProcessing":   "Sedang memproses...",
                      "sLengthMenu":   "Tampilkan _MENU_ data",
                      "sZeroRecords":  "Tidak ditemukan data yang sesuai",
                      "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                      "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 data",
                      "sInfoFiltered": "(disaring dari _MAX_ data keseluruhan)",
                      "sInfoPostFix":  "",
                      "sSearch":       "Cari:",
                      "sUrl":          "",
                      "oPaginate": {
                          "sFirst":    "Pertama",
                          "sPrevious": "Sebelumnya",
                          "sNext":     "Selanjutnya",
                          "sLast":     "Terakhir"
                      }
                  }
            } );
        } );
    </script>

</body>
</html>
