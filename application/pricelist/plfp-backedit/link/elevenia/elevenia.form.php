<?php
    require '../../connect.php';

    buka_koneksi();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
    SELECT * FROM link_elevenia WHERE id = '".$id."'"
    ));

    if($id > 0) {
        $kode_prod  = $data['kode_produk'];
        $link_prod  = $data['link'];
        $id         = $data['id'];
    } else {
        $link_prod  = "";
        $kode_prod  = "";
        $id         = "";
    }

?>
<form class="form-horizontal" method="POST" action="#" id="form-link">
    <div class="form-group">
      <label for="inputKodeProd" class="col-sm-2 control-label">Kode Produk</label>
      <div class="col-sm-10">
        <input type="hidden" class="form-control input-sm" name="id_elv" id="id_elv" value="<?php echo $id; ?>" placeholder="ID">
        <input type="text" class="form-control input-sm" name="kode_prod" id="kode_prod" value="<?php echo $kode_prod; ?>" placeholder="Kode Produk">
      </div>
    </div>
    <div class="form-group">
      <label for="inputLinkProd" class="col-sm-2 control-label">Link Produk</label>
      <div class="col-sm-10">
        <input type="text" class="form-control input-sm" name="link_prod" id="link_prod" value="<?php echo $link_prod; ?>" placeholder="Link Produk">
      </div>
    </div>
</form>
