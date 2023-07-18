<?php
session_start();
require 'connect.php';

buka_koneksi();
$where = "'".implode("','",$_SESSION['CHECKLIST'])."'";
$sql   = mysql_query("select * from tb_pricelist where kode_produk in ($where)");

// echo "<pre>";
// print_r ($_SESSION);
// echo "</pre>";

?>
<!-- kondisi klik untuk menu purchase -->
<?php
if(strtoupper($_SESSION['user']) == 'PURCHASEPST' && $_SESSION['menu_toko'] = 1 ){
  ?>
  <button class="btn btn-primary" data-toko="" data-status="1" onclick="return pilihpurchase(this)">READY PUSAT</button>
  <button class="btn btn-danger"  data-toko="" data-status="0" onclick="return pilihpurchase(this)">KOSONG PUSAT</button>
  <button class="btn btn-primary" data-toko="mks" data-status="1" onclick="return pilihpurchase(this)">READY MAKASAR</button>
  <button class="btn btn-danger" data-toko="mks" data-status="0" onclick="return pilihpurchase(this)">KOSONG MAKASAR</button>
  <button class="btn btn-primary" data-toko="mdn" data-status="1" onclick="return pilihpurchase(this)">READY MEDAN</button>
  <button class="btn btn-danger" data-toko="mdn" data-status="0" onclick="return pilihpurchase(this)">KOSONG MEDAN</button>
  <button class="btn btn-primary" data-toko="bks" data-status="1" onclick="return pilihpurchase(this)">READY BEKASI</button>
  <button class="btn btn-danger" data-toko="bks" data-status="0" onclick="return pilihpurchase(this)">KOSONG BEKASI</button>
  <?php
}else{
  ?>
  <button class="btn btn-primary" onclick="return pilih(1)">READY</button>
  <button class="btn btn-danger"  onclick="return pilih(0)">KOSONG</button>
  <?php
}
?>
<div class="table-responsive">
  <table class="table table-striped table-hover table-bordered" cellpadding="0" cellspacing="0">
      <thead>
        <tr class="success">
            <th style="text-align:center; width:50px;" rowspan="2">no</th>
            <th style="text-align:center;" rowspan="2">Nama </th>
            <th style="text-align:center;" rowspan="2">SKU </th>
            <!-- <th style="text-align:center; width:150px;" colspan="2:1">Status Sekarang</th> -->
            <?php       
            if(strtoupper($_SESSION['user']) == 'PURCHASEPST' && $_SESSION['menu_toko'] = 1 ){
                ?>
                  <th style="text-align:center; width:150px;" colspan="4:1">Status Sekarang</th>
            <?php
              }else{
                  ?>
                  <th style="text-align:center; width:150px;">Status Sekarang</th>
              <?php
              }
            ?>

            <th style="text-align:center; width:50px;"rowspan="2">Aksi</th>
        </tr>
        <tr>
          <!-- kondisi pusat, makasar dan medan khusus purchase -->
          <?php
          if(strtoupper($_SESSION['user']) == 'PURCHASEPST' && $_SESSION['menu_toko'] = 1 ){
            ?>
            <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8; color:white;"> <?=($_SESSION['menu_toko'] == 1)?"Pusat":$_SESSION['toko']?></th>
            <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8; color:white;"> <?=($_SESSION['menu_toko'] == 1)?"MKS":$_SESSION['MKS']?></th>
            <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8; color:white;"> <?=($_SESSION['menu_toko'] == 1)?"MDN":$_SESSION['MDN']?></th>
            <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8; color:white;"> <?=($_SESSION['menu_toko'] == 1)?"BKS":$_SESSION['BKS']?></th>
            <?php
          }else{
            ?>
              <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8; color:white;"><?=($_SESSION['kota'])?></th>
            <?php
          }
          ?>
            


        </tr>

      </thead>
      <?php
        $no =1 ;
        while ($f = mysql_fetch_assoc($sql)) {
          
      ?>
         <tr>
            <td style="text-align:center;"><?=$no++?></td>
            <td ><?=$f['judul_produk']?> </td>
            <td ><?=$f['kode_produk']?> </td>
            <?php
              if(strtoupper($_SESSION['user']) == 'PURCHASEPST' && $_SESSION['menu_toko'] = 1 ){
                
                // echo "<pre>";
                // print_r ($_SESSION);
                // echo "</pre>";
                
            ?>
            <td style="text-align:center;width:150px;"><?=($f['stok'.$_SESSION['toko']] == 1)?"<b style='color:blue'>READY</b>":"<b style='color:red'>KOSONG</b>"?></td>
            <td style="text-align:center;width:150px;"><?=($f['stok_mks'.$_SESSION['toko']] == 1)?"<b style='color:blue'>READY</b>":"<b style='color:red'>KOSONG</b>"?></td>
            <td style="text-align:center;width:150px;"><?=($f['stok_mdn'.$_SESSION['toko']] == 1)?"<b style='color:blue'>READY</b>":"<b style='color:red'>KOSONG</b>"?></td>
            <td style="text-align:center;width:150px;"><?=($f['stok_bks'.$_SESSION['toko']] == 1)?"<b style='color:blue'>READY</b>":"<b style='color:red'>KOSONG</b>"?></td>
            <?php
          }else{
            ?>
            <td style="text-align:center;width:150px;"><?=($f['stok_'.$_SESSION['toko']] == 1)?"<b style='color:blue'>READY</b>":"<b style='color:red'>KOSONG</b>"?></td>
            <?php
          }
          ?>
          <td> <button class='btn btn-danger btn-remove' data-id='<?=$f['kode_produk']?>'>Hapus dari list</button> </td>
        
         </tr>
      <?php
        }
      ?>

    </table>
</div>

<script>

    $(".btn-remove").on("click",async function(e){

        var id = e.target.getAttribute("data-id")
        await axios.post("sessioncheck.php",{'check':false,'id':id})
            .then(e=>{
                // mereload halaman
                $.post("produk-pilih.php",function(data) {
                    //    console.log(data)
                    // tampilkan data pcls yang sudah di perbaharui
                    // ke dalam <div id="page-all"></div>
                    $("#page-all").html(data).show();
                });   
                  
            })

    })
    
    function pilih(e){

       var status = (e == 1)?"READY":"KOSONG";

       if(confirm("Anda yakin ingin Merubah status Stok menjadi "+status)){
        
            window.location = 'ubah_stok_banyak.php?s='+e;

       
          }
      }
      function pilihpurchase(e){

      var status = $(e).attr('data-status')==1?"READY":"KOSONG";
      var toko = $(e).attr('data-toko')
      if(confirm("Anda yakin ingin Merubah status Stok menjadi "+status)){
      
          window.location = 'ubah_stok_banyak.php?s='+$(e).attr('data-status')+'&toko='+toko;

      }


      }
</script>