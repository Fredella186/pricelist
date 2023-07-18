<?php
    session_start();
    if(!isset($_SESSION['hak_akses'])){
        echo '<script>location.href = "http://pcls.fastprint.co.id/plfp-backedit/login.php"</script>';
        exit;
    }
    // panggil berkas koneksi.php
    require 'connect.php';
    // print_r($_SESSION);
    $iiiiii = "style='display:block'";
    if($_SESSION['user'] !== 'test-it'){
        $iiiiii = "style='display:none'";

    }
    
	echo '<b>Hi '.strtoupper($_SESSION['user'])."</b> <p id='btn-proses'>";
    echo "<div > <input type='checkbox' onclick='Produkkosong(this)' {$_SESSION['produk-kosong']}> <b>Produk Kosong</b> </div>";

    // dia akses toko apa tidak 
    $table_stok = '';
    if($_SESSION['toko'] !== '' && $_SESSION['toko'] !== null){
        $table_stok = "_".$_SESSION['toko'];
    }

 
    // cek dia punya akses ubah tidak 
    $akses_btn = ($_SESSION['menu_toko'] == 1)?'ganti_stok(this)':'';
    $where_stok_toko = '';
    if($_SESSION['produk-kosong'] == 'checked'){
        // if($_SESSION['toko'] )
        $tooko = ($_SESSION['toko'] !== '' && $_SESSION['toko'] !== null)?'_'.$_SESSION['toko']:'';
            $where_stok_toko = ' AND stok'. $tooko.' = 0 ';
        }

    // buat koneksi ke database mysql
    buka_koneksi();
