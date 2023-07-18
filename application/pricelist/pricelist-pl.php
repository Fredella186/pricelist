<?php 
session_start();
require "plfp-backedit/connect.php";
buka_koneksi();
//echo urldecode($_GET['alias']);


if (isset($_GET['alias']) AND ($_GET['alias'] !== "")){
  
   header("Access-Control-Allow-Origin: *");
   header('Content-Type: application/json');

	$toko = '';
$sql_ket  = "SELECT * FROM  `tb_ecommerce` GROUP BY nama_toko ";
$qket     = mysql_query($sql_ket);
$jml_k    = mysql_num_rows($qket);
$i = 0;
while($fk = mysql_fetch_assoc($qket)){
	if($i !== 0 && $i < $jml_k){
    	$toko .='|';
    }

	$toko .= $fk['nama_toko'];
	
	$i++;

}

$regex_toko = '/'.$toko.'/';

  $query = "SELECT tb_pricelist.kode_produk , tb_link.kode_ecomm, tb_link.link_produk, tb_link.nama_varian from tb_pricelist join tb_link on tb_pricelist.kode_produk = tb_link.kode_produk where tb_pricelist.nama_alias = '".$_GET['alias']."' order by tb_link.nama_varian asc";
 //echo $query; 
 $result = mysql_query($query); 
  //echo $query;
  $jml = mysql_num_rows($result);

  $listt= array();
  
  if($jml > 0 ){
	  
	while($row =mysql_fetch_assoc($result))
	{
    
    
			$arr_baru = array();
			$parsed_url = parse_url($row['link_produk']);
    		$link	= $row['link_produk'];
    		
    
    		$arr22   =  preg_split($regex_toko, $link, -1, PREG_SPLIT_DELIM_CAPTURE);
    		$toko  =  preg_match($regex_toko,$link,$match);
    		//print_r($arr22);
   			// $link_1  = $match[0];
    		// $link_2 = $arr22[1];

			$link_1  = isset($match[0])?$match[0]:'';
    		$link_2 = isset($arr22[1])?$arr22[1]:'';
    
    
			// if (empty($parsed_url['scheme'])) {
			//   $urlStr = 'https://' . $row['link_produk'];
			// }else{
			//    $urlStr = $row['link_produk'];
			// }
    		
    		$url_baru = 'http://'.$link_1.$link_2;
    
		  
			 $arr_baru['kode_produk'] = $row['kode_produk'];
			 $arr_baru['kode_ecomm'] = $row['kode_ecomm'];
			 $arr_baru['link_produk'] = $url_baru;
			 $arr_baru['nama_varian'] = $row['nama_varian'];
			 array_push($listt,$arr_baru);
			//$listt[] = $row;
	}	  
	
	
  }else{
	  
	  $cari2   = "select * from tb_multi_link where nama_alias = '".$_GET['alias']."' ";
	  $qcari    = mysql_query($cari2);
	  $jml_cari = mysql_num_rows($qcari);
	  
	  if( $jml_cari > 0 ){
		  
		$ftch = mysql_fetch_assoc($qcari);
		$id_p = $ftch['id_pricelist'];
		 
		$query2 = "SELECT tb_pricelist.kode_produk , tb_link.kode_ecomm, tb_link.link_produk, tb_link.nama_varian from tb_pricelist join tb_link on tb_pricelist.kode_produk = tb_link.kode_produk where tb_pricelist.id_pricelist = '".$id_p."' order by tb_link.nama_varian asc";
 
		$result2 = mysql_query($query2); 
		  
		while($row =mysql_fetch_assoc($result2))
		{
					$arr_baru = array();
					$parsed_url = parse_url($row['link_produk']);
					$link	= $row['link_produk'];
    		
    
            $arr22   =  preg_split($regex_toko, $link, -1, PREG_SPLIT_DELIM_CAPTURE);
            $toko  =  preg_match($regex_toko,$link,$match);
            $link_1  = $match[0];
            $link_2 = $arr22[1];


            // if (empty($parsed_url['scheme'])) {
            //   $urlStr = 'https://' . $row['link_produk'];
            // }else{
            //    $urlStr = $row['link_produk'];
            // }

            		$url_baru = 'http://'.$link_1.$link_2;
    
				  
					 $arr_baru['kode_produk'] = $row['kode_produk'];
					 $arr_baru['kode_ecomm'] = $row['kode_ecomm'];
					 $arr_baru['link_produk'] = $url_baru;
					 $arr_baru['nama_varian'] = $row['nama_varian'];
					 array_push($listt,$arr_baru);
					//$listt[] = $row;
		}	  
		  
	  }
  
  }
  
  
 
  echo json_encode($listt, JSON_PRETTY_PRINT);
  
}
