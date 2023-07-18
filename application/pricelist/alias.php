<?php
    session_start();
    include "connect.php";
    buka_koneksi();
    $now = time();
    if(isset($_SESSION["user"]) || !empty($_SESSION["user"]) ){
     
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
         </div>
      </nav>
      <div class="container">
         
         <h4 style='margin-top:25px'>Penambahan Nama Alias Link Ecommerce</h4>         
          
          <!--form style='margin-top:55px'>
            <div class="form-group">
                <label for="exampleInputEmail1">Nama Produk PL</label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama Produk PL" style='margin-top:20px'>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Nama Produk Web</label>
                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nama Produk Web" style='margin-top:20px'>
            </div>
           
            <button type="submit" class="btn btn-default">Simpan</button>
          </form-->
                  
     </div>
	 
	 <div class='container'>
		<div class='col-md-4 row'>
			<input type='text' onkeyup='cari(this)' class='form-control' placeholder='Cari Produk'>
		</div>
		
		<table class='table table-bordered' style='margin-top:50px'>
		  <tr>
			<td width='25px'>No</td>
			<td>Gambar</td>
			<td>Nama Produk</td>
			<td width='150px'>Aksi</td>
		  </tr>
		  <tbody id='aaa'>
		
		
	      </tbody>
		</table>
	 
	 </div>
	 
	 
	<!-- form tambah alias -->
	<div class="modal fade" id="flipFlop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
					<h4 class="modal-title" id="modalLabel">Tambah Alias</h4>
				</div>
				
				<div class="modal-body">
				  <b id='jdl'></b>
				  <hr>
				  <div class='col-md-12 row'>
				    <div class='col-md-11 row'>
						<input type='text' placeholder='Tambahkan Nama Web' name='alias' id='alias' class='form-control'>
						<input type='hidden' name='nama_pl' id='nama_pl'>
						<input type='hidden' name='id_pl' id='id_pl'>
						
					</div>
					<div class='col-md-1'>
						<button type='button' class='btn btn-primary' onclick='simpan_alias()'>Tambah</button>
					</div>
				 
				  </div>
				   
				  
					  <table class='table table-bordered' style='margin-top:75px'>
						<tr>
						  <td width='20px'>No</td>
						  <td>Nama Web</td>
						  <td width='25px'>Aksi</td>
						</tr>
						<tbody id='data_alias'>
						
						</tbody>
					  </table>
				  
				
				 
				  
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
		 
	 <script
	  src="https://code.jquery.com/jquery-3.4.1.min.js"
	  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	  crossorigin="anonymous"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	 <script>
		$( document ).ready(function() {
			$("tbody").append('');
			$.get("data_alias.php", function( data ) {
			  
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
							<td><button type='button' onclick="opennnn('${nama}','${id}')" class='btn btn-primary' data-toggle='modal' data-target='#flipFlop'>Tambah Alias</button></td>
						  </tr>`;
						  
				  $("#aaa").append(html);
			  })
			  
			});
		});
		
		function opennnn(ee,aa){
			
			$('#data_alias').html('');
			$('#jdl').html(ee.toUpperCase());
			$('#id_pl').val(aa);
			$('#nama_pl').val(ee);
			
			$.get("data_alias.php?id="+aa, function(data){
				d = JSON.parse(data);
				no = 1;
				d.forEach(e=>{
					
					alias = `<tr>
							<td>${no++}</td>
							<td>${e['alias']}</td>
							<td><a href='data_alias.php?hapus=1&id_hapus=${e['id_link']}' class='btn btn-primary'>Hapus</a></td>
						 </tr>`;
					$('#data_alias').append(alias);
				
					
				})
				
			})
			
			//return false;
			
		}
		
		function simpan_alias(){
			
			alias   = $('#alias');
			nama_pl = $('#nama_pl');
			id_pl   = $('#id_pl');
			
			if(alias.val() !== '' && nama_pl.val()!=='' && id_pl.val()!==''){
				
				
				$.post( "data_alias.php", {'nama_alias':alias.val(),'id_pl':id_pl.val(),'nama_pl':nama_pl.val()}, data =>{
					
					$('#flipFlop').modal('hide');
					
				});
				
				
			}else{
				
				alert('Ada form yang masih kosong');
			}
			
			
		}
		
		function cari(e){
		  $("#aaa").html("<tr><td colspan='3'>Tunggu</td></tr>");
		  $.post( "data_alias.php?cari=ya", {'cari':$(e).val()}, data =>{
			 $("#aaa").html("");	
			 data2 = JSON.parse(data);
			 console.log(data2);
			 no =1;
			 data2.forEach(e=>{
				  
				  nama   = e['judul_produk'];
				  gambar = e['gambar'];
				  id     = e['id'];
				  
				  html = `<tr>
						    <td>${no++}</td>
						    <td><img src='assets/images/${gambar}' width='100px'></td>
							<td>${nama}</td>
							<td><button type='button' onclick="opennnn('${nama}','${id}')" class='btn btn-primary' data-toggle='modal' data-target='#flipFlop'>Tambah Alias</button></td>
						  </tr>`;
						  
				  $("#aaa").append(html);
			  })
		  });
		
		  //console.log($(e).val());
			
			
		}
		
	 </script>
	 
   </body>
</html>

<?php
}else{
	header("location:index.php");
}                  
?>