<?php

$id = $_GET['id'];

require "plfp-backedit/connect.php";
buka_koneksi();


if(isset($id)){

  $tabel ='';
  $tabel .="<table class='table table-hover table-bordered'>";
  $query = mysql_query("SELECT * FROM tb_wholesale where id_produk = ".$id." order by `harga_wholesale` DESC ");
  $warna = isset($_GET['luar'])?"style='background:#DC5F00;color:white;border:none'":"style='background:#18bc9c;color:white;border:none'";
  $tabel .="<tr $warna><th>Qty</th><th>Harga</th></tr>";
  while($dt = mysql_fetch_assoc($query)){
    if(isset($_GET['luar'])){
      $hargga = ($dt['harga_wholesale_luar'] !== null && $dt['harga_wholesale_luar'] !== "" ) ? $dt['harga_wholesale_luar'] : $dt['harga_wholesale'];
      $tabel .="<tr ><th>".$dt['rentang_qty']."</th><th> Rp. ". number_format($hargga,0,'',',')."</th></tr>";
    }else{
      $tabel .="<tr><th>".$dt['rentang_qty']."</th><th> Rp. ". number_format($dt['harga_wholesale'],0,'',',')."</th></tr>";
    }

  }

  $tabel .='</table>';
  echo $tabel;




}