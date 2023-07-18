<?php
    // panggil file koneksi.php
    require 'connect.php';

    // buat koneksi ke database mysql
    buka_koneksi();

    // tangkap variabel kd_mhs
    $id_pl = $_POST['id_pl'];
    // query untuk menampilkan mahasiswa berdasarkan kd_mhs
    $data = mysql_fetch_array(mysql_query("
    SELECT * FROM tb_pricelist WHERE status_view=1 AND id_pricelist = '".$id_pl."'"
    )); 

    // jika prod_code > 0 / form ubah data
    if($id_pl > 0) {
        $gambar_prod    = $data['gambar_produk'];
        $ktg_prod       = $data['ktg_produk'];
        $judul_prod     = $data['judul_produk'];
    	$nama_alias     = $data['nama_alias'];
        $deskripsi_prod = $data['deskripsi_produk'];
        $harga_prod     = $data['harga'];
        $harga_10_prod  = $data['harga_10'];
        $harga_up_blanja= $data['up_blanja'];
        $harga_up_bhinn = $data['up_bhinneka'];
        $harga_up_elv 	= $data['up_elevenia'];
        $harga_up_mm 	= $data['up_mm'];
        $harga_up_lzd 	= $data['up_lazada'];
        $harga_up_bb 	= $data['up_blibli'];
        $berat_prod     = $data['berat_produk'];
        $dimensi_prod   = $data['dimensi_produk'];
        $link_prod      = $data['link_produk'];
        $kode_prod      = $data['kode_produk'];
        //~ $id_pl          = $data['id_pricelist'];

    //form tambah data
    } else {
        $rentang_qty    = "";
        $harga_grosir   = "";
        $gambar_prod    = "";
        $ktg_prod       = "";
        $judul_prod     = "";
    	$nama_alias     = "";
        $deskripsi_prod = "";
        $harga_prod     = "";
        $harga_10_prod  = "";
        $harga_up_blanja= "";
        $harga_up_bhinn = "";
        $harga_up_elv 	= "";
        $harga_up_mm 	= "";
        $harga_up_lzd 	= "";
        $harga_up_bb 	= "";
        $berat_prod     = "";
        $dimensi_prod   = "";
        $link_prod      = "";
        $kode_prod      = "";
        $id_pl          = "";
    }

