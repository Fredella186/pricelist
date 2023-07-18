<?php
    session_start();
    require 'connect.php';

    // buat koneksi ke database mysql
    buka_koneksi(); 

if (isset($_POST['kd_prod'])){

    $kd = $_POST['kd_prod']; 

    mysql_query("UPDATE tb_pricelist SET status_view =0 WHERE kode_produk = '".$kd."'") or die (mysql_error());
}