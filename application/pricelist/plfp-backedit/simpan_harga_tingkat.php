<?php
session_start();
if(!isset($_SESSION['hak_akses'])){
    echo '<script>location.href = "http://pcls.fastprint.co.id/plfp-backedit/login.php"</script>';
    exit;
}

// panggil berkas koneksi.php
require 'connect.php';
buka_koneksi();
$id_wholesale = array();

$id                  = $_POST['id'];
$select              = mysql_query("SELECT * FROM tb_pricelist WHERE kode_produk= '{$id}' ");
$produk              = mysql_fetch_assoc($select);

if(!empty($_POST['id_rentang'])){

    foreach($_POST['id_rentang'] as $i){ 
        if($i !== "-"){
            $id_wholesale[] = $i;
        }
    }
}   
    
$harga_offline_lama         = rupiah($produk['harga_offline']);
$harga_offline_baru         = rupiah($_POST['harga_offline']);

$harga_online_official_lama = rupiah($produk['harga_online_official']);
$harga_online_official_baru = rupiah($_POST['harga_online_official']);

$harga_jawa_lama            = rupiah($produk['harga']);
$harga_jawa_baru            = rupiah($_POST['harga_jawa']);
        
$harga_luar_lama            = rupiah($produk['harga_luar_jawa']);
$harga_luar_baru            = rupiah($_POST['harga_luar']);

$harga_offline_luar_lama    = rupiah($produk['harga_offline_luar_jawa']);
$harga_offline_luar_baru    = rupiah($_POST['harga_offline_luar']);

$keterangan_update                = "";
$harga_utama                      = 0;
$harga_utama_lama                 = "";
$harga_utama_luar_lama            = "";
$harga_utama_offline_lama         = "";
$harga_utama_offline_luar_lama    = "";
$harga_utama_online_official_lama = "";

if($harga_jawa_lama  !== $harga_jawa_baru){
        $keterangan_update  .= "Harga Utama";
        $harga_utama        = 1;
        $harga_utama_lama   = "<tr>
                                <td>Harga Utama MP JAWA (Lama)</td>
                                <td>:</td>
                                <td>{$harga_jawa_lama}</td>
                            </tr>
                            <tr>
                                <td>Harga Utama MP JAWA (Baru)</td>
                                <td>:</td>
                                <td style='background:red'>{$harga_jawa_baru}</td>
                            </tr> ";
}

if($harga_luar_lama !== $harga_luar_baru){
        if($harga_utama == 0){
            $keterangan_update  .= "Harga Utama";
            $harga_utama        = 1;
        }

        $harga_utama_luar_lama = "  <tr>
                                        <td>Harga Utama MP LUAR JAWA (Lama)</td>
                                        <td>:</td>
                                        <td>{$harga_luar_lama}</td>
                                    </tr>
                                    <tr >
                                        <td>Harga Utama MP LUAR JAWA (Baru)</td>
                                        <td>:</td>
                                        <td style='background:red'>{$harga_luar_baru}</td>
                                    </tr>";
}

if($harga_offline_lama !== $harga_offline_baru){
        if($harga_utama == 0){
            $keterangan_update   .= "Harga Utama";
            $harga_utama  = 1;
        }

        $harga_utama_offline_lama = "  <tr>
                                        <td>Harga Utama FP JAWA (Lama)</td>
                                        <td>:</td>
                                        <td>{$harga_offline_lama}</td>
                                    </tr>
                                    <tr >
                                        <td>Harga Utama FP JAWA (Baru)</td>
                                        <td>:</td>
                                        <td style='background:red'>{$harga_offline_baru}</td>
                                    </tr>";
}

if($harga_online_official_lama !== $harga_online_official_baru){
        if($harga_utama == 0){
            $keterangan_update   .= "Harga Utama";
            $harga_utama  = 1;
        }

        $harga_utama_online_official_lama = " 
                                    <tr>
                                        <td>Harga Utama MP OFFICIAL (Lama)</td>
                                        <td>:</td>
                                        <td>{$harga_online_official_lama}</td>
                                    </tr>
                                    <tr >
                                        <td>Harga Utama MP OFFICIAL (Baru)</td>
                                        <td>:</td>
                                        <td style='background:red'>{$harga_online_official_baru}</td>
                                    </tr>";
}

