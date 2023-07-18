
<?php
	// echo '<script>alert("responses page!!")</script>';
	session_start();
	include "connect.php";
	buka_koneksi();
	$toko = '';
	$sql_ket  = "SELECT * FROM  `tb_ecommerce` GROUP BY nama_toko";
	$qket     = mysql_query($sql_ket);
	$jml_k    = mysql_num_rows($qket);
	$i  = 0;
	while($fk = mysql_fetch_assoc($qket)){
		if($i !== 0 && $i < $jml_k){
			$toko .='|';
		}
		$toko .= $fk['nama_toko'];
		
		$i++;

	}

	$regex_toko = '/'.$toko.'/';
	$_SESSION['c_link'] = array();
	
?>
<table id="loadLink" class="table table-bordered" align="center" style="width: 800px;">
	<tr class="warning">
		<th><input type="checkbox" name="" id="" onclick="centang_all(this)"></th>
		<th style="text-align:center; width:600px;">Variant Produk</th>
		<th style="text-align:center; width:600px;">Link</th>
		<?php
		  if($_SESSION["hak_akses"] == 'Administrator' || $_SESSION["hak_akses"] == 'Accounting' || $_SESSION["hak_akses"] == 'Editor') {
		?>
		<th style="text-align:center;" colspan="2">Actions</th>
		<?php } ?>
	</tr>
