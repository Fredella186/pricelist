<?php
include("plfp-backedit/connect.php");
buka_koneksi();
echo "<pre>";
$toko = '';
$sql_ket  = "SELECT * FROM  `tb_ecommerce` GROUP BY nama_toko";
$qket     = mysql_query($sql_ket);
$jml_k    = mysql_num_rows($qket);
$i  = 0;
while($fk = mysql_fetch_assoc($qket)){
	if($i !== 0 && $i < $jml_k){
    	$toko .='|';
    }
	$toko .= $fk['nama_toko'];
	
	$i++;

}

$regex_toko = '/'.$toko.'/';

$sql ="SELECT tb_pricelist.judul_produk, tb_link.link_produk, tb_pricelist.nama_alias
FROM tb_pricelist
JOIN tb_link ON tb_pricelist.kode_produk = tb_link.kode_produk";
$data = mysql_query($sql);
while($f = mysql_fetch_assoc($data)){
	$arr				= array();
    $arr['nama_pro'] 	= $f['nama_alias'];;
	$link	= $f['link_produk'];
	$arr   =  preg_split($regex_toko, $link, -1, PREG_SPLIT_DELIM_CAPTURE);
    $toko  =  preg_match($regex_toko,$link,$match);
	$link_1  = $match[0];
	$link_2 = $arr[1];
	echo "<a href='http://".$link_1.$link_2."'>".$f['judul_produk']."</a>";
	echo "<p>";
	echo "Nama PL ".$f['judul_produk'];
	echo "<p>";
	echo "Nama Web ".$f['nama_alias'];
	echo "<p>";
	echo $link;
echo '<p>';
	
}