?>
<form class="form-horizontal" method="POST" action="#" enctype="multipart/form-data" id="form-pricelist">
    <div class="form-group">
      <label for="inputGbrProd" class="col-sm-2 control-label">Gambar Produk</label>
      <div class="formImage col-sm-6">
        <input type="hidden" class="form-control input-sm" name="id_pricelist" id="id_pricelist" value="<?php echo $id_pl; ?>">
        <?php
			$path = IMG_PATH . $gambar_prod;
			//~ var_dump(file_exists($path));
			//~ var_dump($gambar_prod);
            if(!file_exists($path) || $gambar_prod == ""){
        ?>
			<input type="file" class="form-control input-sm" onchange="injectNameProduct();" name="gambar_prod" id="gambar_prod" />
			<input type="hidden" name="gambar_text" id="gambar_text" />
			</div>
			<div id="btn-upload" class="col-sm-4">
				<input type="button" onclick="doUploadProduk();" name="btnUpload" id="btnUpload" class="btn btn-primary btn-sm" value="Upload">
			</div>
        <?php } else { ?>
				<div id="showUpdImage" style="display: block;">
					<img id="gbr_prod" src="<?php echo IMG_PATH . $gambar_prod; ?>" title="<?php echo $gambar_prod; ?>" style="width:70px; height:70px;" />
					<input type="hidden" name="gambar_text" id="gambar_text" value="<?php echo $gambar_prod; ?>" />&emsp;
					<input type="button" name="btnImgDel" id="btnImgDel" onclick='hapus_gambar()' class="btn btn-primary btn-sm" value="Ubah Gambar">
				</div>
  			</div>
        <?php } ?>
    
    </div>
    <div class="form-group">
      <label for="inputKtgProd" class="col-sm-2 control-label">Kategori Produk</label>
      <div class="col-sm-10">
        <select class="form-control" name="ktg_prod" id="ktg_prod">
            <?php
                if($ktg_prod != ""){
                    $dataKtg = mysql_fetch_array(mysql_query("SELECT * FROM tb_kategori WHERE id_ktg = '".$ktg_prod."'"));
                    echo "<option value='".$dataKtg['id_ktg']."' selected>".$dataKtg['nama_ktg']."</option>";
                } else {echo "<option value='0' selected>--- Pilih Kategori ---</option>";}

                $Qktg = mysql_query("SELECT * FROM tb_kategori");
                while($rowKtg = mysql_fetch_array($Qktg)){
                    echo "<option value='".$rowKtg['id_ktg']."'>".$rowKtg['nama_ktg']."</option>";
                }
            ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="inputKodeProd" class="col-sm-2 control-label">SKU</label>
      <div class="col-sm-10">
        <input type="text" class="form-control input-sm" name="kode_prod" id="kode_prod" value="<?php echo $kode_prod; ?>" placeholder="SKU" />
      	<input type="text" class="kd-lama" name="kode_lama" id="kode_lama" value="<?php echo $kode_prod; ?>" disabled />
      </div>
    </div>
    <div class="form-group">
      <label for="inputJudulProd" class="col-sm-2 control-label">Judul Produk</label>
      <div class="col-sm-10">
        <textarea class="form-control input-sm" name="judul_prod" id="judul_prod" placeholder="Judul Produk"><?php echo $judul_prod; ?></textarea>
      </div>
    </div>
   <div class="form-group">
      <label for="inputNamaAlias" class="col-sm-2 control-label">Nama Alias</label>
      <div class="col-sm-10">
        <textarea class="form-control input-sm" name="nama_alias" id="nama_alias"  placeholder="Nama Alias"><?php echo $nama_alias; ?></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="txtDeskripsiProd" class="col-sm-2 control-label">Deskripsi Produk</label>
      <div class="col-sm-10">
        <textarea name="deskripsi_prod" id="deskripsi_prod" class="form-control input-sm" rows="5" placeholder="Deskripsi Produk"><?php echo $deskripsi_prod; ?></textarea>
      </div>
    </div>
    <!-- <div class="form-group">
      <label for="inputHargaProd" class="col-sm-2 control-label">Harga Produk</label>
      <div class="col-sm-10">
        <input type="text" class="form-control input-sm" name="harga_prod" id="harga_prod" value="<?php echo $harga_prod; ?>" placeholder="Harga Produk">
      </div>
    </div>
    <div class="form-group">
      <label for="inputHargaProd" class="col-sm-2 control-label">Input Harga Tingkat</label>
      <div class="col-sm-10">
        <table id="harga_tingkat" class="table table-bordered">
            <tr class="warning">
                <th style="text-align:center;"><input type="checkbox" class="input-sm" id="cb_all" onclick="cekSemua();" /></th>
                <th style="text-align:center;">Qty</th>
                <th style="text-align:center;">Harga</th>
            </tr> 
            <?php
                $jml = 0;
                if($id_pl > 0){

                    $qGrosir = mysql_query("SELECT * FROM tb_wholesale WHERE id_produk = '".$kode_prod."' ORDER BY `harga_wholesale` DESC");
                    $jml = mysql_num_rows($qGrosir);
                    $i = 1;
                    while($grosir = mysql_fetch_array($qGrosir)){
                    $rentang_qty  = $grosir['rentang_qty'];
                    $harga_grosir = $grosir['harga_wholesale'];

            ?>
            <tr>
                <td><input type="checkbox" class="cbHPP input-sm" id="cbHPP" name="cbHT" />
                <input type="hidden" name="nmr_<?php echo $i; ?>" id="nmr_<?php echo $i; ?>" value="<?php echo $i; ?>" /></td>
                <td><input type="text" class="form-control input-sm" name="qty_<?php echo $i; ?>" id="qty" value="<?php echo $rentang_qty; ?>" placeholder="Qty"></td>
                <td><input type="text" class="form-control input-sm" name="hrg_<?php echo $i; ?>" id="hrg" value="<?php echo $harga_grosir; ?>" placeholder="Harga"></td>
            </tr>
            <?php $i++; }}?>
        </table>
        <div class="pull-right">
            <a href="#" class="btnAddHT btn btn-info btn-sm" id="btnAddHT"><i class="glyphicon glyphicon-plus"></i></a>
            <a href="#" class="btnDelHT btn btn-danger btn-sm" id="btnDelHT"><i class="glyphicon glyphicon-minus"></i></a>
        </div>
    </div> -->
    <div class="form-group">
      <label for="inputHarga10Prod" class="col-sm-2 control-label">Harga UP</label>
      <div class="col-sm-10">