<?php
	$sku 	 = $_GET['sku'];
	$ekom 	 = $_GET['ecomm'];
	$no		 = 0;
	$query   = mysql_query("SELECT * FROM tb_link WHERE kode_produk = '".$sku."' AND kode_ecomm = '".$ekom."'");
	// $link = mysql_fetch_array($query);
		$produk = mysql_fetch_array(mysql_query("SELECT kode_produk, judul_produk, link_produk FROM tb_pricelist WHERE kode_produk = '{$sku}'"));
		$sku_w = $produk['kode_produk'];

		$link_web_fp = mysql_fetch_array(mysql_query("SELECT kode_produk, link_fp FROM tb_link_website WHERE kode_produk = '{$sku_w}'"));
		
	// echo "<pre>";
	// print_r ($ekom);
	// echo "</pre>";
	// exit;
	if($ekom == 25){ ?>
	<tr>
		<td><input class="c_link" type="checkbox" name="" data-id="" onclick="centang_tunggal(this)" id=""></td>
		<td class="active"><strong><em>Link FastPrint</em></strong></td>
		<td id='link-web-shopify' class="editWeb-<?php echo $produk['kode_produk']; ?>" id="show-<?php echo $produk['kode_produk']; ?>">
			<?php
				$link_fp =  (stristr($produk['link_produk'], "http://")) ? $produk['link_produk'] : "http://".$produk['link_produk'];
				echo "<a href='$link_fp' title='$link_fp' target='_blank'>".rapiLink($link_fp)."</a> <br/>";
			?>

			<?php
				// $link_web =  (stristr($link_web_fp['link_fp'], "http://")) ? $link_web_fp['link_fp'] : "http://".$link_web_fp['link_fp'];
				// echo "<br/><a href='$link_web' title='$link_web' target='_blank'>".rapiLink($link_web)."</a>";
			?>
		</td>
		<?php
		  if($_SESSION["hak_akses"] == 'Administrator' || $_SESSION["hak_akses"] == 'Accounting' || $_SESSION["hak_akses"] == 'Editor') {
		?>
		<td class="editWeb-<?php echo $produk['kode_produk']; ?>">
		  <a href="#" onclick="showEditWeb(this.id);" id="<?php echo $produk['kode_produk']; ?>" class="edit btn btn-sm btn-info">
			  <i class="glyphicon glyphicon-pencil"></i>&emsp;Edit
		  </a>
		</td>
		<td class="editWeb-<?php echo $produk['kode_produk']; ?>">
		  <a href="#" id="<?php echo $produk['kode_produk']; ?>" class="deleteWeb btn btn-sm btn-danger">
			  <i class="glyphicon glyphicon-trash"></i>&emsp;Hapus
		  </a>
		</td>
		<?php } ?>

			<td style="display:none;" class="editBoxWeb-<?php echo $produk['kode_produk']; ?>" width="700px">
			<input type="text" class="form-control input-sm" id="links-<?php echo $produk['kode_produk']; ?>" name="links" value="<?php echo $produk['link_produk']; ?>" /></td>
			<td style="display:none;" class="editBoxWeb-<?php echo $produk['kode_produk']; ?>" align="center"><a href="#" class="simpanLinkWeb btn btn-info btn-sm" id="<?php echo $produk['kode_produk']; ?>"><i class="glyphicon glyphicon-floppy-disk"></i>&emsp;Simpan </a></td>
			<td style="display:none;" class="editBoxWeb-<?php echo $produk['kode_produk']; ?>" align="center"><a href="#" class="simpanLinksemuaWeb btn btn-info btn-sm" id="<?php echo $produk['kode_produk']; ?>"><i class="glyphicon glyphicon-floppy-disk"></i>&emsp;Simpan semua ecomm</a></td>
	</tr>    
	<?php }else {
	$txtLInk = "";
	while($link = mysql_fetch_array($query)){
		
		$no++;
    	$link_url_ol	= $link['link_produk'];
		$arr   	  = preg_split($regex_toko, $link_url_ol, -1, PREG_SPLIT_DELIM_CAPTURE);
    	$toko  	  = preg_match($regex_toko,$link_url_ol,$match);
		$link_1   = $match[0];
		$link_2   = $arr[1];
    	$txtLInk .= "http://$link_1$link_2 \n";
	?>
	<tr>
		<td class="c_hapus-<?php echo $link['id_link']; ?>"><input class="c_link" type="checkbox" name="" data-id="<?=$link['id_link']?>" onclick="centang_tunggal(this)" id=""></td>
    	<td class="c_hapus-<?php echo $link['id_link']; ?>">    	
			<label id="var-prod-<?php echo $link['id_link']; ?>"><?php echo $link['nama_varian'];?></label>
			<label style="display:none;" id="kode-prod-<?php echo $link['id_link']; ?>"><?php echo $link['kode_produk'];?></label>
			<input style="display:none;" type="text" class="form-control input-sm" id="varian-pro-<?php echo $link['id_link']; ?>" name="varians" value="<?php echo $link['nama_varian']; ?>" /></td>
		</td>
		<td class="edit-<?php echo $link['id_link']; ?>" id="show-<?php echo $link['id_link']; ?>">
			<?php
				$link_fp =  (stristr($link['link_produk'], "http://")) ? $link['link_produk'] : "http://".$link['link_produk'];
				//echo "<a href='$link_fp' title='$link_fp' target='_blank'>".rapiLink($link_fp)."</a>";
                $links = rapiLink("http://$link_1$link_2");
				//Utk handle url tiktok
				if($link_1 == 'shop.tiktok'){
					echo "<a href='http://$link_1$link_2' title='$link_fp' target='_blank'> http://$link_1$link_2</a>";
				}else{
					echo "<a href='http://$link_1$link_2' title='$link_fp' target='_blank'> ".$links."</a>";
				}
			?>
		</td>
		<?php
		  if($_SESSION["hak_akses"] == 'Administrator' || $_SESSION["hak_akses"] == 'Accounting' || $_SESSION["hak_akses"] == 'Editor') {
		?>
		<td class="edit-<?php echo $link['id_link']; ?>">
		  <a href="#" onclick="showEdit(this.id);" id="<?php echo $link['id_link']; ?>" class="edit btn btn-sm btn-info">
			  <i class="glyphicon glyphicon-pencil"></i>&emsp;Edit
		  </a>
		</td>
		<td class="edit-<?php echo $link['id_link']; ?>">
		  <a href="#" id="<?php echo $link['id_link']; ?>" class="delete btn btn-sm btn-danger">
			  <i class="glyphicon glyphicon-trash"></i>&emsp;Hapus
		  </a>
		</td>
		<?php } ?>
			<td style="display:none;" class="editBox-<?php echo $link['id_link']; ?>" width="700px">
			<input type="text" class="form-control input-sm" id="links-<?php echo $link['id_link']; ?>" name="links" value="<?php echo $link['link_produk']; ?>" /></td>
			<td style="display:none;" class="editBox-<?php echo $link['id_link']; ?>" align="center"><a href="#" class="simpanLink btn btn-info btn-sm" id="<?php echo $link['id_link']; ?>"><i class="glyphicon glyphicon-floppy-disk"></i>&emsp;Simpan </a></td>
			<td style="display:none;" class="editBox-<?php echo $link['id_link']; ?>" align="center"><a href="#" class="simpanLinksemua btn btn-info btn-sm" id="<?php echo $link['id_link']; ?>"><i class="glyphicon glyphicon-floppy-disk"></i>&emsp;Simpan semua ecomm</a></td>

	</tr>
	<?php } } ?>


