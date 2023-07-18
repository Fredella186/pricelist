<?php
    session_start();
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

      <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      <link href="assets/css/bootstrap2-toggle.css" rel="stylesheet">
      
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

    <div class="container">
        <h4>Data Produk Hidden</h4> <br/>
        <div class="table-responsive">
            <table id="dt_hidden-data" class="table table-striped table-hover table-bordered" cellpadding="0" cellspacing="0">
                <thead>
                <tr class="success">
                    <th style="text-align:center; width:50px;">#</th>
                    <th style="text-align:center; width:150px;">Gambar</th>
                    <th style="text-align:center; width:300px;">Judul</th>
                    <th style="text-align:center; width:30px;">Aksi</th>
                </tr>
                </thead>
                <tbody >

                </tbody>
            </table>
        </div>
    </div>

    <script
	  src="https://code.jquery.com/jquery-3.4.1.min.js"
	  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	  crossorigin="anonymous"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      <script src="assets/js/bootstrap2-toggle.js"></script>
      <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>



    <script>
		$( document ).ready(function() {
			
			$.get("data_hidden.php", function( data ) {
			  
			  arr_data = JSON.parse(data);
			  no = 1;
			  arr_data.forEach(e=>{
				  
				  nama   = e['judul_produk'];
				  gambar = e['gambar'];
				  id     = e['id'];
				  
				  html = `<tr>
						    <td>${no++}</td>
						    <td><img src='assets/images/${gambar}' width='100px'></td>
							<td>${nama}</td>
                            <td>
                                <input type="button" class="btn btn-success" onclick="actived('${id}')" value="Actived"/>                      
                            </td>
						  </tr>`;
						  
                  $("#dt_hidden").append(html);
                  
                
			  }) 
			   
            });
            
            $('#dt_hidden-data').DataTable( {
               "processing": true,
               "serverSide": false,
               "ajax":{url:"data_hidden.php",dataSrc:""},
               "columnDefs": [
               {
                  "targets": 0,
                  "data": "id",
                  render: function (data, type, row, meta) {
                     return meta.row + meta.settings._iDisplayStart + 1;
                  }
               },{
                  "data": "gambar",
                  "targets": 1,
                  render: function (data, type, row, meta) {
                     return '<img src="assets/images/'+data+'" style="width:70px; height:70px;">';
                  },
                  
               },{
                  "targets": 2,
                  "data": "judul_produk" 
               },{
                  "targets": -1,
                  "data": "id",
                  render: function (data, type, row, meta) {
                     return '<input type="button" class="btn btn-success" onclick="actived('+data+')" value="Actived"/>';
                  }
                  
               }]
               
            }); 

        });

        function actived(kodeProd){
                
            $.get("data_hidden.php?activ=1&id_prod="+kodeProd, function(data){
                location.reload();
            });
            
        }

        </script>
</body>
</html>