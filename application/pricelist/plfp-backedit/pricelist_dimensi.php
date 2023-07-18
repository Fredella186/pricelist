<?php
session_start();
include "connect.php";

buka_koneksi();
    $api_url = 'http://sys.fastprint.co.id/api_sheet/';
    // sheet id
    $api_url .= '?spreadsheet=19k2KHYoeugO6ZrE53oYNEwgFTdPrG9Hff4AqxyLsCfY';
    // sheet yang dipilih
    $api_url .= '&sheet=sby%20upload%20-%20feb';
    // range yang dipilih
    $api_url .= '&range=B:F';
    // get data
    $get_api  = file_get_contents($api_url);            
    // $get_api  = file_get_contents('https://sys.fastprint.co.id/api_sheet/?spreadsheet=19k2KHYoeugO6ZrE53oYNEwgFTdPrG9Hff4AqxyLsCfY&sheet=sby%20upload%20-%20feb&range=B2:F586');            
    $api = json_decode($get_api,1);
    
  
    foreach ($api['values'] as $b) {
        $qKat = mysql_query("SELECT * FROM tb_pricelist WHERE kode_produk like '".$b[1]."'") or die (mysql_error());
        while($dataKat = mysql_fetch_array($qKat)){
 
           if ($dataKat['kode_produk'] == $b[1]) {
                $q = mysql_query("UPDATE tb_pricelist SET dimensi_produk = '".$b[4]."' WHERE kode_produk like '".$dataKat['kode_produk']."'") or die (mysql_error());
           }
        }

    echo $b[1]."<br>";


    }

tutup_koneksi();