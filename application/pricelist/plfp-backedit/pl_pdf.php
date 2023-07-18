<?php
    include('connect.php');
    buka_koneksi();
	
	//$cat = $_GET['id'];
    $a = mysql_query("SELECT * FROM tb_kategori WHERE id_ktg = '".$cat."'");
    $ktg = mysql_fetch_array($a);
	$title = (!empty($cat) || $cat != "") ? "Price List ".$ktg['nama_ktg']." ".date('Y') : "Price List ".date('Y');
?>
<style>
    th{
        text-align: center;
        font-weight: bold;
        background-color: #ccc;
    }
    .center {
        height: 100px;
        line-height:100px;
    }
    .ass{
    	padding-left: 8px;
    	padding-right: 8px;
    }
    p {
        font-size: 14pt;
        font-weight: bold;
    }
</style>
<page style="font-size: 11px">
    <p align="center"><?php echo $title; ?></p>
    <br>
    <br>
    <table border="1" width="95%" align="center">
        <tr>
          <th rowspan="2" height="20" width="30">#</th>
          <th rowspan="2" height="20" width="100">Gambar</th>
          <th rowspan="2" height="20" width="100">Nama</th>
          <th rowspan="2" height="20" width="70">Berat</th>
          <th rowspan="2" height="20" width="150">Harga</th>
          <th colspan="2" height="20" width="170">Harga Tingkat</th>
        </tr>
      	<tr>
          <th>Quantity</th>
          <th>Harga</th>
      	</tr>
        <?php
            $qPL = (!empty($cat) || $cat != "") ? mysql_query("SELECT * FROM tb_pricelist WHERE ktg_produk = '".$cat."'") : mysql_query("SELECT * FROM tb_pricelist");
            $no = 1;
            while($data = mysql_fetch_array($qPL)){
        ?>
        <tr>
            <td align="center"><?php echo $no; ?></td>
            <td class="center" align="center"><img src="assets/images/<?php echo $data['gambar_produk']; ?>" width="70" height="70" /></td>
            <td class="ass"><?php echo rapiJudul($data['judul_produk']); ?><br> Kode : <?php echo $data['kode_produk']; ?></td>
            <td align="center"><?php echo berat($data['berat_produk']); ?></td>
            <td valign="middle" align="center"> <b><?php echo rupiah($data['harga']); ?></b><br></td>
          	<td colspan="2"><table border="0">
          	<?php
                $qGR = mysql_query("SELECT * FROM tb_wholesale WHERE id_produk = '".$data['kode_produk']."'");
                while($datas = mysql_fetch_array($qGR)){
            ?>          		
              <tr>
                <td align="left"> <?php echo $datas['rentang_qty']; ?> pcs</td>
                <td><?php echo rupiah($datas['harga_wholesale']); ?></td>
              </tr>
          		
            <?php } ?>
          	</table></td>
        </tr>
        <?php
        $no++;
        }
        tutup_koneksi();
        ?>
    </table>
</page>
