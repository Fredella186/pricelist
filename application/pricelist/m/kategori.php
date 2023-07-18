<?php

 include "../plfp-backedit/connect.php";
 
 $arr = array();
 buka_koneksi();
  if(isset($_GET['c'])){
    $cari = explode(',',$_GET['c']);
    $sql  = "SELECT * from `tb_kategori` ";
    $i    = 0; 
    foreach($cari as $c){
      
      if($i == 0){
      
        $sql .=' where ';
        $sql .= " nama_ktg = '".$c."'";
      
      }else{ 

        if($i == count($cari)){

          $sql .= " nama_ktg = '".$c."'";

        }else{


          $sql .= " or nama_ktg = '".$c."'";
        }


      }


      $i++;
    }
    $sql .= " group by nama_ktg";
    $jml   = mysql_query($sql);
    while($ttl   = mysql_fetch_assoc($jml)){
      array_push($arr,$ttl);
    }

  }else{
    $jml   = mysql_query("SELECT id_ktg,nama_ktg,gambar_produk FROM `tb_kategori` left join tb_pricelist on tb_kategori.id_ktg = tb_pricelist.ktg_produk group by nama_ktg order by nama_ktg asc  ");
    while($ttl   = mysql_fetch_assoc($jml)){
       $gbr_baru = str_replace('/',' ',$ttl['nama_ktg']);
    
	  if(file_exists("../kategori/".$gbr_baru.".jpg")){
    		$ttl['gambar_produk'] =  "../kategori/".$gbr_baru.".jpg";
     
	  }else{
      		$ttl['gambar_produk'] = "../plfp-backedit/assets/images/".$ttl['gambar_produk'];
      }
      array_push($arr,$ttl);

    }
  }
    echo json_encode($arr);
 ?>