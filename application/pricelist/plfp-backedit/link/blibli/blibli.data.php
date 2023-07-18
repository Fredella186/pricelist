<?php
  include "../../connect.php";
  buka_koneksi();
?>
<br>
<br>
<div class="table-responsive">
  <table class="table table-striped table-hover table-bordered" cellpadding="0" cellspacing="0">
      <thead>
        <tr class="success">
          <th style="text-align:center;">#</th>
          <th style="text-align:center; width:600px;">Produk</th>
          <th style="text-align:center;">Kategori</th>
          <th style="text-align:center;">Link BliBli</th>
          <th colspan="2" style="text-align:center;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $i = 1;
          $jml_per_halaman = 20; // jumlah data yg ditampilkan perhalaman
          $jml_data = mysql_num_rows(mysql_query("
          SELECT p.judul_produk, bli.kode_produk, ktg.nama_ktg, bli.id, bli.link, bli.update_time FROM link_blibli bli
          INNER JOIN tb_pricelist p ON p.kode_produk = bli.kode_produk
          INNER JOIN tb_kategori ktg ON ktg.id_ktg = p.ktg_produk ORDER BY bli.update_time DESC
          "));
          $jml_halaman = ceil($jml_data / $jml_per_halaman);
          if(isset($_POST['src'])) {
              $kunci = $_POST['src'];
              if(ctype_digit($kunci)){
                $q = "SELECT p.judul_produk, bli.kode_produk, ktg.nama_ktg, bli.id, bli.link, bli.update_time FROM link_blibli bli
                  INNER JOIN tb_pricelist p ON p.kode_produk = bli.kode_produk
                  INNER JOIN tb_kategori ktg ON ktg.id_ktg = p.ktg_produk WHERE bli.kode_produk LIKE '%$kunci%' ORDER BY bli.update_time DESC";
                $link = mysql_query($q);
              } else {
                $q = "SELECT p.judul_produk, bli.kode_produk, ktg.nama_ktg, bli.id, bli.link, bli.update_time FROM link_blibli bli
                  INNER JOIN tb_pricelist p ON p.kode_produk = bli.kode_produk
                  INNER JOIN tb_kategori ktg ON ktg.id_ktg = p.ktg_produk WHERE p.judul_produk LIKE '%$kunci%' ORDER BY bli.update_time DESC";
                $link = mysql_query($q);
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
              $link = mysql_query("SELECT p.judul_produk, bli.kode_produk, ktg.nama_ktg, bli.id, bli.link, bli.update_time FROM link_blibli bli
                    INNER JOIN tb_pricelist p ON p.kode_produk = bli.kode_produk
                    INNER JOIN tb_kategori ktg ON ktg.id_ktg = p.ktg_produk ORDER BY bli.update_time DESC LIMIT $offset, $jml_per_halaman");
          // query ketika tidak ada parameter halaman maupun pencarian
          } else {
            //~ var_dump("test");
            $link = mysql_query("SELECT p.judul_produk, bli.kode_produk, ktg.nama_ktg, bli.id, bli.link, bli.update_time FROM link_blibli bli
                  INNER JOIN tb_pricelist p ON p.kode_produk = bli.kode_produk
                  INNER JOIN tb_kategori ktg ON ktg.id_ktg = p.ktg_produk ORDER BY bli.update_time DESC LIMIT 0, $jml_per_halaman");
            $halaman = 1;
          }
          while($row = mysql_fetch_array($link)){
        ?>
          <tr>
            <td class="tengah"><?php echo $i; ?></td>
            <td><?php echo $row['judul_produk']."<br /> SKU : ".$row['kode_produk']; ?></td>
            <td class="tengah"><?php echo $row['nama_ktg']; ?></td>
            <td class="tengah">
              <a target="_blank" href="<?php echo $row['link']; ?>" title="<?php echo $row['link']; ?>">Klik</a>
            </td>
            <td class="tengah">
                <a href="#dialog-link" title="Ubah" id="<?php echo $row['id']; ?>" class="edit" data-toggle="modal">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
            </td>
            <td class="tengah">
                <a href="#" title="Hapus" id="<?php echo $row['id']; ?>" class="delete">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
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
        $aktif = $i == $halaman ? ' active' : '';
        //~ var_dump($aktif);
    ?>
    <li class="halaman<?php echo $aktif ?>" id="<?php echo $i ?>"><a href="#"><?php echo $i ?></a></li>
    <?php } ?>
  </ul>
</nav>
<?php } ?>

<script type="text/javascript">
  var link_url = "blibli.data.php";

  $('.edit').on("click", function(){
      var url = "blibli.form.php";
      var id_bli = this.id;
      if(id_bli != 0)
          $("#myModalLabel").html("Ubah Data Link BliBli");

      $.post(url, {id: id_bli} ,function(data) {
          $(".modal-body").html(data).show();
      });
  });

  $('.delete').on("click", function(){
      var url = "blibli.input.php";
      var id = this.id;
      var answer = confirm("Hapus data ini ?");

      if (answer) {
        $.post(url, {del: id} ,function() {
          $("#data-link").load(link_url);
        });
      }
  });

  $('.halaman').on("click", function(){
      var kd_hal = this.id;
      //~ console.log(kd_hal);

      $.post(link_url, {halaman: kd_hal} ,function(data) {
        $("#data-link").html(data).show();
      });
  });
</script>
<?php tutup_koneksi(); ?>
