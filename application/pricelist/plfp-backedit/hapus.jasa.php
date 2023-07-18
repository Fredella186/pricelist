<?php
 include "connect.php";
 buka_koneksi(); 

 $id = @$_GET['id'];
 $query 	 = "DELETE FROM `pricelist`.`tb_jasa` WHERE `tb_jasa`.`id_jasa` = '{$id}'";
 $data_cari  = mysql_query($query);
 
 header("location:jasa.php");