?> 
<style>
    table.atas table-striped {
        height: 75vp;

        
    }
    th.sticky-top{
        position: sticky;
        top: 60px;
        z-index: 15;
        color: white;
        
        
    }
    th.sticky-midle{
        position: sticky;
        top: 99px;
        z-index: 10;
        color: white;

        
    }
    td.geser{
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    td.wrap{
        white-space: nowrap;
    }
    th.jdl_lebar {
        position: relative;
    }
    th.jdl_lebar > .resizeTrigger {
        content: '';
        position: absolute;
        display: block;
        width: 100%;
        right: -4px;
        top: 0;
        height: 100%;
        background: transparent;
        cursor: ew-resize;
    }
    td.editor{
        white-space: normal;
        max-width: 400px;
        min-width: 400px;
    }
</style>
<div class="atas">
  <table class="table table-striped table-hover table-bordered" cellpadding="0" cellspacing="0">
      <thead>
      <tr style="outline: grey;">            
          <th class="sticky-top" rowspan="2" style="text-align:center;background-color: #22ABD8; ">#</th>
          <?php
            if($_SESSION['menu_toko'] == 1){
                echo "<th class='sticky-top' rowspan='2' style='background-color: #22ABD8;'><input type='checkbox' onchange='checkAll(this)'></th>";
            }
          ?> 
          <th class="sticky-top" rowspan="2" style="text-align:center; background-color: #22ABD8;">Gambar</th>
          <th class="sticky-top" rowspan="2" style="text-align:center; background-color: #22ABD8;">Judul</th>
          <th class="sticky-top" rowspan="2" style="text-align:center; background-color: #22ABD8;">Kategori</th>
          <!-- ternary  -->
          <!-- <th class="sticky-top" colspan="<?=($_SESSION['menu_toko'] == 0)?4:1?>" scope="colgroup" style="text-align:center;background-color: #22ABD8; ">Stok</th> -->
          <!-- tambah akses khusus pruchase bisa akses makasar -->
          <?php
          if ($_SESSION['menu_toko'] == 0 ){
              ?>
                <th class="sticky-top" colspan="6:1" scope="colgroup" style="text-align:center;background-color: #22ABD8; ">Stok</th>
            <?php
            }elseif($_SESSION['menu_toko'] == 1 && $_SESSION['kota'] == 'PUSAT'){
            ?>
                <th class="sticky-top" colspan="6:1" scope="colgroup" style="text-align:center;background-color: #22ABD8; ">Stok</th>
            <?php
            }elseif($_SESSION['menu_toko'] == 1 ){
                ?>
                <th class="sticky-top" colspan="6:1" scope="colgroup" style="text-align:center;background-color: #22ABD8; ">Stok</th>
            <?php
            }
          ?>
          <!-- <th class="sticky-top" rowspan="2" style="text-align:center; background-color: #22ABD8; ">Harga</th> -->
          <th class="sticky-top" rowspan="2" style="text-align:center; display:none; background-color: #22ABD8;">Harga UP</th>
          <th class="sticky-top" rowspan="2" style="text-align:center; background-color: #22ABD8;">Berat</th>
          <?php 
                if ( !empty($_SESSION["hak_akses"]) && $_SESSION['hak_akses'] == 'Administrator' || !empty($_SESSION["hak_akses"]) && $_SESSION["hak_akses"] == 'Editor') { 
                    echo "<th class='sticky-top' rowspan='2' style='text-align:center; background-color: #22ABD8;'>Dimensi Paket</th>";       
                } ?> 
		  <th class="sticky-top" rowspan="2" style="text-align:center; background-color: #22ABD8;">Link</th>
		  <!-- <th class="sticky-top" rowspan="2"style="text-align:center; background-color: #22ABD8;"></th> -->
          <?php 
              if( !empty($_SESSION["hak_akses"]) && $_SESSION["hak_akses"] == 'Administrator' || !empty($_SESSION["hak_akses"]) && $_SESSION["hak_akses"] == 'Accounting' || !empty($_SESSION["hak_akses"]) && $_SESSION["hak_akses"] == 'Editor') {	  
                  echo "<th class='sticky-top' style='text-align:center; background-color: #22ABD8;' rowspan='2'colspan='3' >Actions</th>";
              }
          ?>
          <th class="sticky-top" rowspan="2"style="text-align:center; background-color: #22ABD8;">Note</th>
      </tr>
      <tr>
          <?php
          if ($_SESSION['menu_toko'] == 1 && $_SESSION['kota'] == 'PUSAT') {
            ?>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;width:120px"> <?=($_SESSION['menu_toko'] == 1)?"PST":$_SESSION['toko']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;width:120px"> <?=($_SESSION['menu_toko'] == 1)?"JKT":$_SESSION['JKT']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;width:120px"> <?=($_SESSION['menu_toko'] == 1)?"BDG":$_SESSION['BDG']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;width:120px"> <?=($_SESSION['menu_toko'] == 1)?"BKS":$_SESSION['BKS']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;width:120px"> <?=($_SESSION['menu_toko'] == 1)?"MKS":$_SESSION['MKS']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;width:120px"> <?=($_SESSION['menu_toko'] == 1)?"MDN":$_SESSION['MDN']?></th>
            <?php
          } elseif ($_SESSION['menu_toko'] == 1 && $_SESSION['kota'] == 'JAKARTA') {
              ?>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"PST":$_SESSION['toko']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"JKT":$_SESSION['JKT']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"BDG":$_SESSION['BDG']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"BKS":$_SESSION['BKS']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"MKS":$_SESSION['MKS']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"MDN":$_SESSION['MDN']?></th>
            <?php   
          } elseif ($_SESSION['menu_toko'] == 1 && $_SESSION['kota'] == 'BANDUNG') {
              ?>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"PST":$_SESSION['toko']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"JKT":$_SESSION['JKT']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"BDG":$_SESSION['BDG']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"BKS":$_SESSION['BKS']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"MKS":$_SESSION['MKS']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"MDN":$_SESSION['MDN']?></th>
             <?php
          } elseif ($_SESSION['menu_toko'] == 1 && $_SESSION['kota'] == 'MAKASAR') {
              ?>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"PST":$_SESSION['toko']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"JKT":$_SESSION['JKT']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"BDG":$_SESSION['BDG']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"BKS":$_SESSION['BKS']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"MKS":$_SESSION['MKS']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"MDN":$_SESSION['MDN']?></th>
            <?php   
          } elseif ($_SESSION['menu_toko'] == 1 && $_SESSION['kota'] == 'MEDAN') {
                ?>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"PST":$_SESSION['toko']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"JKT":$_SESSION['JKT']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"BDG":$_SESSION['BDG']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"BKS":$_SESSION['BKS']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"MKS":$_SESSION['MKS']?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?"MDN":$_SESSION['MDN']?></th>
              <?php   
          } else {
               ?>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;width:180px"> <?=($_SESSION['menu_toko'] == 1)?$_SESSION['toko']:"PST"?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;width:180px"> <?=($_SESSION['menu_toko'] == 1)?$_SESSION['toko']:"JKT"?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;width:180px"> <?=($_SESSION['menu_toko'] == 1)?$_SESSION['toko']:"BDG"?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;width:180px"> <?=($_SESSION['menu_toko'] == 1)?$_SESSION['toko']:"BKS"?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;width:180px"> <?=($_SESSION['menu_toko'] == 1)?$_SESSION['toko']:"MKS"?></th>
                <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;width:180px"> <?=($_SESSION['menu_toko'] == 1)?$_SESSION['toko']:"MDN"?></th>
            <?php
            }
          ?>
        
        <!-- <th class="sticky-midle" group="col" style="text-align:center; background-color: #22ABD8;"> <?=($_SESSION['menu_toko'] == 1)?$_SESSION['toko']:"MKS"?></th> -->
      </tr>
      </thead>
      <tbody>
      <?php

        function highlightWords($produk, $cari){

            // $cariArr = explode(" ",$cari);

            $keywords = explode(' ', trim($cari));
            return $str = @preg_replace('/'.implode('|', $keywords).'/i', '<b style="color:black;background:#FF9632; text-transform: uppercase;">$0</b>', $produk);
        
        }

          $i = 1;
          $jml_per_halaman = 20; // jumlah data yg ditampilkan perhalaman
          $jml_data = mysql_num_rows(mysql_query("SELECT * FROM tb_pricelist WHERE status_view=1 ".$where_stok_toko." ORDER BY update_time DESC "));
          $jml_halaman = ceil($jml_data / $jml_per_halaman);
          // query pada saat mode pencarian
          if(isset($_POST['cari'])) {   
            $kunci = $_POST['cari'];
            //filter hasil cari yang mengandung karakter khusus
            $cek_kunci = array('-','_');
            
            //kondisikan jika $kunci mengandung karakter khusus
            if(!ctype_alnum(str_replace($cek_kunci, '', $kunci))){
                //query ketika pencarian memakai karakter khusus seperti -, _, etc
                $filter = (strpos('"', $kunci) === false) ? explode(' ', $kunci) : array(str_replace('"', '', $kunci));
                $sqlf = "SELECT * FROM tb_pricelist WHERE status_view=1 AND (judul_produk LIKE '%" . mysql_real_escape_string($filter[0]) . "%')";
                for ($a = 1; $a < sizeof($filter); $a++) {
                  $sqlf .= " AND (judul_produk LIKE '%" . mysql_real_escape_string($filter[$a]) . "%')";
              }
                $sqlf .= $where_stok_toko." ORDER BY update_time DESC";
                //var_dump($sqlf);
              $query = mysql_query($sqlf);
                // console.log($query);
              $jml = mysql_num_rows($query);
              $_SESSION['excel']['query'] = $sqlf;

            } else {
                //query ketika pencarian tidak mengandung karakter khusus seperti -, _, etc
                // echo "SELECT * FROM tb_pricelist WHERE status_view=1 AND kode_produk ".$where_stok_toko." LIKE '%".$kunci."%' ORDER BY update_time DESC";
                $query = mysql_query("SELECT * FROM tb_pricelist WHERE status_view=1 AND (kode_produk = '$kunci' or judul_produk LIKE '%".$kunci."%') ".$where_stok_toko." ORDER BY update_time DESC");
                $jml = mysql_num_rows($query);
                $_SESSION['excel']['query'] ="SELECT * FROM tb_pricelist WHERE status_view=1 AND kode_produk ".$where_stok_toko." LIKE '%".$kunci."%' ORDER BY update_time DESC";
            }
            echo
              "<script>
                    window.setTimeout(function() { $('.alert').alert('close'); }, 5000);
                </script>
                <div class='alert alert-dismissible alert-info fade in' id='srcAlert' role='alert'>
                    <button type='button' class='close btn-sm' data-dismiss='alert'>&times;</button>
                    Hasil pencarian dengan kata kunci <strong>".strtoupper($kunci)."</strong> ada <strong>".$jml."</strong> data.
                  </div>";
          }
          // query jika tampilan per kategori dipilih
          else if(isset($_POST['view_data'])){
              $ktg = $_POST['view_data'];
              $query = mysql_query("
                  SELECT * FROM tb_pricelist WHERE status_view=1 
                  AND ktg_produk = '".$ktg."' ".$where_stok_toko);
                  $_SESSION['excel']['query'] = "SELECT * FROM tb_pricelist WHERE status_view=1 AND ktg_produk = '".$ktg."' ".$where_stok_toko;
          }
          // query jika nomor halaman sudah ditentukan
          else if(isset($_POST['halaman'])) {
              $halaman = $_POST['halaman'];
              $i = ($halaman - 1) * $jml_per_halaman  + 1;
              $kat = (isset($_POST['kategori']) && $_POST['kategori']!=='')?" AND ktg_produk = '".$_POST['kategori']."'":"";
            //   echo "SELECT * FROM tb_pricelist WHERE status_view=1 ".$where_stok_toko.$kat."  ORDER BY update_time DESC LIMIT ".(($halaman - 1) * $jml_per_halaman).", $jml_per_halaman";
              $query = mysql_query("SELECT * FROM tb_pricelist WHERE status_view=1 ".$where_stok_toko.$kat."  ORDER BY update_time DESC LIMIT ".(($halaman - 1) * $jml_per_halaman).", $jml_per_halaman");
          // query ketika tidak ada parameter halaman maupun pencarian
          } else {
              $kat = (isset($_POST['kategori']) && $_POST['kategori']!=='')?" AND ktg_produk = '".$_POST['kategori']."'":"";

              $query = mysql_query("SELECT * FROM tb_pricelist WHERE status_view=1 ".$where_stok_toko.$kat." ORDER BY update_time DESC LIMIT 0, $jml_per_halaman");
              $halaman = 1; //tambahan
              $_SESSION['excel']['query'] = 'all';
          }
          // tampilkan data pricelist selama masih ada
        //   $_SESSION['excel']['query'] = $query;
        //   echo json_encode($_SESSION['excel']['query']);
          while($data = mysql_fetch_array($query))
          {
        ?>
              <tr>
                  <td class="geser"style="text-align:center;" rowspan='2'><?php echo $i; ?></td>
                  <?php
                    if($_SESSION['menu_toko'] == 1){
                        echo "<td rowspan='2'><input type='checkbox' name='checkbox' id='checkbox' class='checkbox-ini' data-chx='chx-{$data['kode_produk']}' data-id='{$data['kode_produk']}'></td>";
                    }
                  ?>
                  <td rowspan='2'>
                      <a class="image-popup-no-margins" href="<?php echo IMG_PATH . $data['gambar_produk'] ; ?>"><img loading="lazy" src="<?php echo IMG_PATH . $data['gambar_produk']; ?>" style="width:70px; height:70px;" /></a>
                    <!--p>Hanya Test</p-->
                  </td>
                  <td rowspan='2' class="<?= !empty($_SESSION["hak_akses"]) && $_SESSION['hak_akses'] == 'Editor' ? 'editor' : '' ?>"><a href="#" style="text-decoration:none;color:black;" data-toggle="tooltip" title="<?php echo $data['deskripsi_produk']; ?>">
                  <?php 
                        
                  		$jdl2 = $data['judul_produk'];
						if(isset($_POST['cari'])){
                            $cari2 = $_POST['cari'];
                            
                            // if($_SESSION['user'] == 'test-it'){
                             

                                $jdl2 = highlightWords($data['judul_produk'], $cari2);
                                

                            // }else{

                            //     $jdl2 = str_ireplace($cari2,"<span style='color:black;background:#FF9632'>".$cari2."</span>",$data['judul_produk']);

                            // }
                           
						}
						
						echo $jdl2."<br>SKU : ".$data['kode_produk']; 
          		  ?></a></td>
                  <td rowspan='2'>
                      <?php
                          $dataKtg = mysql_fetch_array(mysql_query("SELECT * FROM tb_kategori WHERE id_ktg = '".$data['ktg_produk']."'"));
                          echo $dataKtg['nama_ktg'];
                      ?>
                  </td> 
                  <?php

                //   PURCHASE bisa ubah stok pusat, makasar dan medan
                
                    if ($_SESSION['menu_toko'] == 1 && $_SESSION['kota'] == 'PUSAT') {               
                    ?>
                    <td><button class='btn btn-sm  <?=($data['stok'.$table_stok]=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok'.$table_stok];?>" data-id="<?=$data['kode_produk'];?>" data-toko="Pusat" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok'.$table_stok]=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm <?=($data['stok_jkt'.$table_stok]=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_jkt'.$table_stok];?>" data-id="<?=$data['kode_produk'];?>" data-toko='jkt' data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_jkt'.$table_stok]=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm <?=($data['stok_bdg'.$table_stok]=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_bdg'.$table_stok];?>" data-id="<?=$data['kode_produk'];?>" data-toko='bdg' data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_bdg'.$table_stok]=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm <?=($data['stok_bks'.$table_stok]=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_bks'.$table_stok];?>" data-id="<?=$data['kode_produk'];?>" data-toko='bks' data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_bks'.$table_stok]=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm <?=($data['stok_mks'.$table_stok]=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_mks'.$table_stok];?>" data-id="<?=$data['kode_produk'];?>" data-toko='mks' data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_mks'.$table_stok]=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm <?=($data['stok_mdn'.$table_stok]=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_mdn'.$table_stok];?>" data-id="<?=$data['kode_produk'];?>" data-toko='mdn' data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_mdn'.$table_stok]=='1')?'Ready':'Kosong'?></button></td>

                  <?php
                   }elseif ($_SESSION['menu_toko'] == 1 && $_SESSION['kota'] == 'JAKARTA') {
                    ?>
                    <td><button class='btn btn-sm  <?=($data['stok']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_jkt']=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_jkt'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_jkt']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_bdg']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_bdg'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_bdg']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_bks']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_bks'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_bks']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_mks']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_mks'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_mks']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_mdn']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_mdn'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_mdn']=='1')?'Ready':'Kosong'?></button></td>
                  <?php
                   }elseif ($_SESSION['menu_toko'] == 1 && $_SESSION['kota'] == 'BANDUNG') {
                    ?>
                    <td><button class='btn btn-sm  <?=($data['stok']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_jkt']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_jkt'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_jkt']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_bdg']=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_bdg'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_bdg']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_bks']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_bks'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_bks']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_mks']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_mks'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_mks']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_mdn']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_mdn'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_mdn']=='1')?'Ready':'Kosong'?></button></td>
                   <?php        
                   } elseif ($_SESSION['menu_toko'] == 1 && $_SESSION['kota'] == 'MAKASAR') {
                    ?>
                    <td><button class='btn btn-sm  <?=($data['stok']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_jkt']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_jkt'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_jkt']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_bdg']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_bdg'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_bdg']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_bks']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_bks'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_bks']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_mks']=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_mks'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_mks']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_mdn']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_mdn'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_mdn']=='1')?'Ready':'Kosong'?></button></td>
                    <?php
                   } elseif ($_SESSION['menu_toko'] == 1 && $_SESSION['kota'] == 'MEDAN') {
                    ?>
                    <td><button class='btn btn-sm  <?=($data['stok']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_jkt']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_jkt'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_jkt']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_bdg']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_bdg'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_bdg']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_bks']=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_bks'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_bks']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_mks']=='1')?'btn-primary':'btn-danger'?>' onclick='' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_mks'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_mks']=='1')?'Ready':'Kosong'?></button></td>
                    <td><button class='btn btn-sm  <?=($data['stok_mdn']=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_mdn'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_mdn']=='1')?'Ready':'Kosong'?></button></td>
                    <?php
                   } else {
                      ?>
                        <td><button class='btn btn-sm  <?=($data['stok']=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok']=='1')?'Ready':'Kosong'?></button></td>
                        <td><button class='btn btn-sm  <?=($data['stok_jkt']=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_jkt'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_jkt']=='1')?'Ready':'Kosong'?></button></td>
                        <td><button class='btn btn-sm <?=($data['stok_bdg']=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_bdg'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_bdg']=='1')?'Ready':'Kosong'?></button></td>
                        <td><button class='btn btn-sm <?=($data['stok_bks']=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_bks'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_bks']=='1')?'Ready':'Kosong'?></button></td>
                        <td><button class='btn btn-sm <?=($data['stok_mks']=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_mks'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_mks']=='1')?'Ready':'Kosong'?></button></td>
                        <td><button class='btn btn-sm <?=($data['stok_mdn']=='1')?'btn-primary':'btn-danger'?>' onclick='<?=$akses_btn?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok_mdn'];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok_mdn']=='1')?'Ready':'Kosong'?></button></td>
                   <?php
                    }
                  ?>
                