if($harga_offline_luar_lama !== $harga_offline_luar_baru){
        if($harga_utama == 0){
            $keterangan_update   .= "Harga Utama";
            $harga_utama  = 1;
        }

        $harga_utama_offline_luar_lama = " 
                                    <tr>
                                        <td>Harga Utama FP LUAR JAWA (Lama)</td>
                                        <td>:</td>
                                        <td>{$harga_offline_luar_lama}</td>
                                    </tr>
                                    <tr >
                                        <td>Harga Utama FP LUAR (Baru)</td>
                                        <td>:</td>
                                        <td style='background:red'>{$harga_offline_luar_baru}</td>
                                    </tr>";
}

$edit = 0;
$isi_diedit_tingkat_jawa_lama      = "<td>Harga Online MP JAWA (Lama)</td><td>:</td> ";
$isi_diedit_tingkat_jawa_baru      = "<td>Harga Online MP JAWA (Baru)</td><td>:</td>";

$isi_diedit_tingkat_luar_jawa_lama = "<td>Harga Online MP Luar Jawa (Lama)</td><td>:</td> ";
$isi_diedit_tingkat_luar_jawa_baru = "<td>Harga Online MP Luar Jawa (Baru)</td><td>:</td>";

$isi_diedit_tingkat_offline_lama   = "<td>Harga FP JAWA (Lama)</td><td>:</td> ";
$isi_diedit_tingkat_offline_baru   = "<td>Harga FP JAWA (Baru)</td><td>:</td>";

$isi_diedit_tingkat_online_official_lama = "<td>Harga MP Official (Lama)</td><td>:</td> ";
$isi_diedit_tingkat_online_official_baru = "<td>Harga MP Official (Baru)</td><td>:</td>";


$isi_diedit_tingkat_offline_luar_lama = "<td>Harga FP LUAR (Lama)</td><td>:</td> ";
$isi_diedit_tingkat_offline_luar_baru = "<td>Harga FP LUAR (Baru)</td><td>:</td>";

