<?php
session_start();
include "connect.php";
buka_koneksi();
 
if(empty($_SESSION['user'])){

   echo "userkosong"; 
   exit;
}


if(isset($_POST['id_pro']) && isset($_POST['ubah'])){
 
    $id   = $_POST['id_pro'];
    $ubh  = $_POST['ubah'];
    $sku  = $_POST['sku'];
    $toko = '';
    
    
    if($_POST['toko'] !== '' && $_POST['toko'] !== null && $_POST['toko']!=='Pusat'){
    
        $toko = '_'.$_POST['toko'];
    
    }

    $datenow = date("Y-m-d H:i:s");

    $insertLog = "Insert into tb_ready_toko values (null,'{$id}','{$_SESSION['kota']}','{$ubh}','{$datenow}','{$_SESSION['user']}')";
    mysql_query($insertLog);


    $qwry = "Update tb_pricelist set stok{$toko} ='{$ubh}' where kode_produk='{$id}'";
    mysql_query($qwry);
    $status = '<b style="color:blue">Ready</b>';
    if($ubh == 0){

        $status = '<b style="color:red">Kosong</b>';

    }

    $status2 = 'Ready';
    if($ubh == 0){

        $status2 = 'Kosong';

    }

    $tko = $_SESSION['kota'];
      if (isset($_GET['toko'])) {
         if ($_GET['toko'] == 'mks') {
             $tko = 'MAKASAR';
         }
         if ($_GET['toko'] == 'mdn') {
            $tko = 'MEDAN';
        }
        if ($_GET['toko'] == 'bks') {
            $tko = 'BEKASI';
        }
    }


 	$subj_mail  = "[".$_SESSION['user']."][UPDATE] status stok {$status2} {$_POST['toko']} {$_POST['nama']} di Price List";

    $pesan      = "<h4>".$_POST['nama']." stok sekarang <b>{$status}</b></h5><p>SKU : <b>{$sku}</b></p>";
    $pesan2     = $_POST['nama']." stok sekarang {$status} \n\n SKU :{$sku}";
    // if($_SESSION['user']!== 'test-it'){

        echo kirimEmail(strtoupper($subj_mail), $pesan);
        kirim_skype($subj_mail."\n\n\n".$insertLog);
    // } 
}

tutup_koneksi();