<!--
                  <td><?php //echo rupiah($data['harga_10']); ?></td>
-->
                  <td style='display:none'>
					<div class="panel panel-default" id="panel<?php echo $data['kode_produk']; ?>">
						<div class="panel-heading">
							<h5 class="panel-title">
								<a style="text-decoration:none;" data-toggle="collapse" data-id="<?php echo $data['kode_produk']; ?>" data-target="#up<?php echo $data['kode_produk']; ?>" href="#up<?php echo $data['kode_produk']; ?>" class="collapsed">
                                    <!--strong>Klik disini</strong-->
                                    Klik disini...
								</a>
							</h5>
						</div>

						<div id="up<?php echo $data['kode_produk']; ?>" class="panel-collapse collapse">
							<div class='table-responsive'>
								<table class="table table-bordered table-striped table-hover" >
									<tr class="warning">
										<th style="text-align:center; width: 140px;">MP</th>
										<th style="text-align:center; width: 200px;">Harga</th>
									</tr>
									<tr>
										<td>AlfaCart 20%</td>
										<td><?php if(!empty($data['up_blanja'])) echo rupiah($data['up_blanja']); else echo rupiah(0); ?></td>
									</tr>
									<tr>
										<td>Bhinneka 10%</td>
										<td><?php if(!empty($data['up_bhinneka'])) echo rupiah($data['up_bhinneka']); else echo rupiah(0); ?></td>
									</tr>									
									<tr>
										<td>Elevenia 10%</td>
										<td><?php if(!empty($data['up_elevenia'])) echo rupiah($data['up_elevenia']); else echo rupiah(0); ?></td>
									</tr>									
									<tr>
										<td>MM 10%</td>
										<td><?php if(!empty($data['up_mm'])) echo rupiah($data['up_mm']); else echo rupiah(0); ?></td>
									</tr>
									<tr>
										<td>Lazada 20%</td>
										<td><?php if(!empty($data['up_lazada'])) echo rupiah($data['up_lazada']); else echo rupiah(0); ?></td>
									</tr>
									<!--tr>
										<td>BliBli 20%</td>
										<td><?php if(!empty($data['up_blibli'])) echo rupiah($data['up_blibli']); else echo rupiah(0); ?></td>
									</tr-->
								</table>
							</div>
						</div>
					</div>
                  </td>
                  <td class="wrap"  rowspan='2'><?php echo berat($data['berat_produk']); ?></td>
                  <?php if( !empty($_SESSION["hak_akses"]) && $_SESSION["hak_akses"] == 'Administrator' || !empty($_SESSION["hak_akses"]) && $_SESSION["hak_akses"] == 'Editor'){ ?>
                        <td class="wrap"><?php echo $data['dimensi_produk']; ?></td>
                  <?php } ?>
                  <td  rowspan='2'><a href="#dialog-link" id="<?php echo $data['kode_produk']; ?>" class="links" data-toggle="modal">Klik</a></td>
                  <?php
                      if( !empty($_SESSION["hak_akses"]) && $_SESSION["hak_akses"] == 'Administrator' || !empty($_SESSION["hak_akses"]) && $_SESSION["hak_akses"] == 'Accounting' || !empty($_SESSION["hak_akses"]) && $_SESSION["hak_akses"] == 'Editor') {
                  ?>   
                  <td  rowspan='2'>
                      <a href="#dialog-pl" id="<?php echo $data['id_pricelist']; ?>" class="edit" data-toggle="modal">
                          <i class="glyphicon glyphicon-pencil"></i>
                      </a>
                  </td>
                  <td  rowspan='2'>
                      <a href="#" id="<?php echo $data['kode_produk']; ?>" class="delete">
                          <i class="glyphicon glyphicon-trash"></i>
                      </a>
                  </td>
                  <td  rowspan='2'>
                      <a href="#dialog-pl" id="<?php echo $data['id_pricelist']; ?>" class="buat_salinan" data-toggle="modal" >
                          <i class="glyphicon glyphicon-copy"></i>
                      </a>
                  </td>
                  <?php } ?>
                  <td  rowspan='2'>
                      <a href="#modalcatatan" data-id="<?php echo $data['id_pricelist']; ?>" data-note="<?= $data['catatan_produk']?>" class="note" data-toggle="modal">
                          <i class="glyphicon glyphicon-edit"></i></i>
                      </a>
                  </td>
              </tr> 
                    <!-- harga  -->
              <tr>
                <td colspan='6' style='text-align:center'>
                    <table class='table table-bordered' style='margin-bottom:0;font-size: 12px;'>
                        <tr class='bg-success' style='color:white'>
                            <td style='width:40px;color:white; background:#e74c3c'>#</td>
                            <td style='width:170px'>FP JAWA</td>
                            <td style='width:175px;background:orange'>MP OFFICIAL</td>
                            <td style='width:175px;background:orange'>MP JAWA</td>
                            <td style='width:175px;background:orange'>FP LUAR JAWA</td>
                            <td style='background:orange;width:270px'>MP LUAR JAWA</td>
                        </tr>
                        <tr>
                            <td>
                                <?php 
                                    if($_SESSION['hak_akses'] == 'Accounting'){
                                ?>
                                    <button class='btn btn-link' style='padding:0px' onclick='editHarga("<?=$data['kode_produk']; ?>","<?=$data['judul_produk']; ?>")'><i class="glyphicon glyphicon-pencil"></i></button>
                                <?php
                                    }
                                ?>
                            </td>
                            <td><strong><?php echo rupiah($data['harga_offline']); ?></strong></td>
                            <td><strong><?php echo rupiah($data['harga_online_official']); ?></strong></td>
                            <td><strong><?php echo rupiah($data['harga']); ?></strong></td>
                            <td><strong><?php echo rupiah($data['harga_offline_luar_jawa']); ?></strong></td>
                            <td><strong><?php echo rupiah($data['harga_luar_jawa']); ?></strong></td>
                        </tr>
                    </table>  
                  
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingThree">
                            <h5 class="mb-0" style='margin: 0;'>
                                <button class="btn btn-link collapsed btn-block"  style="font-size:12px;font-weight: 800;" data-toggle="collapse" data-target="#collapse<?=$data['id_pricelist']; ?>" aria-expanded="false" aria-controls="collapse<?=$data['id_pricelist']; ?>">
                                   Harga Tingkat
                                </button>
                            </h5>
                            </div>
                            <div id="collapse<?=$data['id_pricelist']; ?>" class="collapse" aria-labelledby="heading<?=$data['id_pricelist']; ?>" data-parent="#accordion">
                            <div class="card-body">
                                <table class="table table-bordered table-striped table-hover" style="font-size:12px;font-weight: 800;">
                                      <tr class="warning">
                                          <th style="text-align:center;color:white; background:#e74c3c">Qty</th>
                                          <th style="text-align:center;background:#18bc9c">FP JAWA</th>
                                          <th style="text-align:center;background:orange">MP OFFICIAL</th>
                                          <th style="text-align:center;background:orange">MP JAWA</th>
                                          <th style="text-align:center;background:orange">FP LUAR JAWA </th>
                                          <th style="text-align:center;background:orange">MP LUAR JAWA </th>
                                      </tr>
                                      <?php
                                          $qGrosir = mysql_query("SELECT rentang_qty, harga_wholesale,harga_wholesale_luar,harga_wholesale_offline_luar,harga_wholesale_offline,harga_wholesale_online_official FROM tb_wholesale WHERE id_produk = '".$data['kode_produk']."' ORDER BY `harga_wholesale` desc   ");
                                          while($datas = mysql_fetch_array($qGrosir)){
                                      ?>
                                      <tr>
                                          <td><?php
                                            $rentang = ((strpos($datas['rentang_qty'], 'Pack') == true) || (strpos($datas['rentang_qty'], 'Roll') == true) || (strpos($datas['rentang_qty'], 'Karton') == true)) ? $datas['rentang_qty'] : $datas['rentang_qty']." pcs";
                                            //echo $datas['rentang_qty']." pcs";
                                            if(strstr($dataKtg[1],'Kertas')){

                                                $rentang = $datas['rentang_qty'];

                                            }

                                            echo $rentang;

                                            ?></td>
                                          <td><?php echo rupiah($datas['harga_wholesale_offline']); ?></td>
                                          <td><?php echo rupiah($datas['harga_wholesale_online_official']); ?></td>
                                          <td><?php echo rupiah($datas['harga_wholesale']); ?></td>
                                          <td><?php echo rupiah($datas['harga_wholesale_offline_luar']); ?></td>
                                          <td><?php echo rupiah($datas['harga_wholesale_luar']); ?></td>
                                      </tr>
                                      <?php } ?>
                                  </table>  
                            </div>
                            </div>
                        </div>
                    </div>


                </td>
              </tr>
      <?php
              $i++;
          }
      ?>
    </tbody>
  </table>