if(!empty($_POST['id_rentang'])){

    foreach($_POST['id_rentang'] as $key=>$p ){

            if($_POST['rentang_qty_lama'][$key].$_POST['harga_tingkat_jawa_lama'][$key] !== $_POST['rentang_qty'][$key].$_POST['harga_tingkat_jawa'][$key]){
                $edit = 1;
            }
            
            $harga_lama_tingkat_1 = @rupiah(($_POST['harga_tingkat_jawa_lama'][$key] !== '-')?$_POST['harga_tingkat_jawa_lama'][$key]:0);
            $harga_baru_tingkat_1 = @rupiah($_POST['harga_tingkat_jawa'][$key]);
            $isi_diedit_tingkat_jawa_lama .="<td><strong>QTY : {$_POST['rentang_qty_lama'][$key]}<br>{$harga_lama_tingkat_1}</strong></td>";
           
            if(!empty($_POST['harga_tingkat_jawa'][$key])){
                $isi_diedit_tingkat_jawa_baru .="<td><strong>QTY : {$_POST['rentang_qty'][$key]}<br>{$harga_baru_tingkat_1}</strong></td>";
            }else{
                $isi_diedit_tingkat_jawa_baru .="<td></td>";
            }

            // ---------------------------------------------------------------------------------------------------------------------------------------------

            if($_POST['rentang_qty_lama'][$key].$_POST['harga_tingkat_luar_lama'][$key] !== $_POST['rentang_qty'][$key].$_POST['harga_tingkat_luar'][$key]){
                $edit = 1;                
            }

            $harga_lama_tingkat_1 = @rupiah(($_POST['harga_tingkat_luar_lama'][$key] !== '-')?$_POST['harga_tingkat_luar_lama'][$key]:0);
            $harga_baru_tingkat_1 = @rupiah($_POST['harga_tingkat_luar'][$key]);
            $isi_diedit_tingkat_luar_jawa_lama .="<td><strong>QTY : {$_POST['rentang_qty_lama'][$key]}<br>{$harga_lama_tingkat_1}</strong></td>";
            
            if(!empty($_POST['harga_tingkat_luar'][$key])){
                $isi_diedit_tingkat_luar_jawa_baru .="<td><strong>QTY : {$_POST['rentang_qty'][$key]}<br>{$harga_baru_tingkat_1}</strong></td>";
            }else{
                $isi_diedit_tingkat_luar_jawa_baru .="<td></td>";

            }
            
            // ---------------------------------------------------------------------------------------------------------------------------------------------

            if($_POST['rentang_qty_lama'][$key].$_POST['harga_tingkat_offline_lama'][$key] !== $_POST['rentang_qty'][$key].$_POST['harga_tingkat_offline'][$key]){
                $edit = 1;                
            }

            $harga_lama_tingkat_1 = @rupiah(($_POST['harga_tingkat_offline_lama'][$key] !== '-')?$_POST['harga_tingkat_offline_lama'][$key]:0);
            $harga_baru_tingkat_1 = @rupiah($_POST['harga_tingkat_offline'][$key]);
            $isi_diedit_tingkat_offline_lama .="<td><strong>QTY : {$_POST['rentang_qty_lama'][$key]}<br>{$harga_lama_tingkat_1}</strong></td>";
            
            if(!empty($_POST['harga_tingkat_offline'][$key])){
                $isi_diedit_tingkat_offline_baru .="<td><strong>QTY : {$_POST['rentang_qty'][$key]}<br>{$harga_baru_tingkat_1}</strong></td>";
            }else{
                $isi_diedit_tingkat_offline_baru .="<td></td>";

            }
            
            // ---------------------------------------------------------------------------------------------------------------------------------------------

            if($_POST['rentang_qty_lama'][$key].$_POST['harga_tingkat_online_official_lama'][$key] !== $_POST['rentang_qty'][$key].$_POST['harga_tingkat_online_official'][$key]){
                $edit = 1;                
            }

            $harga_lama_tingkat_1 = @rupiah(($_POST['harga_tingkat_online_official_lama'][$key] !== '-')?$_POST['harga_tingkat_online_official_lama'][$key]:0);
            $harga_baru_tingkat_1 = @rupiah($_POST['harga_tingkat_online_official'][$key]);
            $isi_diedit_tingkat_online_official_lama .="<td><strong>QTY : {$_POST['rentang_qty_lama'][$key]}<br>{$harga_lama_tingkat_1}</strong></td>";
            
            if(!empty($_POST['harga_tingkat_online_official'][$key])){
                $isi_diedit_tingkat_online_official_baru .="<td><strong>QTY : {$_POST['rentang_qty'][$key]}<br>{$harga_baru_tingkat_1}</strong></td>";
            }else{
                $isi_diedit_tingkat_online_official_baru .="<td></td>";

            }
            
            //---------------------------------------------------------------------------------------------------------------------------------------------
            
            if($_POST['rentang_qty_lama'][$key].$_POST['harga_tingkat_offline_luar_lama'][$key] !== $_POST['rentang_qty'][$key].$_POST['harga_tingkat_offline_luar'][$key]){
                $edit = 1;                
            }

            $harga_lama_tingkat_1 = @rupiah(($_POST['harga_tingkat_offline_luar_lama'][$key] !== '-')?$_POST['harga_tingkat_offline_luar_lama'][$key]:0);
            $harga_baru_tingkat_1 = @rupiah($_POST['harga_tingkat_offline_luar'][$key]);
            $isi_diedit_tingkat_online_official_lama .="<td><strong>QTY : {$_POST['rentang_qty_lama'][$key]}<br>{$harga_lama_tingkat_1}</strong></td>";
            
            if(!empty($_POST['harga_tingkat_offline_luar'][$key])){
                $isi_diedit_tingkat_online_official_baru .="<td><strong>QTY : {$_POST['rentang_qty'][$key]}<br>{$harga_baru_tingkat_1}</strong></td>";
            }else{
                $isi_diedit_tingkat_online_official_baru .="<td></td>";

            }
            
            

    }
}


