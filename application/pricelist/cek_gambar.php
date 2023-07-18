<?php
require "plfp-backedit/connect.php";
buka_koneksi();
echo "<pre>";
$query = "SELECT * FROM `tb_pricelist`";
$data  = mysql_query($query);
//$d = mysql_fetch_array($data);
$no  = 1;
$brg = 1;

while($d = mysql_fetch_assoc($data)){
	$brg++;
  	$file = $d['gambar_produk'];
	echo "<p>";
	
	// $exists = remoteFileExists('http://pcls.fastprint.co.id/plfp-backedit/assets/images/'.$file);
	// if ($exists) {
	// echo $d['judul_produk'];
	// echo "<p>";
	// 	echo 'ada';
	// } else {
	// echo $d['judul_produk'];
	// echo "<p>";
	// echo 'Kosong';   
	// }


	//echo file_exists("plfp-backedit/assets/images/".$file);
	// if($file =='' ){
	// echo $no++." ".$d['judul_produk'];
	// }
	//var_dump(file_exists("plfp-backedit/assets/images/".$file));
	//echo "<p>"; 
	if (file_exists("plfp-backedit/assets/images/".$file)) {
    	if($file =='' ){
        //echo "1<p>";
    	//echo "gambar kosong";
    	//echo "<p>";
    	echo $d['judul_produk'];
    	echo "<p>";
    	//echo "<img src='plfp-backedit/assets/images/".$file."' width='100px'>";
    	//echo "<hr>";
        
        }else{
        // echo "ada";
        // echo "<p>";
         // echo $d['judul_produk'];
         // echo "<p>";
        // echo "<img src='plfp-backedit/assets/images/".$file."' width='100px'>";
        // echo "<hr>";
        
	
        }
    }else{
    	// echo "2<p>";
    	// echo "gambar kosong";
    	// echo "<p>";
    	// echo $d['judul_produk'];
    	// echo "<p>";
    	// echo $file."<p>";
    	// echo "<img src='plfp-backedit/assets/images/".$file."' width='100px'>";
    	// echo "<hr>";
    
    }
	


}

