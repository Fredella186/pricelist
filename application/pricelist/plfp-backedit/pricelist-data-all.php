<?php
    session_start();
    // panggil berkas koneksi.php
    require 'connect.php';
    //print_r($_SESSION);   
    $iiiiii = "style='display:block'";
    if($_SESSION['user'] !== 'test-it'){
        $iiiiii = "style='display:none'";
 
    }

    echo '<b>Hi '.$_SESSION['user']."</b> <p id='btn-proses'  $iiiiii>";
    echo "<div > <input type='checkbox' onclick='Produkkosong(this)' {$_SESSION['produk-kosong2']}> <b>Produk Kosong</b> </div>";

    // dia akses toko apa tidak 
    $table_stok = '';
    if($_SESSION['toko'] !== 'pusat' && $_SESSION['toko'] !== null){
        $table_stok = "_".$_SESSION['toko'];
    }


    // cek dia punya akses ubah tidak 
    $akses_btn = ($_SESSION['menu_toko'] == 1)?'ganti_stok(this)':'';


    // buat koneksi ke database mysql
    buka_koneksi();
?> 
<div class="table-responsive">
  <table class="table table-striped table-hover table-bordered" cellpadding="0" cellspacing="0">
      <thead>
      <tr class="success">
            

          <th style="text-align:center;">#</th>
          <th style="text-align:center;">Gambar</th>
          <th style="text-align:center; width:300px;">Judul</th>
          <th style="text-align:center;">Kategori</th>
          <th style="text-align:center;">Stok Pusat</th>
          <th style="text-align:center;">Stok JKT</th>
          <th style="text-align:center;">Stok BDG</th>
		  <th style="text-align:center;">Link</th>
      </tr>
      </thead>
      <tbody>
      <?php

          function highlightWords($produk, $cari){
  
              // $cariArr = explode(" ",$cari);
  
              $keywords = explode(' ', trim($cari));
              return $str = preg_replace('/'.implode('|', $keywords).'/i', '<b style="color:black;background:#FF9632; text-transform: uppercase;">$0</b>', $produk);
          
          }


          $where_stok_toko = '';
          if($_SESSION['produk-kosong2'] == 'checked'){
              $where_stok_toko = ' AND (stok = 0 or stok_jkt = 0 or stok_bdg = 0)';
          }

          $i = 1;
          $jml_per_halaman = 20; // jumlah data yg ditampilkan perhalaman
          $jml_data = mysql_num_rows(mysql_query("SELECT * FROM tb_pricelist WHERE status_view=1 ". $where_stok_toko." ORDER BY update_time DESC "));
          $jml_halaman = ceil($jml_data / $jml_per_halaman);
          // query pada saat mode pencarian
          if(isset($_POST['cari'])) {   
            $kunci = $_POST['cari'];
            // $expl_kunci = explode("-", $kunci);
            // $empl_kunci = implode("", $expl_kunci);
            if(ctype_digit($kunci)){
                $query = mysql_query("
                    SELECT * FROM tb_pricelist WHERE status_view=1 AND 
                    kode_produk LIKE '%".$kunci."%' ". $where_stok_toko." ORDER BY update_time DESC");
                $jml = mysql_num_rows($query);
            } else {
              	$filter = (strpos('"', $kunci) === false) ? explode(' ', $kunci) : array(str_replace('"', '', $kunci));
              	$sqlf = "SELECT * FROM tb_pricelist WHERE status_view=1 AND (judul_produk LIKE '%" . mysql_real_escape_string($filter[0]) . "%')";
              	for ($a = 1; $a < sizeof($filter); $a++) {
                    $sqlf .= " AND (judul_produk LIKE '%" . mysql_escape_string($filter[$a]) . "%')";
                }
              	$sqlf .= $where_stok_toko."ORDER BY update_time DESC";
              	//var_dump($sqlf);
                $query = mysql_query($sqlf);
              	// console.log($query);
                $jml = mysql_num_rows($query);
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
                  AND ktg_produk = '".$ktg."'". $where_stok_toko);
          }
          // query jika nomor halaman sudah ditentukan
          else if(isset($_POST['halaman'])) {
              $halaman = $_POST['halaman'];
              $i = ($halaman - 1) * $jml_per_halaman  + 1;
              $kat = (isset($_POST['kategori']) && $_POST['kategori']!=='')?" AND ktg_produk = '".$_POST['kategori']."'":"";
            
              $query = mysql_query("SELECT * FROM tb_pricelist WHERE status_view=1 ". $where_stok_toko.$kat." ORDER BY update_time DESC LIMIT ".(($halaman - 1) * $jml_per_halaman).", $jml_per_halaman");
          // query ketika tidak ada parameter halaman maupun pencarian
          } else {
              $kat = (isset($_POST['kategori']) && $_POST['kategori']!=='')?" AND ktg_produk = '".$_POST['kategori']."'":"";
            
              $query = mysql_query("SELECT * FROM tb_pricelist WHERE status_view=1 ". $where_stok_toko.$kat." ORDER BY update_time DESC LIMIT 0, $jml_per_halaman");
              $halaman = 1; //tambahan
          }
          // tampilkan data pricelist selama masih ada
          while($data = mysql_fetch_array($query))
          {
        ?>
              <tr>
                  <td style="text-align:center;"><?php echo $i; ?></td>
                  <td>
                      <a class="image-popup-no-margins" href="<?php echo IMG_PATH . $data['gambar_produk']; ?>"><img src="<?php echo IMG_PATH . $data['gambar_produk']; ?>" style="width:70px; height:70px;" /></a>
                  </td>
                  <td><a href="#" style="text-decoration:none;color:black;" data-toggle="tooltip" title="<?php echo $data['deskripsi_produk']; ?>">
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
                  <td>
                      <?php
                          $dataKtg = mysql_fetch_array(mysql_query("SELECT * FROM tb_kategori WHERE id_ktg = '".$data['ktg_produk']."'"));
                          echo $dataKtg['nama_ktg'];
                      ?>
                  </td>
             <!-- <td><button class='btn <?=($data['stok']=='1')?'btn-primary':'btn-danger'?>' data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok'.$table_stok];?>" data-id="<?=$data['kode_produk'];?>" data-toko="<?=$_SESSION['toko'];?>" data-sku="<?=$data['kode_produk']?>" ><?=($data['stok'.$table_stok]=='1')?'Ready':'Kosong'?></button></td>                  
                  <td><button class='btn <?=($data['stok_jkt']=='1')?'btn-primary':'btn-danger'?>'  data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok'];?>" data-id="<?=$data['kode_produk'];?>" ><?=($data['stok']=='1')?'Ready':'Kosong'?></button></td>
                  <td><button class='btn <?=($data['stok_bdg']=='1')?'btn-primary':'btn-danger'?>'  data-nama='<?=$data['judul_produk'];?>' data-stok="<?=$data['stok'];?>" data-id="<?=$data['kode_produk'];?>" ><?=($data['stok']=='1')?'Ready':'Kosong'?></button></td> -->
                  <td style="text-align:center;"><?=($data['stok']=='1')?"<b style='color:blue'>READY</b>":"<b style='color:red'>KOSONG</b>"?></td>                  
                  <td style="text-align:center;"><?=($data['stok_jkt']=='1')?"<b style='color:blue'>READY</b>":"<b style='color:red'>KOSONG</b>"?></td>
                  <td style="text-align:center;"><?=($data['stok_bdg']=='1')?"<b style='color:blue'>READY</b>":"<b style='color:red'>KOSONG</b>"?></td>
                  <td><a href="#dialog-link" id="<?php echo $data['kode_produk']; ?>" class="links" data-toggle="modal">Klik</a></td>
                
              </tr>
      <?php
              $i++;
          }
      ?>
    </tbody>
  </table>
</div>


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
<script type="text/javascript">

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
            placement : 'bottom'
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

    var main = "pricelist-data-all.php";
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
                // tampilkan pricelist.form.php ke dalam <div class="modal-body"></div>
                $(".modal-body").html(data).show();
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
       console.log(event.target)
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

</script>
<?php
    // tutup koneksi ke database mysql
    tutup_koneksi();
?>