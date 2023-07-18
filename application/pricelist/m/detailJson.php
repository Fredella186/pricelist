<?php
header('Content-Type: application/json; charset=utf-8');

$id = $_GET['id'];

require "../plfp-backedit/connect.php";
buka_koneksi();


if(isset($id)){
 $data = array();
 $d2   = array();
 $d3   = array();
 //echo "<pre>";
 $sql = "SELECT * FROM `tb_pricelist` join `tb_kategori` on tb_pricelist.`ktg_produk` = tb_kategori.id_ktg where status_view = 1 and tb_pricelist.kode_produk ='".$id."'";
 $query = mysql_query($sql);
 $dt = mysql_fetch_assoc($query);
  $harga1 = ($dt['harga_luar_jawa'] !== '' & $dt['harga_luar_jawa'] !== null) ? $dt['harga_luar_jawa']:$dt['harga'];
	$dt1 = array('rentang_qty'=>1,'rp'=>"Rp. " . number_format($dt['harga'],0,'',','),'rp_luar'=>"Rp. " . number_format($harga1,0,'',','));

	// $dt2 = array('rentang_qty'=>1,'rp'=>"Rp. " . number_format($harga1,0,'',','));
 	array_push($d2,$dt1);
 	// array_push($d3,$dt2);
 
  $query1 = mysql_query("SELECT * FROM tb_wholesale where id_produk = '".$dt['kode_produk']."' order by `harga_wholesale` DESC ");
  while($dt1 = mysql_fetch_assoc($query1)){
     $dt1['rp'] = "Rp. " . number_format($dt1['harga_wholesale'],0,'',',');
     
     $harga_luar = ($dt1['harga_wholesale_luar'] !== "" && $dt1['harga_wholesale_luar'] !== null) ? $dt1['harga_wholesale_luar']:$dt1['harga_wholesale'];
     $dt1['rp_luar'] = "Rp. " . number_format($harga_luar,0,'',',');
     
    
    array_push($d2,$dt1);

  }

  echo json_encode(array('p'=>$dt,'d'=>$d2));

}