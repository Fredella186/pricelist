<?php
 include "connect.php";
 buka_koneksi(); 
 $limit = 30;
 

 if(isset($_GET['cari_nama'])){
	  
	$cari = $_GET['cari_nama'];
	$cari_arr = explode(' ',$cari);
		 
	
	 
 }else if(isset($_GET['id'])){
	 
	 $id = $_GET['id'];
	 $query 	 = "select*from tb_multi_link where id_pricelist = {$id}";
	 $data_cari  = mysql_query($query);
	 $array_data = array();
	 while($fetch= mysql_fetch_array($data_cari)){
		$arr = array();
		$arr['id'] = $fetch['id_pricelist'];
		$arr['alias'] = $fetch['nama_alias'];
		$arr['pl'] = $fetch['nama_pl'];
		$arr['id_link'] = $fetch['id'];	
		array_push($array_data,$arr);		 
		 
	 }
	 
	 echo json_encode($array_data);
	 
	 
	 
 }else if(isset($_POST['nama_alias'])){
	 
	 $query = "INSERT INTO `tb_multi_link` (`id`, `id_pricelist`, `nama_alias`, `nama_pl`) VALUES (NULL, '{$_POST['id_pl']}', '{$_POST['nama_alias']}', '{$_POST['nama_pl']}');";
	 
	 mysql_query($query);
	 
 }else if(isset($_GET['hapus'])){
	 echo "as";
	 if(isset($_GET['id_hapus'])){
		 
		 $query = "DELETE FROM `tb_multi_link` WHERE `id` = ".$_GET['id_hapus'];
		 mysql_query($query);
		 
	 }
	
	header("Location: " . $_SERVER['HTTP_REFERER']);

 }else if(isset($_GET['cari'])){
	 
	 $cari = $_POST['cari'];
	 $pencarian = explode(' ',$cari);
	 $cari2 = '';
	 $txt_dicari ='';
	 $no_cari =0;
	 foreach($pencarian as $c){
		 
		if($no_cari == 0){
					
			$txt_dicari .= "judul_produk like '%${c}%'";
			
		}else{
					
			$txt_dicari .= " and judul_produk like '%${c}%'";
		}
				
		$no_cari++;
	 }
		
	 $cari2 = $txt_dicari;
	 $query 	 = "select*from tb_pricelist where ".$cari2.' limit 0,'.$limit;
	 $data_cari  = mysql_query($query);
	 $array_data = array();
	 
	 while($fetch= mysql_fetch_array($data_cari)){
		$arr = array();
		$arr['id'] = $fetch['id_pricelist'];
		$arr['judul_produk'] = $fetch['judul_produk'];
		$arr['gambar'] = $fetch['gambar_produk'];
		array_push($array_data,$arr);		 
		 
	 }
	 
	 echo json_encode($array_data);
	 
 }else{
	 $query 	 = "select * from tb_pricelist limit 0,".$limit;
	 $data_cari  = mysql_query($query);
	 $array_data = array();
	 while($fetch= mysql_fetch_array($data_cari)){
		$arr = array();
		$arr['id'] = $fetch['id_pricelist'];
		$arr['judul_produk'] = $fetch['judul_produk'];
		$arr['gambar'] = $fetch['gambar_produk'];
			
		array_push($array_data,$arr);		 
		 
	 }
	 
	 echo json_encode($array_data);
	 
 }
 
?>