<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Origin: *");
require "plfp-backedit/connect.php";
buka_koneksi();
if(!empty($_GET['key'])){ 
    $barcode = @$_GET['key'];   


    $data = array();
    $qProd = mysql_query("SELECT  kode_produk,judul_produk,link_produk,harga,stok,stok_jkt,stok_bdg FROM tb_pricelist WHERE kode_produk = '".$barcode."' ");
    $data['produk'] = mysql_fetch_assoc($qProd);
    $jumlah = mysql_num_rows($qProd);
    if($jumlah == 0 ){


        $txt_cari   = explode(' ',$barcode);
        $no_cari = 0;
        foreach($txt_cari as $c){
            if($no_cari == 0){
                
                $txt_dicari .= "judul_produk like '%${c}%'";
                
            }else{
                
                $txt_dicari .= " and judul_produk like '%${c}%'";
            }
            
            $no_cari++;
        }
        $cari = $txt_dicari;


        $qProd = mysql_query("SELECT kode_produk,judul_produk,link_produk,harga,stok,stok_jkt,stok_bdg FROM tb_pricelist WHERE {$cari} limit 10");
        while($f = mysql_fetch_assoc($qProd)){
            $harga_tingkat = mysql_query("SELECT * FROM `tb_wholesale` where id_produk = '{$f['kode_produk']}' order by harga_wholesale desc");
            $harga = array();
            while($h = mysql_fetch_assoc($harga_tingkat)){
                
                $harga[] = $h;

            }
            $f['harga tingkat'] = $harga;
            $data['produk'][] = $f;
            
        }

        $jumlah = mysql_num_rows($qProd);

    }else{

            $harga_tingkat = mysql_query("SELECT * FROM `tb_wholesale` where id_produk = '{$data['produk']['kode_produk']}' order by harga_wholesale desc");
            $harga = array();
            while($h = mysql_fetch_assoc($harga_tingkat)){
                
                $harga[] = $h;

            }
            $data['produk']['harga tingkat'] = $harga;

    }


    $data['jumlah'] = $jumlah;
    
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: GET, OPTIONS");
    header("Access-Control-Allow-Origin: *");
    
    echo json_encode($data);
    
}else{
    echo 'Barang tidak ditemukan';
}
?>