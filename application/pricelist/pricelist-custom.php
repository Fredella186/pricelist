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
<script defer src="https://use.fontawesome.com/releases/v5.6.3/js/all.js" integrity="sha384-EIHISlAOj4zgYieurP0SdoiBYfGJKkgWedPHH4jCzpCXLmzVsw1ouK59MuUtP4a1" crossorigin="anonymous"></script>


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
		.icon-down{
    	float: right;
    	font-size: 20px;
        }
	</style>
  </head>
  <body>

  <div class="modal fade" id="m-gambar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id='gmbr' width='100%'>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand">FastPrint - Price List</a>
        </div>
     
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
        
            
            <h3>Price List Produk Fast Print Indonesia</h3>
            <table class="table table-striped table-hover table-bordered" id="table_id" cellspacing=0>
              <thead>
              <tr class="success">
                  <th style="text-align:center; width:20px;">#</th>
                  <th style="text-align:center; width:55px;">id</th>
                  <th style="text-align:center; width:55px;">Gambar</th>
                  <th style="text-align:center; width:250px;">Judul</th>
                  <th style="text-align:center; width:130px;">Kategori</th>
                  <th style="text-align:center; width:170px;">Harga</th>
                  <th style="text-align:center; width:30px;">Berat</th>
              </tr>
              </thead>
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
 
      function buka_gambar(t){
         $("#gmbr").attr("src", t.src);
          $('#m-gambar').modal('show');
      }

      
    	$(document).ready(function() {
          	$('[data-toggle="tooltip"]').tooltip({
                placement : 'bottom'
            });
            $('#table_id').dataTable({
            sAjaxSource : 'JSON_data.php',
            "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            }]
        });
        } );
        function buka_harga(id){
        $.get( "harga2.php?id="+id, function( data ) {
         $("#"+id).html(data);
         console.log(data);
        });
    }
    </script>

</body>
</html>
