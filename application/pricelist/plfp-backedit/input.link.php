<?php
	include "connect.php";
	
	buka_koneksi();
    $response = "";
        
    if(isset($_POST['id_link'])){
		$id = $_POST['id_link'];
		if(isset($_POST['stat']) && $_POST['stat'] == "hapus"){
			$sql = "DELETE FROM tb_link WHERE id_link = '".$id."'";			
			if(mysql_query($sql))
				$response = "deleted";
			else
				$response = "failed";
		} else if(isset($_POST['stat']) && $_POST['stat'] == "hapusWeb"){
			$sql = "UPDATE tb_pricelist SET link_produk = '' WHERE kode_produk = '".$id."'";			
			if(mysql_query($sql))
				$response = "deleted";
			else
				$response = "failed";
		} else if (isset($_POST['status']) && $_POST['status'] == "simpanLinksemua") {
			$kode_produk = $_POST['kode_produk'];
			$links	 = $_POST['links'];
        	$varians = $_POST['varians'];
			$sql="UPDATE tb_link SET nama_varian = '".$varians."' WHERE kode_produk = '".$kode_produk."'";
			if(mysql_query($sql))
				$response = "updated";
			else
				$response = "failed";
		} else if (isset($_POST['status']) && $_POST['status'] == "simpanLinksemuaWeb") {
			$kode_produk = $_POST['id_link'];
			$links	 = $_POST['links'];
			$sql="UPDATE tb_pricelist SET link_produk = '".$links."' WHERE kode_produk = '".$kode_produk."'";
			if(mysql_query($sql))
				$response = "updated";
			else
				$response = "failed";
		} else if(isset($_POST['links']) && $_POST['links'] != ""){
			$links	 = $_POST['links'];
        	$varians = $_POST['varians'];
			$sql = "UPDATE tb_link SET link_produk = '".$links."', nama_varian = '".$varians."' WHERE id_link = '".$id."'";			
			if(mysql_query($sql))
				$response = "updated";
			else
				$response = "failed";
		}
	} else {
		$sku		= $_POST['sku'];
		$kd_ecomm	= $_POST['kd_ecomm'];
		$links	    = $_POST['links'];
    	$varians 	= $_POST['varians'];
		if($sku != "" && $kd_ecomm != "" && $links != ""){
			$sql = "INSERT INTO tb_link (kode_produk, kode_ecomm, nama_varian, link_produk, input_time, update_time) VALUES 
			('".$sku."', '".$kd_ecomm."', '".$varians."', '".$links."', NOW(), NOW())";
			
			if(mysql_query($sql))
				$response = "inserted";
			else
				$response = "failed";
		}
	}

    echo $response;
	tutup_koneksi();