if($edit){
    if($keterangan_update !== ''){
        $keterangan_update   .= " dan  ";
    }
    $keterangan_update   .= "Harga Tingkat";
}

$judul = "[{$_SESSION['user']}][UPDATE] {$keterangan_update} Produk {$produk['judul_produk']} di Price List";


$isihtml = "
            Ada perubahan harga Fast Print dengan keterangan sebagai berikut : 
            <p>
            <table>
            <tr>
                <td>SKU</td>
                <td>:</td>
                <td>{$id}</td>
            </tr> 
            <tr>
                <td>Produk</td>
                <td>:</td>
                <td>{$produk['judul_produk']}</td>
            </tr> ";

if($harga_utama == 1){
    $isihtml .= $harga_utama_offline_lama."".$harga_utama_online_official_lama."".$harga_utama_lama."".$harga_utama_luar_lama."".$harga_utama_offline_luar_lama;

}else{

    $isihtml .="
                <tr>
                    <td>Harga Utama FP JAWA</td>
                    <td>:</td>
                    <td>{$harga_offline_baru}</td>
                </tr> 
                <tr >
                    <td>Harga Utama MP OFFICIAL</td>
                    <td>:</td>
                    <td>{$harga_online_official_baru}</td>
                </tr>
                <tr>
                    <td>Harga Utama MP JAWA</td>
                    <td>:</td>
                    <td>{$harga_luar_baru}</td>
                </tr>
                <tr>
                    <td>Harga Utama FP LUAR JAWA</td>
                    <td>:</td>
                    <td>{$harga_offline_baru}</td>
                </tr>
                <tr>
                    <td>Harga Utama MP LUAR JAWA</td>
                    <td>:</td>
                    <td>{$harga_luar_baru}</td>
                </tr>";
}




$isihtml .= "<h5>Harga Tingkat FP JAWA</h5>";
$isihtml .= "<table border='1'>";
$isihtml .= "<tr>".$isi_diedit_tingkat_offline_lama."</tr>"; 
$isihtml .= "<tr style='background:red'>".$isi_diedit_tingkat_offline_baru."</tr>";
$isihtml .= "</table><p><p>";


$isihtml .= "<h5>Harga Tingkat MP OFFICIAL</h5>";
$isihtml .= "<table border='1'>";
$isihtml .= "<tr>".$isi_diedit_tingkat_online_official_lama."</tr>"; 
$isihtml .= "<tr style='background:red'>".$isi_diedit_tingkat_online_official_baru."</tr>";
$isihtml .= "</table><p><p>";

$isihtml .="</table>";
$isihtml .= "<hr>";
$isihtml .= "<h5>Harga Tingkat MP Jawa</h5>";
$isihtml .= "<table border='1'>";
$isihtml .= "<tr>".$isi_diedit_tingkat_jawa_lama."</tr>";
$isihtml .= "<tr style='background:red'>".$isi_diedit_tingkat_jawa_baru."</tr>";
$isihtml .= "</table>";

$isihtml .="</table>";
$isihtml .= "<hr>";
$isihtml .= "<h5>Harga Tingkat FP LUAR Jawa</h5>";
$isihtml .= "<table border='1'>";
$isihtml .= "<tr>".$isi_diedit_tingkat_offline_luar_lama."</tr>";
$isihtml .= "<tr style='background:red'>".$isi_diedit_tingkat_offline_luar_baru."</tr>";
$isihtml .= "</table>";

