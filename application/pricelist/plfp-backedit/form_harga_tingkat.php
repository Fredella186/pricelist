<?php 
session_start();
if(!isset($_SESSION['hak_akses'])){
    echo '<script>location.href = "http://pcls.fastprint.co.id/plfp-backedit/login.php"</script>';
    exit;
}
// panggil berkas koneksi.php
require 'connect.php';
buka_koneksi();

$id = @$_GET['id'];
$harga_tingkat = mysql_query("SELECT * FROM tb_wholesale WHERE id_produk= '{$id}'  order by harga_wholesale_luar desc");
$harga         = mysql_query("SELECT * FROM tb_pricelist WHERE kode_produk= '{$id}'");
$h             = mysql_fetch_assoc($harga);
?>
<form action="simpan_harga_tingkat.php" method="post">
    <input type="hidden" class='form-control' name="id" value='<?=$id?>' id="">

    <table class='table-bordered table'>
        <tr>
            <th>FP JAWA</th>
            <th>MP OFFICIAL</th>
            <th>MP JAWA</th> 
            <th>FP LUAR JAWA</th>
            <th>MP LUAR JAWA</th>
        </tr>
        <tr>
            <td><input type="text" class='form-control' name="harga_offline" value='<?=$h['harga_offline']?>' id=""></td>
            <td><input type="text" class='form-control' name="harga_online_official" value='<?=$h['harga_online_official']?>' id=""></td>
            <td><input type="text" class='form-control' name="harga_jawa" value='<?=$h['harga']?>' id=""></td>
            <td><input type="text" class='form-control' name="harga_offline_luar" value='<?=$h['harga_offline_luar_jawa']?>' id=""></td>
            <td><input type="text" class='form-control' name="harga_luar" value='<?=$h['harga_luar_jawa']?>' id=""></td>
        </tr>

    </table>

 
    <table class='table table-bordered'>
        <tr class='bg-primary'>
            <th>Qty</th>
            <th>Harga FP JAWA</th>
            <th>Harga MP OFFICIAL</th>
            <th>Harga MP JAWA</th>
            <th>FP LUAR JAWA</th>
            <th>MP LUAR JAWA</th>
            <th>#</th>
        </tr>
        <tbody id='harga-kene'>

    <?php
        $i = 1;
        while ($d = mysql_fetch_assoc($harga_tingkat)) {
    ?>
        
            <input type="hidden" class='form-control' name="id_rentang[]" id="" value='<?=$d['id_wholesale']?>'>
            <input type="hidden" class='form-control' name="rentang_qty_lama[]" id="" value='<?=$d['rentang_qty']?>'>
            <input type="hidden" class='form-control' name="harga_tingkat_offline_lama[]" id=""   value='<?=$d['harga_wholesale_offline']?>'>
            <input type="hidden" class='form-control' name="harga_tingkat_online_official_lama[]" value='<?=$d['harga_wholesale_online_official']?>'>
            <input type="hidden" class='form-control' name="harga_tingkat_jawa_lama[]" id="" value='<?=$d['harga_wholesale']?>'>
            <input type="hidden" class='form-control' name="harga_tingkat_luar_lama[]" id="" value='<?=$d['harga_wholesale_luar']?>'>
            <input type="hidden" class='form-control' name="harga_tingkat_offline_luar_lama[]" id="" value='<?=$d['harga_wholesale_offline_luar']?>'>
            
            <tr id="div-<?=$i?>">
                <td>
                    <input type="text" class='form-control' name="rentang_qty[]" id="" value='<?=$d['rentang_qty']?>'>
                </td>
                <td>
                        <input type="text" class='form-control' name="harga_tingkat_offline[]" id="" value='<?=$d['harga_wholesale_offline']?>'>
                </td>
                <td>
                    <input type="text" class='form-control' name="harga_tingkat_online_official[]" id="" value='<?=$d['harga_wholesale_online_official']?>'>
                </td>
                <td>
                    <input type="text" class='form-control' name="harga_tingkat_jawa[]" id="" value='<?=$d['harga_wholesale']?>'>
                </td>
                <td>
                    <input type="text" class='form-control' name="harga_tingkat_offline_luar[]" id="" value='<?=$d['harga_wholesale_offline_luar']?>'>
                </td>
                <td>
                    <input type="text" class='form-control' name="harga_tingkat_luar[]" id="" value='<?=$d['harga_wholesale_luar']?>'>
                </td>
                <td><button type='button' class='btn btn-danger btn-sm' onclick="hapus(<?=$i?>)"><i class="glyphicon glyphicon-trash"></i></button></td>
            </tr>
            
    <?php    
        $i++;
    }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='6'><button type='button' class="btn btn-primary btn-sm" style='float:right' onclick='tambah_field()'><i class="glyphicon glyphicon-plus"></i></button>
        </tr>
    </tfoot>
</table>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" style='color:black' data-dismiss="modal">Batal</button>
    <input type="submit" value="simpan" class='btn btn-primary'>
</form>
</div>
<script>
var i = <?=$i?>;

function tambah_field(){
    var html = `  
                <tr id="div-${i}">
                    <td>
                        <input type="hidden" class='form-control' name="id_rentang[]" id="" value='-'>
                        <input type="hidden" class='form-control' name="rentang_qty_lama[]" id="" value='-'>
                        <input type="text" class='form-control' name="rentang_qty[]" id="" value=''>
                    </td>
                    <td>
                        <input type="hidden" class='form-control' name="harga_tingkat_offline_lama[]" id="" value='-'>   
                        <input type="text" class='form-control' name="harga_tingkat_offline[]" id="" value=''>
                    </td>
                    <td>
                        <input type="hidden" class='form-control' name="harga_tingkat_online_official_lama[]" id="" value='-'>   
                        <input type="text" class='form-control' name="harga_tingkat_online_official[]" id="" value=''>
                    </td>
                    <td>
                        <input type="hidden" class='form-control' name="harga_tingkat_jawa_lama[]" id="" value='-'>   
                        <input type="text" class='form-control' name="harga_tingkat_jawa[]" id="" value=''>
                    </td>
                    <td>
                        <input type="hidden" class='form-control' name="harga_tingkat_offline_luar_lama[]" id="" value='-'>   
                        <input type="text" class='form-control' name="harga_tingkat_offline_luar[]" id="" value=''>
                    </td>
                    <td>  
                        <input type="hidden" class='form-control' name="harga_tingkat_luar_lama[]" id="" value='-'>
                        <input type="text" class='form-control' name="harga_tingkat_luar[]" id="" value=''>
                    </td>
                    <td><button type='button' class='btn btn-danger btn-sm' onclick="hapus(${i})"><i class="glyphicon glyphicon-trash"></i></button></td>
                </tr>`;
    $("#harga-kene").append(html);
    
            i++;
}

function hapus(i){
    
    $("#div-"+i).remove();

}

</script>