<!--
        <input type="checkbox" class="cek10"/> cek untuk aktifkan harga up fastprint
        <input type="text" class="form-control input-sm" name="harga_10_prod" id="harga_10_prod" value="<?php echo $harga_10_prod; ?>" placeholder="FastPrint 10%" disabled />
-->
        <input type="checkbox" class="cek_blanja"/> cek untuk aktifkan harga up alfacart
        <input type="text" class="form-control input-sm" name="harga_up_blanja" id="harga_up_blanja" value="<?php echo $harga_up_blanja; ?>" placeholder="AlfaCart 20%" disabled />
        <input type="checkbox" class="cek_bhinn"/> cek untuk aktifkan harga up bhinneka
        <input type="text" class="form-control input-sm" name="harga_up_bhinn" id="harga_up_bhinn" value="<?php echo $harga_up_bhinn; ?>" placeholder="Bhinneka 10%" disabled />
        <input type="checkbox" class="cek_elv"/> cek untuk aktifkan harga up elevenia
        <input type="text" class="form-control input-sm" name="harga_up_elv" id="harga_up_elv" value="<?php echo $harga_up_elv; ?>" placeholder="Elevenia 10%" disabled />
        <input type="checkbox" class="cek_mm"/> cek untuk aktifkan harga up mataharimall
        <input type="text" class="form-control input-sm" name="harga_up_mm" id="harga_up_mm" value="<?php echo $harga_up_mm; ?>" placeholder="MatahariMall 10%" disabled />
        <input type="checkbox" class="cek_lzd"/> cek untuk aktifkan harga up lazada
        <input type="text" class="form-control input-sm" name="harga_up_lzd" id="harga_up_lzd" value="<?php echo $harga_up_lzd; ?>" placeholder="Lazada 20%" disabled />
        <!--input type="checkbox" class="cek_bb"/> cek untuk aktifkan harga up blibli
        <input type="text" class="form-control input-sm" name="harga_up_bb" id="harga_up_bb" value="<?php echo $harga_up_bb; ?>" placeholder="BliBli 20%" disabled /-->
      </div>
    </div>
    <div class="form-group">
      <label for="inputBeratProd" class="col-sm-2 control-label">Berat Produk (Gr)</label>
      <div class="col-sm-10">
        <input type="text" class="form-control input-sm" name="berat_prod" id="berat_prod" value="<?php echo $berat_prod; ?>" placeholder="Berat Produk">
      </div>
    </div>
    <div class="form-group">
      <label for="inputDimensiProd" class="col-sm-2 control-label">Dimensi Produk <br>(P x L x T)</label>
      <div class="col-sm-10">
        <input type="text" class="form-control input-sm" name="dimensi_prod" id="dimensi_prod" value="<?php echo $dimensi_prod; ?>" placeholder="Dimensi Produk">
      </div>
    </div>
    <div class="form-group" style="display:none">
      <label for="inputLinkProd" class="col-sm-2 control-label">Link Produk</label>
      <div class="col-sm-10">
        <input type="text" class="form-control input-sm" name="link_prod" id="link_prod" value="<?php echo $link_prod; ?>" placeholder="Link Produk">
        <br />
      	<div class="pull-right">
			<a href="#" class="btnAddLK btn btn-info btn-sm" id="btnAddLK"><i class="glyphicon glyphicon-plus"></i> LINK WEB</a>
	  	</div><br/>
	  	<div id="list_link" style="display:none;"> <br/>
      		<?php 
				 $lk_web_fp = mysql_fetch_array(mysql_query("SELECT * FROM tb_link_website WHERE kode_produk = '".$kode_prod."'"));
				 //echo $lk_web_fp['link_fp'];
				 
				 if($lk_web_fp['kode_produk'] > 0) {
					 
					$linkweb_produk  = $lk_web_fp['link_fp'];
					//echo $linkweb_produk;
				 } else {
					 
					$linkweb_produk  = "";
					
				}
				//echo $linkweb_produk;
			?>
			<input type="text" class="form-control input-sm " name="link_web" id="link_web" value="<?php echo $linkweb_produk; ?>" placeholder="Link Sub Produk di WEB FP">
		  	
        </div>
      </div>
    </div>
