<?php
    require '../../connect.php';

    buka_koneksi();

    $id = $_POST['id'];

    $data = mysql_fetch_array(mysql_query("
    SELECT * FROM link_toped_sby WHERE id = '".$id."'"
    ));

    if($id > 0) {
        $kode_prod  = $data['kode_produk'];
        $link_prod1 = $data['link_1'];
        $link_prod2 = $data['link_2'];
        $id         = $data['id'];
    } else {
        $link_prod1 = "";
        $link_prod2 = "";
        $kode_prod  = "";
        $id         = "";
    }

?>
<form class="form-horizontal" method="POST" action="#" id="form-link">
    <div class="form-group">
      <label for="inputKodeProd" class="col-sm-3 control-label">Kode Produk</label>
      <div class="col-sm-9">
        <input type="hidden" class="form-control input-sm" name="id_tpd" id="id_tpd" value="<?php echo $id; ?>" placeholder="ID">
        <input type="text" class="form-control input-sm" name="kode_prod" id="kode_prod" value="<?php echo $kode_prod; ?>" placeholder="Kode Produk">
      </div>
    </div>
    <div class="form-group">
      <label for="inputLinkProd" class="col-sm-3 control-label">Link Produk 1</label>
      <div class="col-sm-9">
        <input type="text" class="form-control input-sm" name="link_prod1" id="link_prod1" value="<?php echo $link_prod1; ?>" placeholder="Link Produk 1">
      </div>
    </div>
    <div class="form-group">
      <label for="inputLinkProd" class="col-sm-3 control-label">Link Produk 2</label>
      <div class="col-sm-9">
        <input type="text" class="form-control input-sm" name="link_prod2" id="link_prod2" value="<?php echo $link_prod2; ?>" placeholder="Link Produk 2">
      </div>
    </div>
</form>
