<?php
	require "plfp-backedit/connect.php";
	buka_koneksi();
	if(!empty($_GET['key']) && $_GET['key'] == md5('apiku h-d-M-y')){
		$barcode = $_GET['barcode'];
		$data = array();

		$qProd = mysql_query("SELECT * FROM tb_pricelist WHERE kode_produk = '".$barcode."'");
		$data['produk'] = mysql_fetch_array($qProd);
		
		
		
		header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        header("Access-Control-Allow-Origin: *");
		
		echo json_encode($data);
		
	}else{
		echo 'GAGAL';
	}
?>