</form>
<script>
	
	function hargaUp(ecomm, sale){
		var diskon 	= ecomm * (sale / 100);
		var hrgUp 	= parseInt(ecomm) + parseInt(diskon);
		return hrgUp;
	}
	
    function cekSemua() {
        $('.cbHPP').each(function(){
            if($('#cb_all:checked').length == 0){
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }
        });
    }

    var id, nmr = <?php echo $jml; ?>;
    if(nmr >= 1)
        id = nmr;
    else
        id = 0;
    $('.btnAddHT').on('click', function() {
        id++;
        //~ console.log(id);
        var add_hpp = '<tr>' +
                '<td><input type="checkbox" name="cbHT" class="cbHPP input-sm" id="cbHPP" /> ' +
                '<input type="hidden" id="nmr_'+id+'" name="nmr_'+id+'" value="'+id+'" /></td>' +
                '<td><input type="text" class="form-control input-sm" name="qty_'+id+'" id="qty_'+id+'" placeholder="Qty"></td>' +
                '<td><input type="text" class="form-control input-sm" name="hrg_'+id+'" id="hrg_'+id+'" placeholder="Harga"></td></tr>';
        $('#harga_tingkat').append(add_hpp);
    });

    $('.btnDelHT').on('click', function(){
        $('.cbHPP:checked').parents("tr").remove();
        id=0;
    });
    
    var add_newImg = '<input type="file" class="form-control input-sm" name="gambar_prod" id="gambar_prod" onchange="injectNameProduct();" /> <input type="hidden" name="gambar_text" id="gambar_text" /></div><div id="btn-upload" class="col-sm-4"><input type="button" name="btnUpload" id="btnUpload" class="btn btn-primary btn-sm" onclick="doUploadProduk();" value="Upload"></div>';
    

	$('#btnAddLK').on('click', function() {	
		$('#list_link').show();
    });

	function doUploadProduk() {
            $('#gambar_text').val('');
		//$('input:button[name=btnUpload]').on('click', function(){
			var file = $('#gambar_prod')[0].files[0];
            console.log(file)		 	
			var form_data = new FormData(); 
			form_data.append('file', file);
		    console.log(form_data);
			//alert("test");
			$.ajax({
				url : 'upload.php',
				type : 'POST',
				cache : false,
				data : form_data,
				processData : false,
				contentType : false,
				dataType : 'text',
				success : function(data){
					// //console.log(data);
                    // var nama_file = JSON.parse(data);
					// //console.log(data);
					
					// nama_file.forEach(function(item) {
					// 	console.log(item.file);
					// 	$('#gambar_text').val(item.file);
					// });
					// // switch(data){
					// // 	case 'success' : alert("Upload gambar produk berhasil.."); break;
					// // 	case 'replaced' : alert("File gambar produk lama telah terganti.."); break;
					// // 	case 'error' : alert("Terjadi kesalahan pada file !"); break;
					// // 	case 'disallowed' : alert("File gambar produk harus JPG, JPEG, PNG !"); break;
					// // 	case 'large' : alert("File gambar produk terlalu besar.. ! Harus < 256 KB.."); break;
					// // 	default: console.log(data);
					// // }
                    
                    console.log(data);
                    var attr_file = JSON.parse(data);
                    if(typeof attr_file.file_name != 'undefined'){
                        $('#gambar_text').val(attr_file['file_name']);
                    }
					switch(attr_file['response']){
						case 'success' : alert("Upload gambar produk berhasil.."); break;
						case 'replaced' : alert("File gambar produk lama telah terganti.."); break;
						case 'error' : alert("Terjadi kesalahan pada file !"); break;
						case 'disallowed' : alert("File gambar produk harus JPG, JPEG, PNG !"); break;
						case 'large' : alert("File gambar produk terlalu besar.. ! Harus < 256 KB.."); break;
						default: console.log(data);
					}
				}
			});

		//});
	}

	function injectNameProduct(){
		//~ $('#gambar_prod').on('change', function (){
			var a = document.querySelector('input[type=file]').files[0];
            // console.log(a)
			//$('#gambar_text').val(a);
			//~ console.log($('#gambar_text').val());
		//~ });
	}

    $('.cek10').change(function(){
        if ($('.cek10').is(':checked') == true){
            $('#harga_10_prod').prop('disabled', false);
            var harga = $('#harga_prod').val();
            var hrgUp = hargaUp(harga, 10);
            $('#harga_10_prod').val(hrgUp);
        } else {
            $('#harga_10_prod').val('').prop('disabled', true);
        }
    });

    $('.cek_blanja').change(function(){
        if ($('.cek_blanja').is(':checked') == true){
            $('#harga_up_blanja').prop('disabled', false);
            var harga = $('#harga_prod').val();
            var potongan = harga * (10 / 100);
            var hrgUp = hargaUp(harga, 20);
            $('#harga_up_blanja').val(hrgUp);
        } else {
            $('#harga_up_blanja').val('').prop('disabled', true);
        }
    });

    $('.cek_bhinn').change(function(){
        if ($('.cek_bhinn').is(':checked') == true){
            $('#harga_up_bhinn').prop('disabled', false);
            var harga = $('#harga_prod').val();
            var hrgUp = hargaUp(harga, 10);
            $('#harga_up_bhinn').val(hrgUp);
        } else {
            $('#harga_up_bhinn').val('').prop('disabled', true);
        }
    });

    $('.cek_elv').change(function(){
        if ($('.cek_elv').is(':checked') == true){
            $('#harga_up_elv').prop('disabled', false);
            var harga = $('#harga_prod').val();
            var hrgUp = hargaUp(harga, 10);
            $('#harga_up_elv').val(hrgUp);
        } else {
            $('#harga_up_elv').val('').prop('disabled', true);
        }
    });

    $('.cek_mm').change(function(){
        if ($('.cek_mm').is(':checked') == true){
            $('#harga_up_mm').prop('disabled', false);
            var harga = $('#harga_prod').val();
            var hrgUp = hargaUp(harga, 10);
            $('#harga_up_mm').val(hrgUp);
        } else {
            $('#harga_up_mm').val('').prop('disabled', true);
        }
    });

    $('.cek_lzd').change(function(){
        if ($('.cek_lzd').is(':checked') == true){
            $('#harga_up_lzd').prop('disabled', false);
            var harga = $('#harga_prod').val();
            var hrgUp = hargaUp(harga, 20);
            $('#harga_up_lzd').val(hrgUp);
        } else {
            $('#harga_up_lzd').val('').prop('disabled', true);
        }
    });

    $('.cek_bb').change(function(){
        if ($('.cek_bb').is(':checked') == true){
            $('#harga_up_bb').prop('disabled', false);
            var harga = $('#harga_prod').val();
            var hrgUp = hargaUp(harga, 20);
            $('#harga_up_bb').val(hrgUp);
        } else {
            $('#harga_up_bb').val('').prop('disabled', true);
        }
    });

    // dinonaktifkan karna tidak bekerja 

    // $('#btnImgDel').on('click', function(){
       
	// });

    function hapus_gambar(){
        console.log("disini")
		var image = $('#gambar_text').val();
		var form_data = new FormData();
        form_data.append('img', image);
        console.log(form_data)
		$.ajax({
            url : 'upload.php',
            type : 'POST',
            cache : false,
            data : form_data,
            processData : false,
            contentType : false,
            dataType : 'text',
            success : function(data){
                //~ console.log(data);
                switch(data){
                    case 'deleted' : alert("Pilih gambar produk yang baru..!"); break;
                    default: console.log(data);
                }
                //~ this.html(data);
                $('#showUpdImage').remove();                
                $('.formImage').append(add_newImg);
                //~ $('#btnImgDel').hide();
                //~ $('#input-file').show();
                //~ $('#btn-upload').show();
            }
        });
    }
</script>