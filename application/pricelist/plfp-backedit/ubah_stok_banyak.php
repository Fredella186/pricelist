<?php
session_start();
require "connect.php";
buka_koneksi();
if(empty($_SESSION["user"])){
    echo "userkosong"; 
    exit;
} 

if(isset($_GET['s'])){
	
    if(strtoupper($_SESSION['user']) == 'PURCHASEPST'){
        $toko     = ($_GET['toko'] !=='' && $_GET['toko'] !== null)?"stok_".$_GET['toko']:'stok';
        
    } else {
        $toko     = ($_SESSION['toko'] !=='' && $_SESSION['toko'] !== null)?"stok_".$_SESSION['toko']:'stok';
    }    
    $stokname = $toko; 
    $datenow  = date("Y-m-d H:i:s");
    $status   = $_GET['s'];
    $where    = "'".implode("','",$_SESSION['CHECKLIST'])."'";
    $id       = implode(",",$_SESSION['CHECKLIST']);
    $sqlUp    = "update tb_pricelist set $stokname = $status where kode_produk in ($where)";
    
    mysql_query($sqlUp);

    $insertLog = "Insert into tb_ready_toko values (null,'{$id}','{$_SESSION['kota']}','{$status}','{$datenow}','{$_SESSION['user']}')";
    mysql_query($insertLog);

	// header("location:".$_SERVER['HTTP_REFERER']);
	$sql   = mysql_query("select * from tb_pricelist where kode_produk in ($where)");
	$html  = '';
	$v1    = ($_GET['s'] == 1)?"<b style='color:blue'>READY</b>":"<b style='color:red'>KOSONG</b>";
	$v11   = ($_GET['s'] == 1)?"READY":"KOSONG";

	$html .="<style>
            table, td, th {
                border: 1px solid black;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }
        </style>

        <h4>Permintaan Produk status ";

	$html .= $v1;

	$html .= '</h4>
        <div class="table-responsive">
        <table style="border-collapse: collapse;">
            <thead>
                <tr style="background:green;color:white">
                    <th style="text-align:center; width:50px;">no</th>
                    <th style="text-align:center;">Nama </th>
                    <!--th style="text-align:center; width:150px;">Status Sekarang</th-->
                    <th style="text-align:center; width:100px;">Permintaan</th>
                </tr>

            </thead>';

            $no =1 ;
            while ($f = mysql_fetch_assoc($sql)) {

                $html .="<tr>
                            <td style='text-align:center;'>$no</td>
                            <td >{$f['judul_produk']} <br><b>SKU : {$f['kode_produk']}</b></td>
                            <!--td style='text-align:center;width:150px;'>";

                $v2 = ($f['stok_'.$_SESSION['toko']] == 1)?"<b style='color:blue'>READY</b>":"<b style='color:red'>KOSONG</b>";
                $html .= $v2;

                $html .= "</td-->
                            <td style='text-align:center;'>";
                $v3    = ($_GET['s'] == 1)?"<b style='color:blue'>READY</b>":"<b style='color:red'>KOSONG</b>";
                $html .= $v3;
                $html .= "</td>
                            </tr>";
                $no++;
            }
            $html .=" </table> ";


      //  echo $html;
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
      $subyek = "[{$_SESSION['user']}] Produk status $v11 {$tko} Tanggal - ".date("Y-m-d");
      kirimEmail(strtoupper($subyek), $html); // kesemua 
        // kirimEmailTes($subyek, $html); // ke email prog4
      $_SESSION['CHECKLIST'] = array();

      kirim_skype($subyek."\n\n\n".$insertLog);

	// } 

}

      
      header("location:".$_SERVER['HTTP_REFERER']);
     ?>
