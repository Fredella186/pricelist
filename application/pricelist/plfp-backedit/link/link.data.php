<?php
  include "../connect.php";
  buka_koneksi();
?>
<br>
<br>
<div class="table-responsive">
  <table class="table table-striped table-hover table-bordered" cellpadding="0" cellspacing="0">
      <thead>
        <tr class="success">
          <th style="text-align:center;">#</th>
          <th style="text-align:center; width:500px;">Produk</th>
          <th style="text-align:center;">FP</th>
          <th style="text-align:center;">Toped<br>SBY</th>
          <th style="text-align:center;">Toped<br>JKT</th>
          <th style="text-align:center;">BL<br>SBY</th>
          <th style="text-align:center;">BL<br>JKT</th>
          <th style="text-align:center;">Lazada</th>
          <th style="text-align:center;">Matahari<br>Mall</th>
          <th style="text-align:center;">Bhinneka</th>
          <th style="text-align:center;">BliBli</th>
          <th style="text-align:center;">Elevenia</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $i = 1;
          $jml_per_halaman = 20; // jumlah data yg ditampilkan perhalaman
          $jml_data = mysql_num_rows(mysql_query("SELECT kode_produk, judul_produk, link_produk, update_time FROM tb_pricelist ORDER BY update_time DESC"));
          $jml_halaman = ceil($jml_data / $jml_per_halaman);
          if(isset($_POST['src'])) {
              $kunci = $_POST['src'];
              if(ctype_digit($kunci)){
                $q = "SELECT kode_produk, judul_produk, link_produk, update_time FROM tb_pricelist WHERE
                  kode_produk LIKE '%".$kunci."%' ORDER BY update_time DESC";
                $link = mysql_query($q);
              } else {
                $filter = (strpos('"', $kunci) === false) ? explode(' ', $kunci) : array(str_replace('"', '', $kunci));
              	$sqlf = "SELECT kode_produk, judul_produk, link_produk, update_time FROM tb_pricelist WHERE (judul_produk LIKE '%" . mysql_escape_string($filter[0]) . "%')";
              	for ($a = 1; $a < sizeof($filter); $a++) {
                    $sqlf .= " AND (judul_produk LIKE '%" . mysql_escape_string($filter[$a]) . "%')";
                }
              	$sqlf .= "ORDER BY update_time DESC";
                $link = mysql_query($sqlf);
              }
              $jml = mysql_num_rows($link);
              //~ var_dump($q); exit;
              echo
                "<script>
                    window.setTimeout(function() { $('.alert').alert('close'); }, 8000);
                </script>
                <div class='alert alert-dismissible alert-info fade in' id='srcAlert' role='alert'>
                    <button type='button' class='close btn-sm' data-dismiss='alert'>&times;</button>
                    Hasil pencarian dengan kata kunci <strong>".strtoupper($kunci)."</strong> ada <strong>".$jml."</strong> data.
                  </div>";
          }else if(isset($_POST['halaman'])) {
              $halaman = $_POST['halaman'];
              //~ var_dump($halaman);
              $i = ($halaman - 1) * $jml_per_halaman  + 1;
              $offset = ($halaman - 1) * $jml_per_halaman;
              $link = mysql_query("SELECT * FROM tb_pricelist ORDER BY update_time DESC LIMIT $offset, $jml_per_halaman");
              //~ var_dump("SELECT kode_produk, judul_produk, link_produk, update_time FROM tb_pricelist ORDER BY update_time DESC LIMIT ".$offset.", $jml_per_halaman");exit;
          // query ketika tidak ada parameter halaman maupun pencarian
          } else {
            //~ var_dump("test");
            $link = mysql_query("SELECT * FROM tb_pricelist ORDER BY update_time DESC LIMIT 0, $jml_per_halaman ");
            $halaman = 1;
          }
          while($row = mysql_fetch_array($link)){
        ?>
          <tr>
            <td class="tengah"><?php echo $i; ?></td>
            <td><?php echo $row['judul_produk']."<br /> SKU : ".$row['kode_produk']; ?></td>
            <td class="tengah">
              <?php
                if($row['link_produk'] != '')
                  echo "<span class='label label-success'><i class='glyphicon glyphicon-ok' title='".$row['link_produk']."'></i></span>";
                else
                  echo "<span class='label label-danger'><i class='glyphicon glyphicon-remove' title='Tidak Ada Link'></i></span>";
                ?></td>
            <td class="tengah">
              <?php
                $top_sby = mysql_fetch_array(mysql_query("SELECT kode_produk, link_1, link_2 FROM link_toped_sby WHERE kode_produk = '".$row['kode_produk']."'"));
                if($top_sby['kode_produk'] != '')
                  echo "<span class='label label-success'><i class='glyphicon glyphicon-ok' title='".$top_sby['link_1']."'></i></span>";
                else
                  echo "<span class='label label-danger'><i class='glyphicon glyphicon-remove' title='Tidak Ada Link'></i></span>";
                ?>
            </td>
            <td class="tengah">
              <?php
                $top_jkt = mysql_fetch_array(mysql_query("SELECT kode_produk, link_1, link_2 FROM link_toped_jkt WHERE kode_produk = '".$row['kode_produk']."'"));
                if($top_jkt['kode_produk'] != '')
                  echo "<span class='label label-success'><i class='glyphicon glyphicon-ok' title='".$top_jkt['link_1']."'></i></span>";
                else
                  echo "<span class='label label-danger'><i class='glyphicon glyphicon-remove' title='Tidak Ada Link'></i></span>";
                ?>
            </td>
            <td class="tengah">
              <?php
                $bl_sby = mysql_fetch_array(mysql_query("SELECT kode_produk, link FROM link_bl_sby WHERE kode_produk = '".$row['kode_produk']."'"));
                if($bl_sby['kode_produk'] != '')
                  echo "<span class='label label-success'><i class='glyphicon glyphicon-ok' title='".$bl_sby['link']."'></i></span>";
                else
                  echo "<span class='label label-danger'><i class='glyphicon glyphicon-remove' title='Tidak Ada Link'></i></span>";
                ?>
            </td>
            <td class="tengah">
              <?php
                $bl_jkt = mysql_fetch_array(mysql_query("SELECT kode_produk, link FROM link_bl_jkt WHERE kode_produk = '".$row['kode_produk']."'"));
                if($bl_jkt['kode_produk'] != '')
                  echo "<span class='label label-success'><i class='glyphicon glyphicon-ok' title='".$bl_jkt['link']."'></i></span>";
                else
                  echo "<span class='label label-danger'><i class='glyphicon glyphicon-remove' title='Tidak Ada Link'></i></span>";
                ?>
            </td>
            <td class="tengah">
              <?php
                $lzd = mysql_fetch_array(mysql_query("SELECT kode_produk, link FROM link_lazada WHERE kode_produk = '".$row['kode_produk']."'"));
                if($lzd['kode_produk'] != '')
                  echo "<span class='label label-success'><i class='glyphicon glyphicon-ok' title='".$lzd['link']."'></i></span>";
                else
                  echo "<span class='label label-danger'><i class='glyphicon glyphicon-remove' title='Tidak Ada Link'></i></span>";
                ?>
            </td>
            <td class="tengah">
              <?php
                $mm = mysql_fetch_array(mysql_query("SELECT kode_produk, link FROM link_mataharimall WHERE kode_produk = '".$row['kode_produk']."'"));
                if($mm['kode_produk'] != '')
                  echo "<span class='label label-success'><i class='glyphicon glyphicon-ok' title='".$mm['link']."'></i></span>";
                else
                  echo "<span class='label label-danger'><i class='glyphicon glyphicon-remove' title='Tidak Ada Link'></i></span>";
                ?>
            </td>
            <td class="tengah">
              <?php
                $bhn = mysql_fetch_array(mysql_query("SELECT kode_produk, link FROM link_bhinneka WHERE kode_produk = '".$row['kode_produk']."'"));
                if($bhn['kode_produk'] != '')
                  echo "<span class='label label-success'><i class='glyphicon glyphicon-ok' title='".$bhn['link']."'></i></span>";
                else
                  echo "<span class='label label-danger'><i class='glyphicon glyphicon-remove' title='Tidak Ada Link'></i></span>";
                ?>
            </td>
            <td class="tengah">
              <?php
                $bli = mysql_fetch_array(mysql_query("SELECT kode_produk, link FROM link_blibli WHERE kode_produk = '".$row['kode_produk']."'"));
                if($bli['kode_produk'] != '')
                  echo "<span class='label label-success'><i class='glyphicon glyphicon-ok' title='".$bli['link']."'></i></span>";
                else
                  echo "<span class='label label-danger'><i class='glyphicon glyphicon-remove' title='Tidak Ada Link'></i></span>";
                ?>
            </td>
            <td class="tengah">
              <?php
                $elv = mysql_fetch_array(mysql_query("SELECT kode_produk, link FROM link_elevenia WHERE kode_produk = '".$row['kode_produk']."'"));
                if($elv['kode_produk'] != '')
                  echo "<span class='label label-success'><i class='glyphicon glyphicon-ok' title='".$elv['link']."'></i></span>";
                else
                  echo "<span class='label label-danger'><i class='glyphicon glyphicon-remove' title='Tidak Ada Link'></i></span>";
                ?>
            </td>
          </tr>
        <?php $i++; } ?>
      </tbody>
  </table>
</div>

<!-- untuk menampilkan menu halaman -->
<?php if(!isset($_POST['src'])) {?>
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
        //~ var_dump($aktif);
    ?>
    <li class="halaman<?php echo $aktif ?>" id="<?php echo $i ?>"><a href="#"><?php echo $i ?></a></li>
    <?php } ?>
  </ul>
</nav>
<?php } ?>

<script type="text/javascript">
  var link_url = "link.data.php";
  $('.halaman').on("click", function(){
      kd_hal = this.id;
      //~ console.log(kd_hal);

      $.post(link_url, {halaman: kd_hal} ,function(data) {
        $("#data-link").html(data).show();
      });
  });
</script>
<?php tutup_koneksi(); ?>
