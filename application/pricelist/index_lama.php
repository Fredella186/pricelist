<?php
   session_start();
   
   if(empty($_SESSION['id_kat'])){
      $_SESSION['id_kat'] = array();
   }

   require "plfp-backedit/connect.php";
   buka_koneksi();
   
   if(isset($_GET['p'])){
      
      foreach($_SESSION['id_kat'] as $index => $ket){

         if($ket == $_GET['p']){
            unset($_SESSION['id_kat'][$index]);
         }

      }

      array_push($_SESSION['id_kat'],$_GET['p']);
   }

   if(isset($_GET['h'])){
      
      foreach($_SESSION['id_kat'] as $index => $ket){

         if($ket == $_GET['h']){
            unset($_SESSION['id_kat'][$index]);
         }

      }
   }
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
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

      <link rel="stylesheet" href="assets/jquery.dataTables.min.css">
      <link rel="stylesheet" href="assets/magnific-popup.min.css">
	  <link href='https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.css'>
      <style>
         .panel-heading .accordion-toggle:after {
         font-family: 'Glyphicons Halflings';
         content: "\e114";
         float: right;
         color: grey;
         font-size:12px;
         }
         .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate {
            line-height: 20px;
         }
         td:nth-of-type(1) {
            text-align: center;
         }

         td:nth-of-type(3) {
            text-transform: uppercase;
         }
         footer {
            margin: 0;
            height: 60px;
         }.bs-docs-section {
            margin-top: 20px;
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
         .btn.disabled, .btn[disabled], fieldset[disabled] .btn {
         cursor: not-allowed;
         opacity: 1 !important; 
         -webkit-box-shadow: none;
         box-shadow: none;
         }
         a.btn.btn-success.btn-block {
         width: 180px;
         }
         .input-group {
            background: white;
         }
         button.btn.btn-default.ic-cus {
            background: white;
            border: 0;
            color: #2c3e50;
            border-radius: 0;
         }
         .navbar-form .input-group>.form-control {
               width: 95%;
            border: 0;
            max-height: 100%;
            height: 41px;
         }
         .input-group-btn {
            right: 0;
            position: absolute;
         }
         form.navbar-form.navbar-right {
            width: 80%;
         }
         div#table_id_filter {
            display: none;
         }
         .input-group {
            width: 100%;
         }
         .navbar-form .input-group>.form-control {
            max-width: 95%;
            border: 0;
         }
         @media only screen and (max-width: 1000px) {
         .container {
         width:100% !important
         }
         }

         @media only screen and (max-width: 890px) {
         form.navbar-form.navbar-right {
            width: 75%;
         }
         }
         div#table_id_length {
            bottom: -5px;
            position: absolute;
            width: 100%;
            text-align: center;
            margin-left: -104px;
            display:none
         }


         @media only screen and (max-width: 800px) {
         .th-kategori {
         width:30% !importaint;

         }
         .navbar-form {
            margin-left: 0;
            margin-right: 0;
            padding-left: 0;
            padding-right: 0;
            border-top: none;
            border-bottom: 1px solid transparent;
            -webkit-box-shadow: none;
            box-shadow: none;
            margin-top: 7.5px;
            margin-bottom: 7.5px;
         }
         form.navbar-form.navbar-right {
            width: 100% !important;
            overflow: hidden;
         }
         a.navbar-brand {
            width: 100%;
            text-align: center;
            font-size: 25px;
         }
         .bs-docs-section {
               margin-top: 100px;
            margin-bottom: 45px;
         }
         div#table_id_length {
            bottom: -20px;;
            position: absolute;
            width: 100%;
            text-align: center;
            margin-left: 0;
            /* margin-top: 36px; */
         }
         }
         .fa-exchange-alt{
         float:right;
            -webkit-transform: rotate(90deg);
            -moz-transform: rotate(90deg);
            -o-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            transform: rotate(90deg);
         margin-top:5px;
         
         }

         .badge {
            margin: 1px;
         }
         i.fas.fa-times {
            background: white;
            color: black;
            border-radius: 50%;
            padding: 5px;
            width: 24px;
            margin-left: 20px;
            margin-right: -3px;
         }
         .img-responsive{
 		   max-height: 130px !important;
 		   position: absolute;
 		   left: 50%;
  		 top: 50%;
   		 transform: translate(-50%, -50%);

         }
         .kategori-div{
            margin-top:10px;
            max-height:350px;
            cursor: pointer;
         }
         .item-kategori {
            margin: 0px;
            border: 1px solid lightgray;
            max-width: 100%;
            height: 240px;
            text-align: center;
         }
         .item-kategori:hover {
            box-shadow: 0px 1px 10px -1px grey;
         }
		.bs-docs-section {
   			 padding-bottom: 84px;
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
      <nav class="navbar navbar-default navbar-fixed-top">
         <div class="container">
            <div class="navbar-header">
               <a class="navbar-brand" href="#">FastPrint - Price List</a>
            </div>


            <form class="navbar-form navbar-right" action="#" onsubmit='return false'>
               
                     <div class="input-group">
                        <input type="text" class="form-control" id='cari' placeholder="Cari">
                        <div class="input-group-btn">
                           <button class="btn btn-default ic-cus" type="submit">
                           <i class="glyphicon glyphicon-search"></i>
                           </button>
                        </div>
                     </div>   
               
              
            </form>


         </div>
      </nav>
      <div class="container">
         
         <div class='row' style='margin-top:27px'>
            <div class='kategori col-md-2' >
               <button class='btn btn-primary'  data-toggle="modal" data-target="#kategori">Pilih Kategori</button>
               
            </div>
            <div class='col-md-10 tags' >
               <?php
                  foreach($_SESSION['id_kat'] as $k){
                   $query_a = mysql_query("select * from tb_kategori where nama_ktg = '".$k."'");
                   $dk      = mysql_fetch_assoc($query_a); 
               ?>
                
                <a href="index.php?h=<?php echo $dk['nama_ktg']; ?>" class="badge badge-primary"><?php echo $dk['nama_ktg']; ?> <i class="fas fa-times"></i></a>

               <?php
                  }
               ?>
            </div>
         </div>


         <!-- The Modal -->
         <div class="modal fade" id="kategori">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">

               <!-- Modal Header -->
               <div class="modal-header">
               <h4 class="modal-title">Pilih Kategori</h4>
               </div>

               <!-- Modal body -->
               <div class="modal-body">
                  <div class='row'>
               
                     <?php


                        $sql_kategori = "Select id_ktg,nama_ktg,gambar_produk from tb_kategori join tb_pricelist on tb_kategori.id_ktg = tb_pricelist.ktg_produk group by nama_ktg order by nama_ktg asc";
                        $result  = mysql_query($sql_kategori);
                        while($dkategori = mysql_fetch_assoc($result)){
                           $nama_ktg = $dkategori['nama_ktg'];
                        
                           
                        
                        
                        
                           echo "<div class='col-md-3 kategori-div' onclick='pilih_kategori(\"$nama_ktg\")'>";
                              echo "<div class='item-kategori'>";
                             //echo str_replace('/','',$dkategori['nama_ktg']);
                       		 if(file_exists('kategori/'.str_replace('/','',$dkategori['nama_ktg']).".jpg")){
    						  	echo "<center style='margin-bottom:5px;padding:5px;height:200px'> <img class='img-responsive' src='kategori/".str_replace('/','',$dkategori['nama_ktg']).".jpg' > </center>";
                           
					       	}else{
   							  	echo "<center style='margin-bottom:5px;padding:5px;height:200px'> <img class='img-responsive' src='plfp-backedit/assets/images/".$dkategori['gambar_produk']."' > </center>";
                           
						   	}
                                 
                                 echo "<b>".$dkategori['nama_ktg']."</b>";
                        
                       
                                 echo "</div>";
                           echo "</div>";

                        }
                     
                     
                     ?>
                  </div>                 
               </div>

               <!-- Modal footer -->
               <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
               </div>

            </div>
         </div>
         </div>
 

         <div class="bs-docs-section">
            <div class="row">
               <div class="col-lg-12" style="overflow:hidden">
                  <table class="table table-striped table-hover table-bordered" id="table_id"  cellspacing=0>
                     <thead>
                        <tr class="success">
                           <th style="text-align:center; width:15px;">No</th>
                           <th style="text-align:center;">id</th>
                           <th style="text-align:center;">Gambar</th>
                           <th style="text-align:center; width:35%">Judul <i class="fas fa-exchange-alt"></i></th>
                           <th style="text-align:center; width:15%" class='th-kategori'>Kategori <i class="fas fa-exchange-alt"></i></th>
                           <th style="text-align:center; width:15%">Harga <i class="fas fa-exchange-alt"></i></th>
                           <th style="text-align:center; width:5%">Berat</th>
                           <th style="text-align:center;">Link</th>
                     	   <th>SKU</th>
                        </tr>
                     </thead>
                  </table>
                  <span><b>Tampil</b> 
           			 <select onchange='pilih(this)' >
               			 <option value='10'>10</option>
               			 <option value='25'>25</option>
                		 <option value='50'>50</option>
                		<option value='100'>100</option>
            		</select> </span>
               </div>
            </div>
         </div>
         <footer style='position:fixed;width:100%;background:white;bottom:0;height: 30px;padding: 10px;'>
            <p>&copy; <?php echo date('Y'); ?> FastPrint Indonesia <a href='/m'>Mode Mobile</a>
            </p>
         </footer>
      </div>
        <script src="assets/jquery.min.js"></script>
      	<script src="assets/bootstrap.min.js"></script>
     	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
      	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.6/dist/js/bootstrap-select.min.js"></script>
      	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.6/dist/js/i18n/defaults-*.min.js"></script>
      	<script src='https://cdn.jsdelivr.net/mark.js/8.6.0/jquery.mark.min.js'></script>
      	<script src='https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.js'></script>
      <script>
          
            
         function buka_gambar(t){
            $("#gmbr").attr("src", t.src);
             $('#m-gambar').modal('show');
         }

         function pilih_kategori(e){
            window.location='index.php?p='+e;
         }
                  
         function pilih(e){
         $('#table_id').DataTable().page.len(e.value ).draw();
         }
         
         $(document).ready(function() {
		 console.log(window.location.href);
         if(window.location.href == "http://pcls.fastprint.co.id/" ){
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
			if (isMobile) {
  				window.location = "http://pcls.fastprint.co.id/m/";
			}
         }
         
           	$('[data-toggle="tooltip"]').tooltip({
                   placement : 'bottom'
               });
               $('#table_id').dataTable({
               sAjaxSource : 'JSON_data.php',
               "searching": true,
               "mark": true,
               "scrollX":true,
               "columnDefs": [
               {
                   "targets": [1],
                   "visible": false,
                   "searchable": false
               },
               {
                   "targets": [8],
                   "visible": false,
                   "searchable": true
               }],
               
           });
         	  $('#cari').on( 'keyup', function () {
    		   $('#table_id').dataTable().fnFilter(this.value);
        	   $('#table_id').DataTable().column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            		cell.innerHTML = i+1;
        	   });
         
			  });
           });

           function buka_harga(id){
           $.get( "harga2.php?id="+id, function( data ) {
            $("#"+id).html(data);
           });
         }
      </script>
   </body>
</html>