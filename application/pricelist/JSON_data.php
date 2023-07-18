<?php
session_start();
require "plfp-backedit/connect.php";
buka_koneksi();
//print_r($_SESSION['id_kat']);
$cari = '';
$i    = 0;
foreach($_SESSION['id_kat'] as $k){
    
    if($i == 0){

        $cari .='where ';
        $cari .= " nama_ktg = '".$k."'";

    }else{
        
        $jml = count($_SESSION['id_kat']);

        if($i == $jml){

            $cari .= " nama_ktg = '".$k."'";

        }else{
            $cari .= " or nama_ktg = '".$k."'";
        }
        
    }

    $i++;
}

//echo "<pre>";
// echo "Select count(*) as ttl From tb_pricelist join tb_kategori ON (tb_kategori.id_ktg = tb_pricelist.ktg_produk) ".$cari;
$jml   = mysql_query("Select count(*) as ttl From tb_pricelist join tb_kategori ON (tb_kategori.id_ktg = tb_pricelist.ktg_produk) ".$cari);
$ttl   = mysql_fetch_assoc($jml);
// echo "SELECT * FROM tb_pricelist join tb_kategori ON (tb_kategori.id_ktg = tb_pricelist.ktg_produk) ".$cari." where status_view = 1 order by tb_pricelist.judul_produk asc";
$query = mysql_query("SELECT * FROM tb_pricelist join tb_kategori ON (tb_kategori.id_ktg = tb_pricelist.ktg_produk) ".$cari." and  status_view = 1 order by tb_pricelist.judul_produk asc");
$data_semua = array();
$no =1 ; 
while($data = mysql_fetch_assoc($query))
{
    $cek_hrg = mysql_query("SELECT * FROM tb_wholesale where id_produk = ".$data['kode_produk'] ." order by `harga_wholesale` DESC ");
    $jml_hrga = mysql_num_rows($cek_hrg);
	$link = $data['link_produk'];	
if (filter_var($link, FILTER_VALIDATE_URL)) {
$link = $data['link_produk'];
} else {
    $link = 'https://'.$data['link_produk'];
}

    $arr_data = array();
    $arr_data[] = $no++;
    $arr_data[] = $data['id_pricelist'];

    $arr_data[] = "<center><img onError=\"this.src='https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg'\" loading='lazy' src='plfp-backedit/assets/images/". $data['gambar_produk']."' style='width:70px; height:70px;' onclick='buka_gambar(this)' /></center>";
    //$arr_data[] = '<a class="image-popup-vertical-fit" href="plfp-backedit/assets/images/'.$data['gambar_produk'].'"><img src="plfp-backedit/assets/images/'.$data['gambar_produk'].'" style="width:70px; height:70px;" /></a>';
    $arr_data[] ='<a href="'.$link.'" target="_blank">'.$data['judul_produk'].'</a>' ;
    $arr_data[] = $data['nama_ktg'];   
   	if($jml_hrga > 0 ){
     $arr_data[] = '<a href="#'.$data['kode_produk'].'" data-toggle="collapse" class="btn btn-success btn-block" onClick="buka_harga('.$data['kode_produk'].')">'."Rp. " . number_format($data['harga'],0,'',',').' <i class="fas fa-chevron-circle-down icon-down"></i> </a> <div id="'.$data['kode_produk'].'"  class="collapse"></div>';
    
    }else{
     $arr_data[] = '<a href="#'.$data['kode_produk'].'" class="btn btn-success btn-block disabled" >'."Rp. " . number_format($data['harga'],0,'',',').'</a> <div id="'.$data['kode_produk'].'"  class="collapse"></div>';
    
    }
    $arr_data[] = $data['berat_produk']." Gr";
    $arr_data[] = '<center><a href="'.$link.'" target="_blank">Klik disini!</a></center>';
 	$arr_data[] = $data['kode_produk'];
    array_push($data_semua,$arr_data);
}

echo '{  
    "sEcho": 0,
    "iTotalRecords": '.$ttl['ttl'].',
    "iTotalDisplayRecords": '.$ttl['ttl'].', "data":'.json_encode($data_semua).' }';
?>