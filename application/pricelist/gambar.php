
<script>
var gambar = [];
function err(e){
	gambar.push(e.dataset.nama);
	
}

function t(){
	console.log(gambar)
}
</script>
<button onclick='t()'>Y</button>
<?php
require "plfp-backedit/connect.php";
buka_koneksi();
$query = "SELECT * FROM `tb_pricelist`";
$data  = mysql_query($query);
//$d = mysql_fetch_array($data);
$no  = 1;
$brg = 1;

while($d = mysql_fetch_assoc($data)){

	echo $file = $d['gambar_produk'];
	echo "<p>";
	echo $nama = $d['judul_produk'];
	echo "<p>";
	echo "<img src='plfp-backedit/assets/images/".$file."' width='100px' data-nama='".$nama."' onerror='err(this);'>";
	echo "<p>";

}

?>
