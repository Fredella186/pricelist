<?php
session_start();
require "connect.php";
buka_koneksi();

$jasa  = $_POST['jasa'];
$sulit = $_POST['sulit'];
$harga = $_POST['harga'];
$ket   = $_POST['keterangan'];

if(empty($_GET['id']) && $_GET['id']==''){

        $sql = "INSERT INTO `pricelist`.`tb_jasa` (`id_jasa`, `nama_kerusakan`, `tingkat_kesusahan`, `harga`, `keterangan`) VALUES (Null, '{$jasa}', '{$sulit}', '{$harga}', '{$ket}');";
        mysql_query($sql);
    
}else{

    $sql = "UPDATE `tb_jasa` SET `nama_kerusakan` = '{$jasa}',
                `tingkat_kesusahan` = '{$sulit}',
                `harga` = '{$harga}',
                `keterangan` = '{$ket}' WHERE `id_jasa` ={$_GET['id']};";
    mysql_query($sql);

}

header("location:jasa.php");