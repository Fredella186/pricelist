<?php
session_start();
require "connect.php";
buka_koneksi();

$data = mysql_query("select * from tb_jasa order by id_jasa desc");
$arr = array();
while($f= mysql_fetch_assoc($data)){
    // echo "<pre>";
   $f['aksi'] = "<button class='btn btn-primary btn-sm' onclick='edit({$f['id_jasa']})' data-toggle='modal' data-target='#exampleModal'>Edit</button> <button class='btn btn-danger btn-sm' onclick='hapus({$f['id_jasa']})'>Hapus</button>";
   $f['harga'] = "Rp. " . number_format($f['harga'], 0, ".", ".");
   array_push($arr,$f);

}

echo json_encode(array("data"=>$arr));