</table>
<textarea style='display:none' id='copyINIYAA'><?=$txtLInk?></textarea>
<script type="text/javascript">
	$(document).ready(function(){
		
	})
	function showEdit(id){
		//~ alert(id);
		$('.edit-'+id).hide();
		$('.editBox-'+id).show();
    	$('#var-prod-'+id).hide();
		$('#varian-pro-'+id).show();
	}

	function showEditWeb(id) {
		$('.editWeb-'+id).hide();
		$('.editBoxWeb-'+id).show();
    	$('#var-prod-'+id).hide();
		$('#varian-pro-'+id).show();
	}
	
	$('.simpanLink').bind('click', function() {
		var id 			= this.id;
		var url_update 	= "input.link.php";
		var links		= $('#links-'+id).val();
    	var varian      = $('#varian-pro-'+id).val();
		
		$.post(url_update, {
			id_link	: id,
			links   : links,
        	varians : varian
        	}, function(response) {
				switch(response){
                    case 'updated' : alert("Data Link dan Variant berhasil di ubah.. !"); break;
                    case 'failed' : alert("Terjadi kesalahan saat simpan data !"); break;
                    default: console.log(response);
                }
				$('.editBox-'+id).hide();
				$('#varian-pro-'+id).hide();
				$('#show-'+id).text(links);
				$('#var-prod-'+id).text(varian);
				$('#var-prod-'+id).show();
				$('.edit-'+id).show();
		});
	});
	$('.simpanLinksemua').bind('click', function() {
		var id 			= this.id;
		var url_update 	= "input.link.php";
		var links		= $('#links-'+id).val();
    	var varian      = $('#varian-pro-'+id).val();
    	var kode_produk = $('#kode-prod-'+id).text();
		var status		= "simpanLinksemua";
		
		$.post(url_update, {
			id_link	: id,
			links   : links,
        	varians : varian,
			kode_produk : kode_produk,
			status : status,
			
        	}, function(response) {
				switch(response){
                    case 'updated' : alert("Data Link dan Variant berhasil di ubah.. !"); break;
                    case 'failed' : alert("Terjadi kesalahan saat simpan data !"); break;
                    default: console.log(response);
                }
				$('.editBox-'+id).hide();
				$('#varian-pro-'+id).hide();
				$('#show-'+id).text(links);
				$('#var-prod-'+id).text(varian);
				$('#var-prod-'+id).show();
				$('.edit-'+id).show();
		});
	});

	$('.simpanLinkWeb').bind('click', function() {
		var id 			= this.id;
		var url_update 	= "input.link.php";
		var links		= $('#links-'+id).val();
    	var varian      = $('#varian-pro-'+id).val();
		
		$.post(url_update, {
			id_link	: id,
			links   : links,
        	varians : varian
        	}, function(response) {
				switch(response){
                    case 'updated' : alert("Data Link dan Variant berhasil di ubah.. !"); break;
                    case 'failed' : alert("Terjadi kesalahan saat simpan data !"); break;
                    default: console.log(response);
                }
				$('.editBoxWeb-'+id).hide();
				$('#varian-pro-'+id).hide();
				$('#show-'+id).text(links);
				$('#var-prod-'+id).text(varian);
				$('#var-prod-'+id).show();
				$('.editWeb-'+id).show();
		});
	});
	$('.simpanLinksemuaWeb').bind('click', function() {
		var id 			= this.id;
		var url_update 	= "input.link.php";
		var links		= $('#links-'+id).val();
    	var varian      = $('#varian-pro-'+id).val();
    	var kode_produk = $('#kode-prod-'+id).text();
		var status		= "simpanLinksemuaWeb";
		
		$.post(url_update, {
			id_link	: id,
			links   : links,
        	varians : varian,
			kode_produk : kode_produk,
			status : status,
			
        	}, function(response) {
				switch(response){
                    case 'updated' : alert("Data Link dan Variant berhasil di ubah.. !"); break;
                    case 'failed' : alert("Terjadi kesalahan saat simpan data !"); break;
                    default: console.log(response);
                }
				$('.editBoxWeb-'+id).hide();
				$('#varian-pro-'+id).hide();
				$('#show-'+id).text(links);
				$('#var-prod-'+id).text(varian);
				$('#var-prod-'+id).show();
				$('.editWeb-'+id).show();
		});
	});

	$('.delete').bind('click', function() {
		var id 			= this.id;
		var url_delete 	= "input.link.php";
		var status		= "hapus";
		
		if(confirm('Yakin link ini dihapus ?')){
			$.post(url_delete, {
				id_link	: id,
				stat	: status}, function(response) {
					switch(response){
						case 'deleted' : alert("Data Link dan variant berhasil di hapus.. !"); break;
						case 'failed' : alert("Terjadi kesalahan saat simpan data !"); break;
						default: console.log(response);
					}
					//~ $('.editBox-'+id).hide();
					//~ $('#show-'+id).text(links);
					$('#var-prod-'+id).hide();
					$('.edit-'+id).hide();
			});

			var url = "aksi_clear_centang.php";
            $.post(url, {
                nama_session : 'c_link'
            } ,function(e) {
                // console.log(e)
                $('#div-info-cek').fadeOut()
            });
		}
 


	});

	$('.deleteWeb').bind('click', function() {
		var id 			= this.id;
		var url_delete 	= "input.link.php";
		var status		= "hapusWeb";
		
		if(confirm('Yakin link ini dihapus ?')){
			$.post(url_delete, {
				id_link	: id,
				stat	: status}, function(response) {
					switch(response){
						case 'deleted' : alert("Data Link dan variant berhasil di hapus.. !"); break;
						case 'failed' : alert("Terjadi kesalahan saat simpan data !"); break;
						default: console.log(response);
					}
					//~ $('.editBox-'+id).hide();
					//~ $('#show-'+id).text(links);
					$('#var-prod-'+id).hide();
					$('.editWeb-'+id).hide();
			});

			var url = "aksi_clear_centang.php";
            $.post(url, {
                nama_session : 'c_link'
            } ,function(e) {
                // console.log(e)
                $('#div-info-cek').fadeOut()
            });
		}
 


	});
	

	function centang_tunggal(e){
		var id = $(e).attr('data-id')
		var stat = e.checked
		var url 	= "aksi_centang.php";
		$.post(url, {
				id	: id,
				stat	: stat
			}, function(res) {
				console.log(res)
				if($.trim(res) == '0'){
					$('#div-info-cek').fadeOut()
				}else{
					$('#div-info-cek').fadeIn()
					$('#jumlah-centang-info').text($.trim(res))
				}
			});
	}
	function centang_all(source){
	
        var checkboxes = document.querySelectorAll('.c_link');

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
				centang_tunggal(checkboxes[i])
        }
    
	}
</script>
