<?php
 include "connect.php";
 buka_koneksi(); 
 $limit = 30;
 
 if(isset($_GET['activ'])){
     
    //print_r($_GET);
	if (isset($_GET['id_prod'])){

        $query = "UPDATE tb_pricelist SET status_view =1 WHERE id_pricelist = ".$_GET['id_prod'];
        mysql_query($query);
        
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
   

 }else{
	 $query 	 = "select * from tb_pricelist where status_view = 0 limit 0,".$limit;
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