</div>









<!-- modal - harga   -->
<div class="modal fade" id="harga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:80%!important" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title-harga">Edit Harga</h5>
      </div>
      <div class="modal-body" id='edit_harga'>
      </div>
    </div>
  </div>
</div>

<script>

    function editHarga(id,title){
       $("#harga").modal("show");
       $("#title-harga").text(title);
       $.get("form_harga_tingkat.php?id="+id)
       .then(e=>{$("#edit_harga").html(e)})
    }
</script>






















<!-- Modal -->
<!-- <div class="modal fade" id="proses-checklist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id='iframe-produk' style="width:100%;height:400px"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div> -->


<!-- untuk menampilkan menu halaman -->
<?php if(!isset($_POST['cari'])) {?>
<nav>
  <ul class="pagination pagination-sm">
    <?php

    // tambahan
    // panjang paging yang akan ditampilkan
    $no_hal_tampil = 5; // lebih besar dari 3
    //~ var_dump($halaman);
    if ($jml_halaman <= $no_hal_tampil) {
        $no_hal_awal = 1;
        $no_hal_akhir = $jml_halaman;
    } else {
        $val = $no_hal_tampil - 2; //3
        $mod = $halaman % $val; //
        $kelipatan = ceil($halaman/$val);
        $kelipatan2 = floor($halaman/$val);

        if($halaman < $no_hal_tampil) {
            $no_hal_awal = 1;
            $no_hal_akhir = $no_hal_tampil;
        } elseif ($mod == 2) {
            $no_hal_awal = $halaman - 1;
            $no_hal_akhir = $kelipatan * $val + 2;
        } else {
            $no_hal_awal = ($kelipatan2 - 1) * $val + 1;
            $no_hal_akhir = $kelipatan2 * $val + 2;
        }

        if($jml_halaman <= $no_hal_akhir) {
            $no_hal_akhir = $jml_halaman;
        }
    }

    for($i = $no_hal_awal; $i <= $no_hal_akhir; $i++) {
        // tambahan
        // menambahkan class active pada tag li
        $aktif = $i == $halaman ? ' active' : '';
    ?>
    <li class="halaman<?php echo $aktif ?>" id="<?php echo $i ?>"><a href="#"><?php echo $i ?></a></li>
    <?php } ?>
  </ul>
</nav>
<?php } ?>
<script src="resizable.js"></script>

