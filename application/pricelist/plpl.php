<?php
session_start();
require "plfp-backedit/connect.php";
buka_koneksi();

if (isset($_GET['alias']) AND ($_GET['alias'] !== "")){
  //echo $_GET['alias'];
   header("Access-Control-Allow-Origin: *");
   header('Content-Type: application/json');

  $query = "SELECT tb_pricelist.kode_produk , tb_link.kode_ecomm, tb_link.link_produk, tb_link.nama_varian from tb_pricelist join tb_link on tb_pricelist.kode_produk = tb_link.kode_produk where tb_pricelist.nama_alias = '".$_GET['alias']."'";
  $result = mysql_query($query); 
  //echo $query;
  $listt= array();
  while($row =mysql_fetch_assoc($result))
  {
    $arr_baru = array();
    $parsed_url = parse_url($row['link_produk']);
    if (empty($parsed_url['scheme'])) {
      $urlStr = 'https://' . $row['link_produk'];
	}else{
   	   $urlStr = $row['link_produk'];
    }
  
  	 $arr_baru['kode_produk'] = $row['kode_produk'];
  	 $arr_baru['kode_ecomm'] = $row['kode_ecomm'];
  	 $arr_baru['link_produk'] = $urlStr;
  	 $arr_baru['nama_varian'] = $row['nama_varian'];
  	 array_push($listt,$arr_baru);
    //$listt[] = $row;
  }
  echo json_encode($listt, JSON_PRETTY_PRINT);
  
}
