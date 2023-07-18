<?php

session_start();
require 'connect.php';

// buat koneksi ke database mysql
buka_koneksi(); 

     if (isset($_POST['catatan_produk'])) {
      $arr = array(
        "id_pl" => $_POST['catatan'],
        "catatan_produk" => $_POST['catatan_produk']
      );

      
      $sql = "UPDATE `tb_pricelist` SET `catatan_produk` = '{$_POST['catatan_produk']}' WHERE `id_pricelist` = {$_POST['catatan']}";	
      if(mysql_query($sql))
      $response = "Simpan catatan";
       else
      $response = "failed";
      
     
    }
    header("location:index.php");
    tutup_koneksi();