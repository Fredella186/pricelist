<?php
    session_start();
    header('Content-Type: application/json');
    // panggil file koneksi.php
    require 'connect.php';

    // buat koneksi ke database mysql
    buka_koneksi();
//all cabang all mp
    if(isset($_GET['idx'])){
        //per cabang all mp
        if(!empty($_GET['percab'])){
            $arrLInk = array();
            // echo "<pre>";
            if($_GET['percab'] == 'SBY'){
                $queryweb = mysql_query("SELECT link_produk FROM `tb_pricelist` where kode_produk = '{$_GET['idx']}'");
                $fweb = mysql_fetch_assoc($queryweb);
                $link_web =  (stristr($fweb['link_produk'], "http://")|| stristr($f['link_produk'], "https://")) ?$fweb['link_produk'] : "http://".$fweb['link_produk'];
    
                array_push($arrLInk,$link_web);
            }

            $query = mysql_query("SELECT link_produk FROM `tb_link` JOIN tb_ecommerce ON tb_link.`kode_ecomm` = tb_ecommerce.id_ecomm where kode_produk = '{$_GET['idx']}' and tb_ecommerce.nama_ecomm like '%{$_GET['percab']}%'");
            while ($f = mysql_fetch_assoc($query)) {
                $link_web2 =  (stristr($f['link_produk'], "http://") || stristr($f['link_produk'], "https://")) ?$f['link_produk'] : "http://".$f['link_produk'];

                array_push($arrLInk,$link_web2);
            }

            echo json_encode($arrLInk) ;
        }else{

            $arrLInk = array();
            // echo "<pre>";
            $queryweb = mysql_query("SELECT link_produk FROM `tb_pricelist` where kode_produk = '{$_GET['idx']}'");
            $fweb = mysql_fetch_assoc($queryweb);
            $link_web =  (stristr($fweb['link_produk'], "http://")|| stristr($f['link_produk'], "https://")) ?$fweb['link_produk'] : "http://".$fweb['link_produk'];

            array_push($arrLInk,$link_web);

            $query = mysql_query("SELECT link_produk FROM `tb_link` JOIN tb_ecommerce ON tb_link.`kode_ecomm` = tb_ecommerce.id_ecomm where kode_produk = '{$_GET['idx']}'");
            while ($f = mysql_fetch_assoc($query)) {
                $link_web2 =  (stristr($f['link_produk'], "http://") || stristr($f['link_produk'], "https://")) ?$f['link_produk'] : "http://".$f['link_produk'];

                array_push($arrLInk,$link_web2);
            }

            echo json_encode($arrLInk) ;
        }

    }


    
