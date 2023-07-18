<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
session_start();
require "plfp-backedit/connect.php";
buka_koneksi();

$key   = urldecode(@$_GET['key']); 
$arr   = explode(" ",$key);
$i 	   = 0;
$cari = '';
foreach($arr as $k){
	
	if($i == 0){
    	
    	$cari .= "judul_produk like '%".$k."%'";
    	
    }else{
    
    	$cari .= " and judul_produk like '%".$k."%'";
    
    }

	$i++;

}
$json       = array();

$query		= "SELECT judul_produk,kode_produk,link_produk,gambar_produk,harga as hrg,deskripsi_produk as desk FROM `tb_pricelist` where ".$cari." limit 5";
$dataQuery  = mysql_query($query);

if(mysql_num_rows($dataQuery) > 0){

  while($data = mysql_fetch_assoc($dataQuery)){
  
    $arr = array();
    $arr['value'] = "*".$data['judul_produk']."*";
    $arr['id']    = $data['kode_produk'];
    $arr['link']  = $data['link_produk'];
    $arr['hrg']   = "Rp " . number_format($data['hrg'],2,',','.');
    $arr['desk']  = $data['desk'];
    $arr['img']   = "http://pcls.fastprint.co.id/plfp-backedit/assets/images/".$data['gambar_produk'];

    array_push($json,$arr);

  }

}else{

	$query1		= "SELECT judul_produk,kode_produk,link_produk,gambar_produk,harga as hrg,deskripsi_produk as desk FROM `tb_pricelist` where kode_produk = '{$key}'";
	$dataQuery1  = mysql_query($query1);
	while($data1 = mysql_fetch_assoc($dataQuery1)){
    
     $arr = array();
     $arr['value'] = "*".$data1['judul_produk']."*";
     $arr['id']    = $data1['kode_produk'];
     $arr['link']  = $data1['link_produk'];
     $arr['hrg']   = "Rp " . number_format($data1['hrg'],2,',','.');
     $arr['desk']  = $data1['desk'];
     $arr['img']   = "http://pcls.fastprint.co.id/plfp-backedit/assets/images/".$data['gambar_produk'];

     array_push($json,$arr);

  }
}


echo json_encode($json);