$isihtml .= "<h5>Harga Tingkat Online MP Luar Jawa</h5>";
$isihtml .= "<table border='1'>";
$isihtml .= "<tr>".$isi_diedit_tingkat_luar_jawa_lama."</tr>"; 
$isihtml .= "<tr style='background:red'>".$isi_diedit_tingkat_luar_jawa_baru."</tr>";
$isihtml .= "</table><p><p>";



$isihtml .= "Khusus untuk Team Editor, mohon untuk mengubah data harga produk tersebut sesuai dengan harga baru yang di berikan di atas pada masing - masing aplikasi E-Commerce Fast Print lewat aplikasi Link Manager yang bisa di akses di sini

Terima kasih,
<p>
<strong style='background:red'>By: {$_SESSION['user']}</strong>";

kirimEmail($judul,$isihtml);
$harga_tingkat       = mysql_query("SELECT * FROM tb_wholesale WHERE id_produk= '{$id}' ");
// nanti hidupin lagi 
// $harga_tingkat_hapus = mysql_query("DELETE FROM tb_wholesale WHERE id_produk= '{$id}' and id_wholesale not in (".implode(",",$id_wholesale).")");

// update
$up = date("Y-m-d H:i:s");

$update_harga = "UPDATE `tb_pricelist` SET 
                    `harga` = '{$_POST['harga_jawa']}', 
                    `harga_luar_jawa`  = '{$_POST['harga_luar']}', 
                    `harga_online_official`  = '{$_POST['harga_online_official']}', 
                    `harga_offline`  = '{$_POST['harga_offline']}', 
                    `harga_offline_luar_jawa`  = '{$_POST['harga_offline_luar']}', 
                    update_time = '{$up}' where kode_produk = '{$id}'";
mysql_query($update_harga);


if(!empty($_POST['id_rentang'])){
    foreach($_POST['id_rentang'] as $ky => $idR){
        echo "<p>";
        print_r($idR);
        
        if(!empty($_POST['harga_tingkat_jawa'][$ky])){
            
            $rentangQty         = $_POST['rentang_qty'][$ky];
            $harga_tingkat_jawa = $_POST['harga_tingkat_jawa'][$ky];
            $harga_tingkat_luar = $_POST['harga_tingkat_luar'][$ky];
            $harga_tingkat_offline = $_POST['harga_tingkat_offline'][$ky];
            $harga_tingkat_online_official = $_POST['harga_tingkat_online_official'][$ky];
            $harga_tingkat_offline_luar = $_POST['harga_tingkat_offline_luar'][$ky];
        
            if($idR !== "-"){
                
                // update
                $update = "UPDATE `tb_wholesale` SET 
                                `rentang_qty`= '{$rentangQty}',
                                `updated_at`= '{$up}',
                                harga_wholesale = '{$harga_tingkat_jawa}',
                                harga_wholesale_luar='{$harga_tingkat_luar}',
                                harga_wholesale_offline = '{$harga_tingkat_offline}',
                                harga_wholesale_online_official='{$harga_tingkat_online_official}',
                                harga_wholesale_offline_luar = '{$harga_tingkat_offline_luar}'
                                where id_wholesale = '{$idR}'";
                mysql_query($update);
        
        
            }else{
        
                // insert
                $insert = "INSERT INTO `tb_wholesale`(`id_wholesale`, `id_produk`, `rentang_qty`, `harga_wholesale`, `harga_wholesale_luar`,`harga_wholesale_offline`,`harga_wholesale_online_official`,`harga_wholesale_offline_luar`, `updated_at`, `status_email`) 
                VALUES (Null,'{$id}','{$rentangQty}','{$harga_tingkat_jawa}','{$harga_tingkat_luar}','{$harga_tingkat_offline}','{$harga_tingkat_online_official}','{$harga_tingkat_offline_luar}','{$up}',0)";
        
                mysql_query($insert);
            }
            
        }else{

            mysql_query("DELETE FROM tb_wholesale WHERE id_wholesale = '{$idR}'");
        
        }


    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
 