<script type="text/javascript">
// var table = document.getElementsByTagName('table')[0];
// resizableGrid(table);

    $('.image-popup-no-margins').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: true,
        mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
        image: {
            verticalFit: true
        },
        zoom: {
            enabled: true,
            duration: 300 // don't foget to change the duration also in CSS
        }
    });

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            placement : 'right'
        });

        // setTimeout(() => {
        axios.get("sessioncheck.php?view=1")
        .then(e=>{
            // console.log(e['data'])
            Object.keys(e['data']).forEach((i)=> {

              if(document.querySelector(`[data-chx='chx-${e['data'][i]}']`)){

                document.querySelector(`[data-chx='chx-${e['data'][i]}']`).checked = true

              }
              
            });

            hitungcheck()
        })
        // }, 3000);
       
    });

    var main = "pricelist.data.php"; 
    var kode_produk = "";
    var id_pl = "";
	
  	// saat link di klik menampilkan list daftar link e-commerce produk
    $('.links').on("click", function(){
      var url	= "pricelist.link.php";
      //console.log(url);
      // ambil nilai id dari tombol ubah
      id_pl = `${this.id}`;
      console.log(id_pl);
      if(id_pl != 0) {
        // ubah judul modal dialog
        $("#linkModalLabel").html("Produk Link E-Commerce");
      }

      $.post(url, {kode_pl: id_pl} ,function(data) {
        // tampilkan pricelist.link.php ke dalam <div class="link-body"></div>
        $(".link-body").html(data).show();
      });
    });

    // ketika tombol note ditekan
    $('.note').on("click", function(){
        var url = "pricelist.note.php";
        //console.log(url);
        // ambil nilai id dari tombol ubah
        id_pl = $(this).attr('data-id');
        id_note = $(this).attr('data-note');
        // console.log(id_pl);
        $('#catatan'). val(id_pl)
        $('#catatan_produk'). text(id_note)

        if(id_pl != 0) {
        // ubah judul modal dialog
        $("#linkModalLabel").html("Catatan Produk");
      }  
    });


  	
    // ketika tombol edit ditekan
    $('.edit').on("click", function(){
            var url = "pricelist.form.php";
            // ambil nilai id dari tombol ubah
            id_pl = this.id;
            //~ alert(id_pl);
            if(id_pl != 0) {
                // ubah judul modal dialog
                $("#myModalLabel").html("Ubah Data Price List");
            }

            $.post(url, {id_pl: id_pl} ,function(data) {
                // console.log(data)
                // tampilkan pricelist.form.php ke dalam <div class="modal-body"></div>
                $(".modal-body").html(data).show();
                
            });
            
    });
    $('.salin').on("click")
    $('.buat_salinan').on("click", function(){
            var url = "pricelist.form.php";
            // ambil nilai id dari tombol ubah
            id_pl = this.id;
            //~ alert(id_pl);
            if(id_pl != 0) {
                // ubah judul modal dialog
                $("#myModalLabel").html("Buat Salinan");
            }

            $.post(url, {id_pl: id_pl} ,function(data) {
                // tampilkan pricelist.form.php ke dalam <div class="modal-body"></div>
                $(".modal-body").html(data).show();
                $('#hidden-pricelist').hide()
                $('#simpan-pricelist').hide()
                $('#salin-pricelist').show()
            });
    });

    $('.halaman').on("click", function(event){
            // mengambil nilai dari inputbox
            kd_hal = this.id;
            kat    = $("#view_data").val()
            $.post(main, {halaman: kd_hal,kategori:kat} ,function(data) {
                // tampilkan data mahasiswa yang sudah di perbaharui
                // ke dalam <div id="data-mahasiswa"></div>
                $("#data-pl").html(data).show();
            });
    }); 

    
    // ketika tombol hapus ditekan
    $('.delete').on("click", function(){
        var url = "pricelist.input.php";
        // ambil nilai id dari tombol hapus
        kode_produk = this.id;
        //alert(kode_produk);
        // tampilkan dialog konfirmasi
        var answer = confirm("Hapus data ini ?");

        // ketika ditekan tombol ok
        if (answer) {
            // mengirimkan perintah penghapusan ke berkas pricelist.input.php
            $.post(url, {del: kode_produk} ,function() {
                // tampilkan data pricelist yang sudah di perbaharui
                // ke dalam <div id="data-pl"></div>
                $("#data-pl").load(main);
            });
        }
    });

    function ganti_stok(e){
        let stok  = e.getAttribute("data-stok");
        let id    = e.getAttribute("data-id");
        let nama  = e.getAttribute("data-nama");
        let toko  = e.getAttribute("data-toko");
        let sku   = e.getAttribute("data-sku");
        textConf  = "Anda yakin mengubah stok "+nama+" ke READY?";
        let ubhKe = 1;
        let classS= "primary";
        if(stok == 1){ 
            textConf = "Anda yakin mengubah stok "+nama+" ke KOSONG?";
            ubhKe = 0;
            classS= "danger";
        }

        if(confirm(textConf)){

                e.setAttribute("data-stok",ubhKe);
                e.setAttribute("class","btn btn-"+classS);
                e.innerText = (ubhKe==1)?"Ready":"Kosong";

                $.post('ubah_stok.php', {ubah: ubhKe,id_pro:id,nama:nama,toko:toko,sku:sku} ,function(data) {
                    console.log(data);
                    if(data == "userkosong"){

                        alert("Anda sudah logout, proses ditolak...");
                        window.location = "login.php";
                    }
 
                });

        }

    }   

    function checkAll(ele) {
      var checkboxes = document.querySelectorAll(".checkbox-ini");
      if(ele.checked){

        checkboxes.forEach(cb => {
            cb.checked = true;

            var id = cb.getAttribute("data-id")
            axios.post("sessioncheck.php",{'check':true,'id':id})
            .then(e=>{
                console.log(e['data'])
            })

        });

      }else{

        checkboxes.forEach(cb => {
            cb.checked = false;
            var id = cb.getAttribute("data-id")
            axios.post("sessioncheck.php",{'check':false,'id':id})
            .then(e=>{
                console.log(e['data'])
            })

        });

      }
      hitungcheck()
    }

    document.querySelectorAll(".checkbox-ini").forEach(e=>{ 

        e.addEventListener("click",async (ew)=>{
            
            var id = ew.target.getAttribute("data-id");
            var chx= ew.target.checked;

            await axios.post("sessioncheck.php",{'check':chx,'id':id})
            .then(e=>{
                // console.log(e['data'])
                
                hitungcheck()   
            })

        })  


    })

    async function hitungcheck(){

        var chk = document.querySelectorAll(".checkbox-ini");
        var jml = 0;
        chk.forEach(element => {
            if(element.checked){
                jml++;
            }
        });
        
        if(jml == 0){

            await axios.get("sessioncheck.php?view=1")
            .then(e=>{
                jml = Object.keys(e['data']).length

                // .forEach((i)=> {

                //     jml++;
                //     console.log(jml)
                
                // });
            })

        }

        if(jml > 0){
          
            $("#btn-proses").html("<button class='btn btn-primary' onclick='produk_pilih(this)'>Proses Checklist</button>")
        
        }else{
            
            $("#btn-proses").html("")
        }

    }

    // ketika tombol halaman ditekan
    function produk_pilih(event){
       // mengambil nilai dari inputbox
       console.log(event)
       $.post("produk-pilih.php",function(data) {
        //    console.log(data)
           // tampilkan data mahasiswa yang sudah di perbaharui
           // ke dalam <div id="data-mahasiswa"></div>
           $("#page-all").html(data).show();
       });
    };

    function Produkkosong(e){
        var chc = '';
        if(e.checked == true){
            chc = "checked";
        }
        
        window.location = '?produk-kosong='+chc;

    }

    function each(arr, fn){
        let i = arr.length
        while(--i > -1){ fn(arr[i]) }
    }

    function px(val){ return [val, 'px'].join("") }

    var resizeElement, startSize, startX

    function beginResize(e){
        killResize()
        let th = e.target.parentElement
        resizeElement = th
        startSize = th.clientWidth
        startX = e.pageX
    }

    function killResize(){
        resizeElement = null
        startSize = null
        startX = null
    }

    each(document.querySelectorAll('th.jdl_lebar'), elem => {
        let trigger = document.createElement('span')
        trigger.className = 'resizeTrigger'
        
        trigger.addEventListener('mousedown', beginResize)
        
        elem.appendChild(trigger)
    })

    document.addEventListener('mousemove', e => {
        if(resizeElement){
            let diff = e.pageX - startX
            resizeElement.style.width = px(startSize + diff)
        }
    })

    document.addEventListener('mouseup', killResize)
</script>
<?php
    // tutup koneksi ke database mysql
    tutup_koneksi();
?>