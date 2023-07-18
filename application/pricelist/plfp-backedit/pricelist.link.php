<?php
	session_start();
    // panggil file koneksi.php
    require 'connect.php';

    // buat koneksi ke database mysql
    buka_koneksi();
	
	
    // tangkap variabel kode link
    $kd_pl = $_POST['kode_pl'];
    $sku = "";	


	if(!isset($_SESSION['hak_akses'])){
        echo '<script>location.href = "http://pcls.fastprint.co.id/plfp-backedit/login.php"</script>';
        exit;
    }
?>
<br />

<style>
#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
/* kode warna untuk masing masing cabang di input link */
.SBY {
	background-color: darkorange;
	color: #fff;
}
.JKT {
	background-color: darkred;
	color: #fff;
}
.BDG {
	background-color: darkblue;
	color: #fff;
}
.MKS {
	background-color: darkgreen;
	color: #fff;
}
.MDN {
	background-color: grey;
	color: #fff;
}
.BKS {
	background-color: #5F9EA0;
	color: #fff;
}
</style>

<div id="snackbar">Link Tercopy...</div>

<table align="center" style="width: 98%;" class="table table-hover table-bordered" cellpadding="0" cellspacing="0">
	<?php
		$produk = mysql_fetch_array(mysql_query("SELECT kode_produk, judul_produk, link_produk FROM tb_pricelist WHERE kode_produk = '{$kd_pl}'"));
		$sku = $produk['kode_produk'];

		$link_web_fp = mysql_fetch_array(mysql_query("SELECT kode_produk, link_fp FROM tb_link_website WHERE kode_produk = '$kd_pl'"));

	?>
	<tr>
		<td class="active"><strong><em>Nama Produk</em></strong></td>
		<td class="active">:</td>
		<td class=""><strong><?php echo $produk['judul_produk']; ?></strong></td>
	</tr>
	<tr>
		<td class="active"><strong><em>SKU</em></strong></td>
		<td class="active">:</td>
		<td><strong><?php echo $produk['kode_produk']; ?></strong></td>
	</tr>
	<tr style="display:none">
		<td class="active"><strong><em>Link FastPrint</em></strong></td>
		<td class="active">:</td>
		<td>
			<?php
				$link_fp =  (stristr($produk['link_produk'], "http://")) ? $produk['link_produk'] : "http://".$produk['link_produk'];
				echo "<a href='$link_fp' title='$link_fp' target='_blank'>".rapiLink($link_fp)."</a> <br/>";
			?>

			<?php
				$link_web =  (stristr($link_web_fp['link_fp'], "http://")) ? $link_web_fp['link_fp'] : "http://".$link_web_fp['link_fp'];
				echo "<br/><a href='$link_web' title='$link_web' target='_blank'>".rapiLink($link_web)."</a>";
			?>
		</td>
	</tr>    
