<?php
	require "plfp-backedit/connect.php";
	buka_koneksi();
	if(!empty($_GET['key']) && $_GET['key'] == md5('apiku h-d-M-y')){
		$barcode = $_GET['barcode'];
		$data = array();
		$data['data'] = array();
		$qGrosir = mysql_query("SELECT rentang_qty, harga_wholesale FROM tb_wholesale WHERE id_produk = '".$barcode."' ORDER BY `harga_wholesale` DESC");
		
		while($datas = mysql_fetch_array($qGrosir)){
			array_push($data['data'],$datas);
		}
		$data['row'] = mysql_num_rows($qGrosir);

		$qProd = mysql_query("SELECT harga FROM tb_pricelist WHERE kode_produk = '".$barcode."'");
		$get_prod = mysql_fetch_array($qProd);
		$data['harga'] = !empty($get_prod)?$get_prod['harga']:'0';
		
		
		header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        header("Access-Control-Allow-Origin: *");
		
		echo json_encode($data);
		
	}else{
		echo 'GAGAL';
	}
?>