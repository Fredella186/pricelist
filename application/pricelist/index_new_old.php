<?php
    session_start();
    require "plfp-backedit/connect.php";
	buka_koneksi();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>FastPrint - Price List</title>
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" media="screen">
	<link rel="stylesheet" href="assets/magnific-popup.min.css">
	<link rel="stylesheet" href="assets/css/custom.min.css">
	
	<link rel="stylesheet" type="text/css" href="media/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="resources/syntax/shCore.css">
	<!-- <link rel="stylesheet" type="text/css" href="resources/demo.css"> -->
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

<body class="">

	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
			<a href="#" class="navbar-brand">FastPrint - Price List</a>
			</div>
			
		</div>
	</div> 

	<div class="container">
		<div class="bs-docs-section">
			<div class="row">
				<div class="col-lg-12">
				<h3>Price List Produk Fast Print Indonesia</h3>
				<section class="table-responsive">
					<table id="example" class="display table table-striped table-hover table-bordered" cellspacing="0">
						<thead class="success">
							<tr>
								<th style="text-align:center; ">#</th>
								<th style="text-align:center;">Gambar</th>
								<th style="text-align:center;">Judul</th>
								<th style="text-align:center; ">Kategori</th>
								<th style="text-align:center; ">Berat</th>
								<th style="text-align:center; ">Harga</th>
								<!-- <th  style="text-align:center; "></th> -->
								<th style="text-align:center;">Harga Grosir</th>
							</tr>
						</thead>
					</table>	
				</section>
				</div>
			</div>
		</div>
	</div>
	
	<footer>
	<hr>
	<p>&copy; <?php echo date('Y'); ?> FastPrint Indonesia</p>
	</footer>
	
	<script src="assets/jquery.min.js"></script>
    <script src="assets/bootstrap.min.js"></script>
    <script src="assets/jquery.dataTables.min.js"></script>
    <script src="assets/jquery.magnific-popup.min.js"></script>

	<script type="text/javascript" language="javascript" class="init">

		var hargalist = [];
		// var complex = <?php //echo json_encode($data); ?>;
		// console.log(complex);
		
		

		$(document).ready(function() {

			function rupiahformat(data){
				//console.log(data);
				var thousand_separator = '.'; 
				var	reverse   = data.toString().split('').reverse().join(''),
					thousands = reverse.match(/\d{1,3}/g);
					result 	  = thousands.join(thousand_separator).split('').reverse().join('');

				return "Rp. "+result +",-";
			}

			$('#example').dataTable( {
				"processing": true,
				"serverSide": true,
				"ajax": "scripts/server_processing.php",
				"order": [[2, "asc"]],
              	"sPaginationType": "full_numbers",
				"autoWidth": false,
				"language" : {
                      "sProcessing":   "Sedang memproses...",
                      "sLengthMenu":   "Tampilkan _MENU_ data",
                      "sZeroRecords":  "Tidak ditemukan data yang sesuai",
                      "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                      "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 data",
                      "sInfoFiltered": "",
                      "sInfoPostFix":  "",
                      "sSearch":       "Cari:",
                      "sUrl":          "",
                      "oPaginate": {
                          "sFirst":    "Pertama",
                          "sPrevious": "Sebelumnya",
                          "sNext":     "Selanjutnya",
                          "sLast":     "Terakhir"
                      }
                },
				"columnDefs": [ 
					{ "orderable": false, "targets": [0, 1, 3, 4, 5, 6] },
					//{ width: 10, "targets": 0 },
					//{ width: 20, "targets": 1 },
					{ width: 400, "targets": 2 },
					//{ width: 20, "targets": 3 },
					// { width: 100, "targets": 4 },
					{ "width":"100px !important", "targets": 5 },
					// // //{ "width": "0%", "targets": 6 },
					// { width: 230, "targets": 6 },
					{ "sClass": "ffcell", "aTargets": [ 5 ] },
					{
						"targets": 0,
						"data": "ID", 
						render: function (data, type, row, meta) {
								return meta.row + meta.settings._iDisplayStart + 1;
						}
					},
					{
						"targets": 4,
						//"data": "price", 
						"render": function (data, type, row, meta){
							return '<span>'+data+' Gr</span>';
						}
					},
					{
						"targets": 5,
						//"data": "price", 
						"render": function (data, type, row, meta) {
								return rupiahformat(data);
						}
					},
					{
						"render": function (data, type, row) {
							return '<a class="image-popup-no-margins" href="plfp-backedit/assets/images/'+data+'"><img src="plfp-backedit/assets/images/'+data+'" style="width:70px; height:70px;"></a>';
						},
						"targets": 1
					},
					// {   "targets": 6,
					// 	"visible": false,
					// 	"searchable": false
						
					// },
					{
						"targets": -1,
						// "data": null,
						"render": function (data, type, row) {
							return 	"<td class='harga-tingkat' style='width: 25%;'>"+
										"<div class='panel-group panel-harga' id='accordion' style='width: 180px;'>"+
										"<div class='panel panel-default' id='panel"+data+"'>"+
										"<div id='"+data+"' class='panel-heading hrg-action'>"+
										"<h5 class='panel-title '>"+
										"<a id='hrgact"+data+"' class='accordion-toggle collapsed ' aria-expanded='false' data-toggle='collapse' data-parent='accordion' href='#collapse"+data+"' style='text-decoration:none;'>"+
										"<span class='harga-val'>Lihat</span>"+
										"</a>"+
										"</h5>"+
										"</div>"+
										"<div id='collapse"+data+"' class='panel-collapse collapse'>"+
										"<div class='table-responsive'>"+
										"<table id='tab-harga' class='table table-bordered table-striped table-hover'>"+
										"<thead>"+
										"<tr class='warning'>"+
										"<th style='text-align:center;'>Qty</th>"+
										"<th style='text-align:center;'>Harga</th>"+
										"</tr></thead>"+
										"<tbody class='hrg-level'></tbody>"+
										"</table>"+
										"</div>"+
										"</div>"+
										"</div>"+
										"</div>"+
									"</td>";                    
						}        
					} 
				]
			});

			

		});

		$('#example').on('click', 'div .hrg-action', function() {
			var url 	= "http://crud.fastprint.co.id/server_processing_harga.php";
			//var url 	= "http://localhost/pricelist/pricelistbeta/scripts/server_processing_harga.php";
			var prod_id = this.id;

			$.post(url, {id: prod_id}, function (data){
				$(".hrg-level").html(data).show();
			});
		});

		setTimeout(function() {
          
          	$.fn.dataTableExt.afnFiltering.push(
				function(oSettings, aData, iDataIndex) {
					var filter = $("#example_filter input").val();
					filter = filter.split(' ');
					for (var f=0;f<filter.length;f++) {
						for (var d=0;d<aData.length;d++) {
							if (aData[d].indexOf(f)>-1) {
								return true;
							}
						}
					}
				}
			);

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

			$('[data-toggle="tooltip"]').tooltip({
				placement : 'bottom'
			});
				
        }, 3500);

		

	</script>


</body>
</html>