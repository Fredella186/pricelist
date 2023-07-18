<?php
session_start();
include "connect.php";
buka_koneksi();
$now = time();
if(isset($_SESSION["user"]) || !empty($_SESSION["user"]) ){

    $harga     = ($_POST['harga'] == '')?'':$_POST['harga'];
    $data_toko = $_POST['data_toko'];
    $id        = $_POST['id'];
    $toko      = "harga_".$data_toko;
    $set       = "update tb_pricelist  set ".$toko." = '{$harga}' where kode_produk = '{$id}'";
	$up        = mysql_query($set);

    
    $select    = "select harga,{$toko} from tb_pricelist where kode_produk = '{$id}'";
	$slc       = mysql_query($select);
    $hrg_baru  = mysql_fetch_assoc($slc);
    $terbaru   = (int)($hrg_baru[$toko] == '')?$hrg_baru['harga']:$hrg_baru[$toko];
    echo "Rp.".number_format($terbaru,0,',','.');

}