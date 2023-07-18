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
         <br>
         <div class="bs-docs-section">
            <div class="row">
               <div class="col-lg-12" style="overflow:hidden">
                  <table class="table table-striped table-hover table-bordered" id="table_id"  cellspacing=0>
                     <thead>
                        <tr class="success">
                           <th style="text-align:center; width:15px;">No</th>
                           <th style="text-align:center;">id</th>
                           <th style="text-align:center;">Gambar</th>
                           <th style="text-align:center; width:35%">Judul</th>
                           <th style="text-align:center; width:15%">Kategori</th>
                           <th style="text-align:center; width:15%">Harga</th>
                           <th style="text-align:center; width:5%">Berat</th>
                           <th style="text-align:center;">Link</th>
                        </tr>
                     </thead>
                  </table>
               </div>
            </div>
         </div>
         <footer>
            <hr>
            <p>&copy; <?php echo date('Y'); ?> FastPrint Indonesia <span style="float:right;margin-top: -8px;"><b>Tampil</b> <select onchange='pilih(this)' >
            	<option value='10'>10</option>
            	<option value='25'>25</option>
            	<option value='50'>50</option>
            	<option value='100'>100</option>
            </select> </span></p>
         </footer>
      </div>
      <script src="assets/jquery.min.js"></script>
      <script src="assets/bootstrap.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
      <script src="assets/jquery.magnific-popup.min.js"></script>
      <script>
         function buka_gambar(t){
            $("#gmbr").attr("src", t.src);
             $('#m-gambar').modal('show');
         }
         
function pilih(e){
  $('#table_id').DataTable().page.len(e.value ).draw();
}
         
         $(document).ready(function() {
             	$('[data-toggle="tooltip"]').tooltip({
                   placement : 'bottom'
               });
               $('#table_id').dataTable({
               sAjaxSource : 'JSON_data.php',
               "searching": true,
               "scrollX":true,
               "columnDefs": [
               {
                   "targets": [1],
                   "visible": false,
                   "searchable": false
               }],
               
           });
         	  $('#cari').on( 'keyup', function () {
    		   $('#table_id').dataTable().fnFilter(this.value);
        	   $('#table_id').DataTable().column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            		cell.innerHTML = i+1;
        	   });
         
			  });
           } );
           function buka_harga(id){
           $.get( "harga2.php?id="+id, function( data ) {
            $("#"+id).html(data);
           });
         }
      </script>
   </body>
</html>