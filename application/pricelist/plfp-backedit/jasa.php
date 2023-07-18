<?php
  session_start();
  require "connect.php";
    //buka_koneksi();
  if(!isset($_SESSION["user"]) || empty($_SESSION["user"])){
      echo "<script type='text/javascript'>alert('Anda belum login, login dulu !');</script>";
      header("location:login.php");
  } else {
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
    #myTable{

        width : 100% !important;

    }

	</style>
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <script src="axios.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">

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
              <a href="jasa.php">Jasa </a>
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


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Jasa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id="frm">
                
            </div>
           
        </div>
        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
    </div>
    </div>


    <div class="container">
      <br>
        <h3>
          Jasa &emsp;
 
         <button class="btn btn-primary" style="float:right;margin-bottom: 30px;" data-toggle="modal" data-target="#exampleModal" onclick="tambah()">Tambah Jasa</button>
        </h3>

    
    <table class="table table-striped table-hover table-bordered" id="myTable" style="margin-top:10px" cellpadding="0" cellspacing="0">
      <thead>
        <tr class="success">
                

            <!-- <th style="text-align:center;">#</th> -->
            <th style="text-align:center;">Jenis Kesalahan</th>
            <th style="text-align:center;">Tingkat Kesalahan</th>
            <th style="text-align:center;">Harga</th>
            <th style="text-align:center;">Keterangan</th>
            <th style="text-align:center;">Aksi</th>

        </tr>
      </thead>
      </table>






















    <script src="assets/js/jquery.min.js"></script>

    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Magnific Popup core JS file -->
    <script src="assets/js/jquery.magnific-popup.js"></script>
<!--
    <script src="assets/js/custom.js"></script>
-->
    <script src="//cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>
    <script src="pricelist.js?<?=md5("YmdHis")?>"></script>
    <script>
        function tambah(){

            $.get("form-jasa.php",(data)=>{

                $("#frm").html(data)

            })

        }

        function edit(e){

            $.get("form-jasa.php?id="+e,(data)=>{

                $("#frm").html(data)

            })

        }

        function hapus(e){

            if(confirm("Anda Yakin Mengahapus ini?")){


                window.location ="hapus.jasa.php?id="+e;

            }

        }

        $(document).ready( function () {
            $('#myTable').DataTable({
                ajax: {
                    url: 'data.jasa.php',
                    dataSrc: 'data'
                },
                "columnDefs": [
                    { "width": "100", "targets": [4] }
                ],
                columns: [
                    { data: "nama_kerusakan" },
                    { data: "tingkat_kesusahan" },
                    { data: "harga" },
                    { data: "keterangan" },
                    { data: "aksi" }
                ]

            });
        } );

    </script>

</body>
</html>


<?php
  }