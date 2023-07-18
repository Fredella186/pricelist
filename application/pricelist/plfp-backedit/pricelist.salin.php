<?php
    session_start();
    require 'connect.php';

    // buat koneksi ke database mysql
    buka_koneksi(); 
        $user           = $_SESSION['user'];
        $id_pl          = $_POST['id_pl'];
        $txt_gbr_prod   = $_POST['txt_gbr_prod'];
        $ktg_prod       = $_POST['ktg_prod'];
        $judul_prod     = $_POST['jdl_prod'];
    	$nama_alias     = $_POST['nama_alias'];
        $deskripsi_prod = $_POST['des_prod'];
        $hrg_prod       = $_POST['hrg_prod'];
        $nmr            = count($_POST['Nmr']);
        $qty            = $_POST['Qty'];
        $hrg            = $_POST['Hrg'];
        $harga_up_blanja= $_POST['up_blanja'];
        $harga_up_bhinn = $_POST['up_bhinn'];
        $harga_up_elv	= $_POST['up_elv'];
        $harga_up_mm	= $_POST['up_mm'];
        $harga_up_lzd	= $_POST['up_lzd'];
        $berat_prod     = $_POST['brt_prod'];
        $dimensi_prod   = $_POST['dmnsi_prod'];
        $link_prod      = $_POST['link_prod'];
        $kode_prod      = $_POST['kd_prod'];
        $id             = $_POST['id'];
    	$kode_lama      = $_POST['kd_lama'];
    	$link_web_fp    = $_POST['lk_web'];

        // validasi agar tidak ada data yang kosong
        // if ($judul_prod != "" && $kode_prod != "") {
        
        	 if($kode_prod != ""){
               $itemCount = 0;
               $sql = "INSERT INTO tb_wholesale (id_produk, rentang_qty, harga_wholesale) VALUES ";
               $values = "";
                for($i=0;$i<=$nmr;$i++){
                   if(!empty($qty[$i]) || !empty($hrg[$i])){
                      $itemCount++;
                      if($values != "")
                          $values .= ",";
                          $values .= "('".$kode_prod."','".$qty[$i]."','".$hrg[$i]."')";
                       }
                   }
                   $query = $sql.$values;

                  if($itemCount != 0)
                    mysql_query($query);
             }
             $now = date('Y-m-d H:i:s');
                $insert_pricelist = "INSERT INTO tb_pricelist (
                    kode_produk,
                    gambar_produk,
                    ktg_produk,
                    judul_produk,
                    nama_alias,
                    deskripsi_produk,
                    harga,
                    up_blanja,
                    up_bhinneka,
                    up_elevenia,
                    up_mm,
                    up_lazada,
                    berat_produk,
                    dimensi_produk,
                    link_produk,
                    input_user,
                    update_user,
                    input_time,
                    update_time,
                    hapus_produk, status_view) VALUES(
                    '".$kode_prod."',
                    '".$txt_gbr_prod."',
                    '".$ktg_prod."',
                    '".$judul_prod."',
                    '".$nama_alias."',
                    '".$deskripsi_prod."',
                    '".$hrg_prod."',
                    '".$harga_up_blanja."',
                    '".$harga_up_bhinn."',
                    '".$harga_up_elv."',
                    '".$harga_up_mm."',
                    '".$harga_up_lzd."',
                    '".$berat_prod."',
                    '".$dimensi_prod."',
                    '".$link_prod."',
                    '$user',
                    '$user',
                    '$now',
                    '$now',
                    '0', 1)";
                // var_dump($insert_pricelist);
                $stat = 0 ;
                mysql_query($insert_pricelist) or die ($stat = 1);
                
            	if ($link_web_fp !== ""){
					$tambah_lk = "INSERT INTO tb_link_website (kode_produk, link_fp) VALUES ('".$kode_prod."', '".$link_web_fp."')";
					mysql_query($tambah_lk) or die ($stat = 1);
				}
                

    tutup_koneksi();