</table>
<div class="container col-md-12">
	<h4><em>List Link :   <button type='button' id="bukalink" class='btn btn-info btn-sm' onclick="buka_semua_link('<?php echo $produk['kode_produk']; ?>')" >Buka Semua Link</button>
	<select placeholder="Pilih Lokasi" id="lokasi" class='form-select select-sm' name="company_id" onchange="filter_company_ini(this.value)">
            <option value="" selected="selected"><--Pilih Cabang--></option>
            <option value="SBY">SBY</option>
            <option value="JKT">JKT</option>
            <option value="BDG">BDG</option>
            <option value="BKS">BKS</option>
            <option value="MKS">MKS</option>
            <option value="MDN">MDN</option>
	</select>
	
	</em> </h4>
		<ul class="nav nav-tabs">
			<?php
			// bagian tambah cabang ecomm
				$result = mysql_query("SELECT * FROM tb_ecommerce");
                while ($row = mysql_fetch_object($result)) {
                    //echo $row->id_ecomm[1];
                }
				// $qTabs 	= mysql_query("SELECT * FROM tb_ecommerce where urutan != 0 order by urutan asc");				
				// while($tabs = mysql_fetch_array($qTabs)){
				// 	echo "<li><a data-toggle='tab' class='link_ecomm ALL' id='".$tabs['id_ecomm']."' href='#link".$tabs['id_ecomm']."'>".$tabs['nama_ecomm']."</a></li>"; 
                //   	//var_dump($tabs['id_ecomm']);
				// }
				

				// JAWA
				
				$qTabsSby 	= mysql_query("SELECT * FROM tb_ecommerce where nama_ecomm like '%SBY' order by urutan asc");
				// echo "<li><a data-toggle='tab' class='link_ecomm SBY' id='' href='#link".$tabs['id_ecomm']."'>WEB</a></li>"; 			
				while($tabs = mysql_fetch_array($qTabsSby)){
					echo "<li><a data-toggle='tab' class='link_ecomm SBY' id='".$tabs['id_ecomm']."' href='#link".$tabs['id_ecomm']."'>".$tabs['nama_ecomm']."</a></li>"; 
                  	//var_dump($tabs['id_ecomm']);
				}

				$qTabsJkt 	= mysql_query("SELECT * FROM tb_ecommerce where nama_ecomm like '%JKT' order by urutan asc");
												
				while($tabs = mysql_fetch_array($qTabsJkt)){
					echo "<li><a data-toggle='tab' class='link_ecomm JKT' id='".$tabs['id_ecomm']."' href='#link".$tabs['id_ecomm']."'>".$tabs['nama_ecomm']."</a></li>"; 
                  	//var_dump($tabs['id_ecomm']);
				}

				$qTabsBdg 	= mysql_query("SELECT * FROM tb_ecommerce where nama_ecomm like '%BDG' order by urutan asc");
												
				while($tabs = mysql_fetch_array($qTabsBdg)){
					echo "<li><a data-toggle='tab' class='link_ecomm BDG' id='".$tabs['id_ecomm']."' href='#link".$tabs['id_ecomm']."'>".$tabs['nama_ecomm']."</a></li>"; 
                  	//var_dump($tabs['id_ecomm']);
				}

				$qTabsBks = mysql_query("SELECT * FROM tb_ecommerce where nama_ecomm like '%BKS%' order by urutan asc");

				while($tabs = mysql_fetch_array($qTabsBks)){
					echo "<li><a data-toggle='tab' class='link_ecomm BKS' id='".$tabs['id_ecomm']."' href='#link".$tabs['id_ecomm']."'>".$tabs['nama_ecomm']."</a></li>";
				}

				//LUAR JAWA

				$qTabsMks 	= mysql_query("SELECT * FROM tb_ecommerce where nama_ecomm like '%MKS' order by urutan asc");
												
				while($tabs = mysql_fetch_array($qTabsMks)){
					echo "<li><a data-toggle='tab' class='link_ecomm MKS' id='".$tabs['id_ecomm']."' href='#link".$tabs['id_ecomm']."'>".$tabs['nama_ecomm']."</a></li>"; 
                  	//var_dump($tabs['id_ecomm']);
				}

				$qTabsMdn 	= mysql_query("SELECT * FROM tb_ecommerce where nama_ecomm like '%MDN' order by urutan asc");
												
				while($tabs = mysql_fetch_array($qTabsMdn)){
					echo "<li><a data-toggle='tab' class='link_ecomm MDN' id='".$tabs['id_ecomm']."' href='#link".$tabs['id_ecomm']."'>".$tabs['nama_ecomm']."</a></li>"; 
                  	//var_dump($tabs['id_ecomm']);
				}
				
			?>
	  </ul>

	<div class="tab-content">
		<?php
			$qEcomm 	= mysql_query("SELECT * FROM tb_ecommerce ");			
			while($ecomm = mysql_fetch_array($qEcomm)){
            
		?>

		<div id="link<?php echo $ecomm['id_ecomm']; ?>" class="tab-pane fade">
			<div style="width: 800px; margin: 0 auto;">
				<?php
				  if(1) { ?>
					<a href="#" id="<?php echo $ecomm['id_ecomm']; ?>" class="tambahLink btn btn-info btn-sm" role="button" <?=($_SESSION["hak_akses"] == 'User Biasa')?"style='display:none'":""?>>
						<i class="glyphicon glyphicon-plus-sign"></i>&emsp;Tambah Link dan Variant
					</a>
				
					<button type='button' class='btn btn-danger btn-sm' onclick="buka_semua()" >Buka Semua Link</button>
					<button type="button" class='btn btn-primary btn-sm' onclick="copy_allLink('<?php echo $ecomm['id_ecomm']?>')">Copy Semua Link</button>
					<button type="button" class='btn btn-sm' style="background-color:red;color:white" onclick="hapus_yang_dicentang()">Hapus Dicentang</button>
					<textarea class='form-control' id='txt-ygcopy-<?php echo $ecomm['id_ecomm']?>' style="display:none;margin-top:10px"></textarea>
					<div id="addLink<?php echo $ecomm['id_ecomm']; ?>" style="display: none;">
						<br />
						<form id="formLink" class="form-horizontal" method="POST" action="#">
							<table id="tbl_link" class="table table-bordered">
								<tr>
	<!--
									<td align="center"><input type="checkbox" name="cbLink"/></td>
	-->
									<td width="100px">									
										<input type="hidden" id="sku<?php echo $ecomm['id_ecomm']; ?>" class name="sku" value="<?php echo $produk['kode_produk']; ?>"/>
										<input type="hidden" id="kode_ecomm<?php echo $ecomm['id_ecomm']; ?>" class="ekom" name="kode_ecomm" value="<?php echo $ecomm['id_ecomm']; ?>"/>
										<input type="text" class="form-control input-sm" id="links<?php echo $ecomm['id_ecomm']; ?>" name="links" placeholder="Link <?php echo $ecomm['nama_ecomm']; ?>" />
									
									</td>
									<td width="200px">
										<input type="hidden" id="var-sku<?php echo $ecomm['id_ecomm']; ?>" class name="sku" value="<?php echo $produk['kode_produk']; ?>"/>
										<input type="hidden" id="kode_ecomm<?php echo $ecomm['id_ecomm']; ?>" class="ekom" name="kode_ecomm" value="<?php echo $ecomm['id_ecomm']; ?>"/>
										<input type="text" class="form-control input-sm" id="variaan<?php echo $ecomm['id_ecomm']; ?>" name="varians" placeholder="Variant <?php echo $ecomm['nama_ecomm']; ?>" />
									</td>
									<td align="center"><a href="#" class="btnSaveLink btn btn-info btn-sm" id="<?php echo $ecomm['id_ecomm']; ?>"><i class="glyphicon glyphicon-floppy-disk"></i>&emsp;Simpan</a></td>
	<!--
									<td align="center"><button type="button" class="btn btn-info btn-sm" name="submitLinks"><i class="glyphicon glyphicon-floppy-disk"></i>&emsp;Simpan</button></td>
	-->
								</tr>
							</table>
						</form>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php } ?>
		
		<div style="width: 800px; margin: 10px auto;">
			<div id="load-links"></div>
		</div>
	</div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js" async></script>
<script type="text/javascript">	
	// debugger;
	var sku = "<?php echo $sku; ?>";


	$('.link_ecomm').click(function(){
		$('#load-links').unload();
		var ecomm = this.id;
		var links = "data.link.php?ecomm="+ecomm+"&sku="+sku;
		//~ console.log(links);
		$('#load-links').load(links);

		var url = "aksi_clear_centang.php";
        $.post(url, {
            nama_session : 'c_link'
        } ,function(e) {
            // console.log(e)
            $('#div-info-cek').fadeOut()
        });
	});
	
	$('.tambahLink').click(function(){
		var id = this.id;
		$('#addLink'+id).slideToggle();
	});

	$('.btnSaveLink').bind('click', function(){	
		var input_link 	= "input.link.php";	
		var id 			= this.id;
		
		var kode_produk	= $('#sku'+id).val();
		var kode_ecomm 	= $('#kode_ecomm'+id).val();
		var links 		= $('#links'+id).val();
		var data_links 	= "data.link.php?ecomm="+kode_ecomm+"&sku="+kode_produk;
        var data_varian = $('#variaan'+id).val();
		
		$.post(input_link, {
			sku    		: kode_produk,
			kd_ecomm	: kode_ecomm,
			links     	: links,
        	varians		: data_varian
            }, function(response) {
				switch(response){
                    case 'inserted' : alert("Data Link dan Variant baru berhasil ditambahkan.. !"); break;
                    case 'failed' : alert("Terjadi kesalahan saat simpan data !"); break;
                    default: console.log(response);
                }
				//~ location.reload();
				$('#load-links').load(data_links);
		});
	});

	function buka_semua(){
    	
      if(confirm("Anda yakin?")){
   		 document.querySelectorAll("td[id^='show']>a").forEach(e=>{

   			 window.open(e.href, '_blank');


		});
      }
    
    }

   	function copy_allLink(e){
    	// new Clipboard('#copy-button');
    	console.log(e)
   		var txtCopy = "";

			if(e == 25){

				document.querySelectorAll("#link-web-shopify > a").forEach(e=>{
					txtCopy += e.href+" \n";
				});

			}else{
				document.querySelectorAll("td[id^='show']>a").forEach(e=>{
				   txtCopy += e.href+" \n";
			 	});
			}

    		$("#txt-ygcopy-"+e).html(txtCopy);
    	
    
    		if(document.querySelector("#txt-ygcopy-"+e).style.display == "none"){
    	        
            	document.querySelector("#txt-ygcopy-"+e).style.display = "block"
            
            }
    
            document.querySelector("#txt-ygcopy-"+e).select();
			//     		else{
						
			//             	document.querySelector("#txt-ygcopy-"+e).style.display = "none"
						
			//             }
    
            document.execCommand("copy");	
   			setTimeout(()=>{		
            
            		var x = document.getElementById("snackbar");
	     			x.className = "show";
            
           		setTimeout(function(){ 
                		x.className = x.className.replace("show", "");
                }, 1000);
            },1500)
            
   
    }

	function buka_semua_link(e){
		let kota = $("#bukalink").attr('data-kota');
		if(!kota){ 
			$.get('alllink.php?idx='+e, 
			function(link) {
				for(i in link){
					if(link[i] !== 'http://'){
						window.open(link[i], '_blank');
					}
	
				}
			});
		}else{ // link untuk buka percabang
			$.get('alllink.php?idx='+e+'&percab='+kota, 
			function(link) {
				for(i in link){
					if(link[i] !== 'http://'){
						window.open(link[i], '_blank');
					}

				}
			});
		}
	}

	$('#hapus_yg_dicentang').bind('click', function(){	
		console.log('duahdwuahdad')
	});
	function hapus_yang_dicentang(){
		$.get('aksi_hapus_centang.php', 
			function(c) {
				var data = JSON.parse(c)
				// console.log(data)
				data.forEach(id => {
					$('#var-prod-'+id).hide();
					$('.edit-'+id).hide();
				});
			});
	}

	function filter_company_ini(pilihan){
		$("#bukalink").attr('data-kota', pilihan);
		var list = ['ALL', 'SBY', 'JKT', 'BDG', 'MKS', 'MDN', 'BKS']
		$.each(list,function( index, value ) {
			$('.'+value).show()
			if(pilihan != value && pilihan != ''){
				$('.'+value).hide()
			}
		});
	}
</script>
