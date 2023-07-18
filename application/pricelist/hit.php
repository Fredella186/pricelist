<?php
  include "plfp-backedit/connect.php";
 
  // buat koneksi ke database mysql
  buka_koneksi();
  
  if(isset($_GET['kode-bc'])){
    $id  = $_GET['kode-bc'];
    $cek_produk = "SELECT * FROM `tb_pricelist` where `kode_produk` = '{$id}'";
    
    $query_cek  = mysql_query($cek_produk);
    $cek        = mysql_fetch_assoc($query_cek); 
    //echo mysql_num_rows($query_cek);
    if(mysql_num_rows($query_cek) > 0){
        
        $sum = $cek['hit']+1;
        $query_up = "UPDATE `tb_pricelist` SET `hit` = '{$sum}' WHERE `kode_produk` = '{$id}'";
        
        $sql_up = mysql_query($query_up);

    }

    echo "Sukses ".$id;
  }



?>