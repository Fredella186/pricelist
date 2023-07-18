<?php
    session_start();
    require 'connect.php';

    // buat koneksi ke database mysql
    buka_koneksi(); 

    $del = $_POST['del'];
    // proses menghapus data pricelist
    if(isset($del)) {
        mysql_query("DELETE FROM tb_pricelist WHERE kode_produk = '".$del."'") or die (mysql_error());
        mysql_query("DELETE FROM tb_wholesale WHERE id_produk = '".$del."'") or die (mysql_error());
    	mysql_query("DELETE FROM tb_link_website WHERE kode_produk = '".$del."'") or die (mysql_error());
    } else {
        //~ // deklarasikan variabel
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
        $harga_10_prod  = $_POST['hrg10_prod'];
        $harga_up_blanja= $_POST['up_blanja'];
        $harga_up_bhinn = $_POST['up_bhinn'];
        $harga_up_elv	= $_POST['up_elv'];
        $harga_up_mm	= $_POST['up_mm'];
        $harga_up_lzd	= $_POST['up_lzd'];
        $harga_up_bb	= $_POST['up_bb'];
        $berat_prod     = $_POST['brt_prod'];
        $dimensi_prod   = $_POST['dmnsi_prod'];
        $link_prod      = $_POST['link_prod'];
        $kode_prod      = $_POST['kd_prod'];
        $id             = $_POST['id'];
    	$kode_lama      = $_POST['kd_lama'];
    	$link_web_fp    = $_POST['lk_web'];

        // validasi agar tidak ada data yang kosong
        if ($judul_prod != "" && $kode_prod != "") {
        
        	//  if($kode_prod != ""){
            //    $itemCount = 0;
            //    $sql = "INSERT INTO tb_wholesale (id_produk, rentang_qty, harga_wholesale) VALUES ";
            //    $values = "";
            //     for($i=0;$i<=$nmr;$i++){
            //        if(!empty($qty[$i]) || !empty($hrg[$i])){
            //           $itemCount++;
            //           if($values != "")
            //               $values .= ",";
            //               $values .= "('".$kode_prod."','".$qty[$i]."','".$hrg[$i]."')";
            //            }
            //        }
            //        $query = $sql.$values;

            //       if($itemCount != 0)
            //         mysql_query($query);
            //  }
        
            // proses tambah data pricelist
            if ($id_pl == 0 || $id_pl == "") {
                $insert_pricelist = "INSERT INTO tb_pricelist (kode_produk,
                    gambar_produk,
                    ktg_produk,
                    judul_produk,
                    nama_alias,
                    deskripsi_produk,
                    harga,
                    harga_10,
                    up_blanja,
                    up_bhinneka,
                    up_elevenia,
                    up_mm,
                    up_lazada,
                    up_blibli,
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
                    '".$harga_10_prod."',
                    '".$harga_up_blanja."',
                    '".$harga_up_bhinn."',
                    '".$harga_up_elv."',
                    '".$harga_up_mm."',
                    '".$harga_up_lzd."',
                    '".$harga_up_bb."',
                    '".$berat_prod."',
                    '".$dimensi_prod."',
                    '".$link_prod."',
                    '$user',
                    '$user',
                    NOW(),
                    NOW(),
                    '0', 1)";
                // var_dump($insert_pricelist);
                mysql_query($insert_pricelist) or die (mysql_error());

            	if ($link_web_fp !== ""){
					$tambah_lk = "INSERT INTO tb_link_website (kode_produk, link_fp) VALUES ('".$kode_prod."', '".$link_web_fp."')";
					mysql_query($tambah_lk);
				}
                
            } else if($id_pl > 0){
				
                $emailstatus = 0;
                $x = mysql_fetch_array(mysql_query("SELECT * FROM tb_pricelist WHERE status_view=1 AND kode_produk = '".$kode_prod."'"));
                $hrg_lama = $x['harga'];
            	$berat_lama = $x['berat_produk'];
            	$dimensi_lama = $x['dimensi_produk'];
                $gambar_lama = $x['gambar_produk'];
                
            
            	$list_link = mysql_fetch_array(mysql_query("
                    SELECT * FROM tb_link WHERE kode_produk = '".$kode_prod."'"
                    ));
                $link_lama = $list_link['id_link'];
                
				// if($hrg_prod != $hrg_lama || $txt_gbr_prod != $gambar_lama){

                    $j = [];
                    $k = [];
                    $n = 0;

                    $s = mysql_query("SELECT * FROM tb_wholesale WHERE id_produk = '".$kode_prod."'");
                    while($u = mysql_fetch_array($s)){
                        $j[$n] = $u['rentang_qty'];
                        $k[$n] = $u['harga_wholesale'];
                        $qty[$n];
                        $hrg[$n];
                        $n++;
                    }
                    $condition1 = $hrg_prod != $hrg_lama || $txt_gbr_prod != $gambar_lama;
                    $condition2 = $k != $hrg || $j != $qty;
                    switch(true){
                        case $condition1 && $condition2:

                            var_dump($hrg_prod);
                            $notip_baru = "Ada perubahan harga produk Fast Print dengan keterangan sebagai berikut :\n SKU *{$kode_prod}* \n Produk *{$judul_prod}* \n Harga Utama (Lama) *".rupiah($hrg_lama)."* \n Harga Utama (Baru) *".rupiah($hrg_prod)."*";
                            $message = "
                                <html>
                                    <head><title></title></head>
                                    <body>
                                        <h4><strong>Tim FastPrint,</strong></h4>
                                        <p align='justify'>
                                            Ada perubahan harga produk Fast Print dengan keterangan sebagai berikut :
                                        </p>
                                        <table border=0 bordercolor='#069'>
                                            <tr>
                                                <td>SKU</td>
                                                <td>:</td>
                                                <td>".$kode_prod."</td>
                                            </tr>
                                            <tr>
                                                <td>Produk</td>
                                                <td>:</td>
                                                <td>".$judul_prod."</td>
                                            </tr>
                                            <tr>
                                                <td>Harga Utama (Lama)</td>
                                                <td>:</td>
                                                <td>".rupiah($hrg_lama)."</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Harga Utama (Baru)</strong></td>
                                                <td><strong>:</strong></td>
                                                <td style='color:white' bgcolor='#d00'><strong>".rupiah($hrg_prod)."</strong></td>
                                            </tr>
                                        </table>
                                        <br />
                                        <table class='HT' border=0 style='border: 1px solid black;'>
                                                <tr style='background: #ccc;'>
                                                    <th colspan='2'></th>";
                                                for($j=1;$j<=$nmr;$j++) {
                                                    $message .= "<th>Harga Tingkat ".$j."</th>";
                                                }
                                $message .= "</tr>
                                                <tr>
                                                    <td style='background: #ccc;'>Harga Lama</td>
                                                    <td style='background: #ccc;'>:</td>";
                                    $notip_baru .="\n Harga Lama";
                                $a = mysql_query("SELECT * FROM tb_wholesale WHERE id_produk = '".$kode_prod."'");
                                while($b = mysql_fetch_array($a)){
                                    $message .= "<td> Qty : ".$b['rentang_qty']." pcs<br /> ".rupiah($b['harga_wholesale'])."</td>";
                                    $notip_baru .= "\n Qty : ".$b['rentang_qty']." pcs \n ".rupiah($b['harga_wholesale'])."\n";
                                }
            
                                $message .= "</tr>
                                                <tr>
                                                    <td style='background: #ccc;'><strong><font color='#d00'>Harga Baru</font></strong></td>
                                                    <td style='background: #ccc;'><strong>:</strong></td>";
                                $notip_baru .= "\n Harga Baru \n";
                                //rsort($hrg);
                                for($i=0;$i<=$nmr;$i++){
                                    if(!empty($qty[$i]) || !empty($hrg[$i])){
                                        if($hrg[$i] != $k[$i]){
                                            $message .= "<td style='color:white' bgcolor='#d00'><strong> Qty : ".$qty[$i]." pcs<br /> ".rupiah($hrg[$i])."</strong></td>";
                                            $notip_baru .="\n Qty : ".$qty[$i]." pcs \n ".rupiah($hrg[$i]);	
                                        }else{
                                            $message .= "<td> Qty : ".$qty[$i]." pcs<br /> ".rupiah($hrg[$i])."</td>";
                                            $notip_baru .="\n Qty : ".$qty[$i]." pcs \n ".rupiah($hrg[$i]);	
                                        }
                                    }
                                }
                            $message .= "</tr>
                                        </table>
                                    <p align='justify'>
                                        Khusus untuk Team Editor, mohon untuk mengubah data harga produk tersebut sesuai dengan harga baru yang di berikan di atas pada masing - masing
                                        aplikasi E-Commerce Fast Print lewat aplikasi Link Manager yang bisa di akses di
                                        <a href='http://pcls.fastprint.co.id/plfp-backedit/link/' target='blank'>sini</a>
                                        <br/>
                                        <br/>
                                        Terima kasih, <br/>
                                        <p style='color:red; font-size:15px; font-weight:700; background:yellow;'>By: ".strtoupper($_SESSION['user'])."</p>
                                    </p>
                                </body>
                            </html>";
                        
                        
                            $notip_baru .= "\n\n http://pcls.fastprint.co.id/plfp-backedit";
                            $notip_baru .= "\n\n ".date("Y-m-d H:i:s")."\n oleh ".$_SESSION['user'];
                        
                            $mail_to2    = "prog3.fastprintsby@gmail.com";
                            $mail_to    = "sales@fastprint.co.id,
                                        hitechmall@fastprint.co.id,
                                        harco@fastprint.co.id,
                                        editor@fastprint.co.id,
                                        acc5.fastprintsby@gmail.com,
                                        acc2.fastprintsby@gmail.com,
                                        prog5.fastprintsby@gmail.com";
                                        //it.dep@fastprint.co.id";
                            //$cc			= "oasisusb@gmail.com";
                            $cc			= "";
                            $from_name  = "Admin PL Fast Print Indonesia";
                            $from_mail  = "sales@fastprint.co.id";
                            $subj_mail  = "[".strtoupper($_SESSION['user'])."][UPDATE] Harga Utama dan Harga Tingkat Produk FastPrint ".$judul_prod." di Price List";
                            //$kirim = sendMail($mail_to, $from_name, $from_mail, $cc, $subj_mail, $message);
                            //var_dump($kirim);
                            $emailstatus = kirimEmail($subj_mail, $message);
                            
                            kirim_skype($notip_baru);
                            break;

                        case $condition1:

                            var_dump($hrg_prod);
                            $notip_baru = "Ada perubahan harga produk Fast Print dengan keterangan sebagai berikut :\n SKU *{$kode_prod}* \n Produk *{$judul_prod}* \n Harga Utama (Lama) *".rupiah($hrg_lama)."* \n Harga Utama (Baru) *".rupiah($hrg_prod)."*";
                            $message = "
                                <html>
                                    <head><title></title></head>
                                    <body>
                                        <h4><strong>Tim FastPrint,</strong></h4>
                                        <p align='justify'>
                                            Ada perubahan harga produk Fast Print dengan keterangan sebagai berikut :
                                        </p>
                                        <table border=0 bordercolor='#069'>
                                            <tr>
                                                <td>SKU</td>
                                                <td>:</td>
                                                <td>".$kode_prod."</td>
                                            </tr>
                                            <tr>
                                                <td>Produk</td>
                                                <td>:</td>
                                                <td>".$judul_prod."</td>
                                            </tr>
                                            <tr>
                                                <td>Harga Utama (Lama)</td>
                                                <td>:</td>
                                                <td>".rupiah($hrg_lama)."</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Harga Utama (Baru)</strong></td>
                                                <td><strong>:</strong></td>
                                                <td style='color:white' bgcolor='#d00'><strong>".rupiah($hrg_prod)."</strong></td>
                                            </tr>
                                        </table>
                                        <br />
                                        <table class='HT' border=0 style='border: 1px solid black;'>
                                            <tr style='background: #ccc;'>
                                                <th colspan='2'></th>";
                                            for($j=1;$j<=$nmr;$j++) {
                                                $message .= "<th>Harga Tingkat ".$j."</th>";
                                            }
                            $message .= "</tr>
                                            <tr>
                                                <td style='background: #ccc;'>Harga Lama</td>
                                                <td style='background: #ccc;'>:</td>";
                            $a = mysql_query("SELECT * FROM tb_wholesale WHERE id_produk = '".$kode_prod."'");
                            while($b = mysql_fetch_array($a)){
                                $message .= "<td> Qty : ".$b['rentang_qty']." pcs<br /> ".rupiah($b['harga_wholesale'])."</td>";
                                $notip_baru .= "\n Qty : ".$b['rentang_qty']." pcs \n".rupiah($b['harga_wholesale']);
                            }
        
                            $message .= "</tr>
                                            <tr>
                                                <td style='background: #ccc;'><strong><font color='#d00'>Harga Baru</font></strong></td>
                                                <td style='background: #ccc;'><strong>:</strong></td>";
        
                            $notip_baru .= "\n Harga Baru \n";
                        
                            for($i=0;$i<=$nmr;$i++){
                                if(!empty($qty[$i]) || !empty($hrg[$i])){
                                    if($hrg[$i] != $k[$i]){
                                        $message .= "<td style='color:white' bgcolor='#d00'><strong> Qty : ".$qty[$i]." pcs<br /> ".rupiah($hrg[$i])."</strong></td>";
                                        $notip_baru .= "\n Qty : ".$qty[$i]." pcs \n ".rupiah($hrg[$i]);
                                    }else{
                                        $message .= "<td> Qty : ".$qty[$i]." pcs<br /> ".rupiah($hrg[$i])."</td>";
                                        $notip_baru .= "\n Qty : ".$qty[$i]." pcs \n ".rupiah($hrg[$i]);
                                    }
                                } 
                            }
                            $message .= "</tr>
                                        </table>
                                    <p align='justify'>
                                        Khusus untuk Team Editor, mohon untuk mengubah data harga produk tersebut sesuai dengan harga baru yang di berikan di atas pada masing - masing
                                        aplikasi E-Commerce Fast Print lewat aplikasi Link Manager yang bisa di akses di
                                        <a href='http://pcls.fastprint.co.id/plfp-backedit/link/' target='blank'>sini</a>
                                        <br/>
                                        <br/>
                                        Terima kasih, <br/>
                                        <p style='color:red; font-size:15px; font-weight:700; background:yellow;'>By: ".strtoupper($_SESSION['user'])."</p>
                                    </p>
                                </body>
                            </html>";
                        
                        
                            $notip_baru .= "\n\n http://pcls.fastprint.co.id/plfp-backedit";
                            $notip_baru .= "\n\n ".date("Y-m-d H:i:s")."\n oleh ".$_SESSION['user'];
                        
                            $mail_to2    = "prog3.fastprintsby@gmail.com";
                            $mail_to    = "sales@fastprint.co.id,
                                        hitechmall@fastprint.co.id,
                                        harco@fastprint.co.id,
                                        editor@fastprint.co.id,
                                        acc5.fastprintsby@gmail.com,
                                        acc2.fastprintsby@gmail.com,
                                        prog5.fastprintsby@gmail.com";
                                        //it.dep@fastprint.co.id";
                            //$cc			= "oasisusb@gmail.com";
                            $cc			= "";
                            $from_name  = "Admin PL Fast Print Indonesia";
                            $from_mail  = "sales@fastprint.co.id";
                            $subj_mail  = "[".strtoupper($_SESSION['user'])."][UPDATE] Harga Utama Produk FastPrint ".$judul_prod." di Price List";
                            //$kirim = sendMail($mail_to, $from_name, $from_mail, $cc, $subj_mail, $message);
                            //var_dump($kirim);
                            $emailstatus = kirimEmail($subj_mail, $message);
                            
                            kirim_skype($notip_baru);
                            break;

                        case $condition2:
                
                            echo "<pre>";
                            print_r ($k);
                            print_r ('==>');
                            print_r ($hrg);
                            echo "</pre>";
                            
                                $notip_baru = "Ada perubahan harga produk Fast Print dengan keterangan sebagai berikut :\n SKU *{$kode_prod}* \n Produk *{$judul_prod}* \n Harga Utama (Lama) *".rupiah($hrg_lama)."* \n Harga Utama (Baru) *".rupiah($hrg_prod)."*";
                                $message = "
                                    <html>
                                        <head><title></title></head>
                                        <body>
                                            <h4><strong>Tim FastPrint,</strong></h4>
                                            <p align='justify'>
                                                Ada perubahan harga produk Fast Print dengan keterangan sebagai berikut :
                                            </p>
                                            <table border=0 bordercolor='#069'>
                                                <tr>
                                                    <td>SKU</td>
                                                    <td>:</td>
                                                    <td>".$kode_prod."</td>
                                                </tr>
                                                <tr>
                                                    <td>Produk</td>
                                                    <td>:</td>
                                                    <td>".$judul_prod."</td>
                                                </tr>
                                                <tr>
                                                    <td>Harga Utama</td>
                                                    <td>:</td>
                                                    <td>".rupiah($hrg_prod)."</td>
                                                </tr>
                                            </table>
                                            <br />
                                            <table class='HT' border=0 style='border: 1px solid black;'>
                                                <tr style='background: #ccc;'>
                                                    <th colspan='2'></th>";
                                                for($j=1;$j<=$nmr;$j++) {
                                                    $message .= "<th>Harga Tingkat ".$j."</th>";
                                                }
                                $message .= "</tr>
                                                <tr>
                                                    <td style='background: #ccc;'>Harga Lama</td>
                                                    <td style='background: #ccc;'>:</td>";
                                    $notip_baru .="\n Harga Lama";
                                $a = mysql_query("SELECT * FROM tb_wholesale WHERE id_produk = '".$kode_prod."'");
                                while($b = mysql_fetch_array($a)){
                                    $message .= "<td> Qty : ".$b['rentang_qty']." pcs<br /> ".rupiah($b['harga_wholesale'])."</td>";
                                    $notip_baru .= "\n Qty : ".$b['rentang_qty']." pcs \n ".rupiah($b['harga_wholesale'])."\n";
                                }
            
                                $message .= "</tr>
                                                <tr>
                                                    <td style='background: #ccc;'><strong><font color='#d00'>Harga Baru</font></strong></td>
                                                    <td style='background: #ccc;'><strong>:</strong></td>";
                                $notip_baru .= "\n Harga Baru \n";
                                //rsort($hrg);
                                for($i=0;$i<=$nmr;$i++){
                                    if(!empty($qty[$i]) || !empty($hrg[$i])){
                                        if($hrg[$i] != $k[$i]){
                                            $message .= "<td style='color:white' bgcolor='#d00'><strong> Qty : ".$qty[$i]." pcs<br /> ".rupiah($hrg[$i])."</strong></td>";
                                            $notip_baru .="\n Qty : ".$qty[$i]." pcs \n ".rupiah($hrg[$i]);	
                                        }else{
                                            $message .= "<td> Qty : ".$qty[$i]." pcs<br /> ".rupiah($hrg[$i])."</td>";
                                            $notip_baru .="\n Qty : ".$qty[$i]." pcs \n ".rupiah($hrg[$i]);	
                                        }
                                    }
                                }
                                $message .= "</tr>
                                            </table>
                                        <p align='justify'>
                                            Khusus untuk Team Editor, mohon untuk mengubah data harga produk tersebut sesuai dengan harga baru yang di berikan di atas pada masing - masing
                                            aplikasi E-Commerce Fast Print lewat aplikasi Link Manager yang bisa di akses di
                                            <a href='http://pcls.fastprint.co.id/plfp-backedit/link/' target='blank'>sini</a>
                                            <br/>
                                            <br/>
                                            Terima kasih,<br/>
                                            <p style='color:red; font-size:15px; font-weight:700; background:yellow;'>By: ".strtoupper($_SESSION['user'])."</p>
                                        </p>
                                    </body>
                                </html>";
                                $mail_to2    = "prog3.fastprintsby@gmail.com";
                                $mail_to    = "sales@fastprint.co.id,
                                            hitechmall@fastprint.co.id,
                                            harco@fastprint.co.id,
                                            editor@fastprint.co.id,
                                            acc5.fastprintsby@gmail.com,
                                            acc2.fastprintsby@gmail.com, 
                                            prog3.fastprintsby@gmail.com,
                                            prog5.fastprintsby@gmail.com";
            
                                $cc			= "";
                                $from_name  = "Admin PL Fast Print Indonesia";
                                $from_mail  = "sales@fastprint.co.id";
                                $subj_mail  = "[".strtoupper($_SESSION['user'])."][UPDATE] Harga Tingkat Produk FastPrint ".$judul_prod." di Price List";
                                //$kirim = sendMail($mail_to, $from_name, $from_mail, $cc, $subj_mail, $message);
                                //var_dump($kirim);
                                $notip_baru .= "\n\n http://pcls.fastprint.co.id/plfp-backedit";					
                                $notip_baru .= "\n\n ".date("Y-m-d H:i:s")."\n oleh ".$_SESSION['user'];
                            
                                echo kirimEmail($subj_mail, $message);
                                // kirim_skype($notip_baru);
                                break;
                                
                            default:
                                echo "gagal";
                            
                        } 
                   
                // } 
                              	
                $update_pricelist = " UPDATE tb_pricelist SET
                    gambar_produk = '".$txt_gbr_prod."',
                    ktg_produk  = '".$ktg_prod."',
                    judul_produk  = '".$judul_prod."',
                    nama_alias    = '".$nama_alias."',
                    deskripsi_produk  = '".$deskripsi_prod."',
                    up_blanja  = '".$harga_up_blanja."',
                    up_bhinneka  = '".$harga_up_bhinn."',
                    up_elevenia  = '".$harga_up_elv."',
                    up_mm  = '".$harga_up_mm."',
                    up_lazada  = '".$harga_up_lzd."',
                    up_blibli  = '".$harga_up_bb."',
                    berat_produk  = '".$berat_prod."',
                    dimensi_produk  = '".$dimensi_prod."',
                    link_produk  = '".$link_prod."',
                    kode_produk  = '".$kode_prod."',
                    update_user  = '".$user."',
                    update_time  = NOW()
                    WHERE id_pricelist = '".$id_pl."'";
            
                mysql_query($update_pricelist);
            
            	//UPDATE `tb_link` SET `kode_produk`= lama WHERE `kode_produk` = baru

                $update_link = "UPDATE tb_link SET kode_produk ='".$kode_prod."' WHERE kode_produk = '".$kode_lama."' ";
                mysql_query($update_link);
            
            	if ($link_web_fp !== ''){
					  
					  $lk_web_fp = mysql_fetch_array(mysql_query("SELECT * FROM tb_link_website WHERE kode_produk = '".$kode_prod."'"));
					 
					 if($lk_web_fp['kode_produk'] > 0) {
						
						$update_fp = "UPDATE tb_link_website SET link_fp ='".$link_web_fp."' WHERE kode_produk = '".$kode_prod."' ";
						mysql_query($update_fp);
						
					 } else {

						$tambah_lk = "INSERT INTO tb_link_website (kode_produk, link_fp) VALUES ('".$kode_prod."', '".$link_web_fp."')";
						mysql_query($tambah_lk);
					 }
					
				}

                // $del_grosir = "DELETE FROM tb_wholesale WHERE id_produk = '".$kode_prod."'";
                // mysql_query($del_grosir);

                // $itemCount = 0;
                // $sql = "INSERT INTO tb_wholesale (id_produk, rentang_qty, harga_wholesale, status_email) VALUES ";
                // $values = "";
                // //rsort($hrg); 
                
                // for($i=0;$i<=$nmr;$i++){
                //     if(!empty($qty[$i]) || !empty($hrg[$i])){
                //         $itemCount++;
                //         if($values != "")
                //             $values .= ",";
                //         $values .= "('".$kode_prod."','".$qty[$i]."','".$hrg[$i]."','".$emailstatus."')";
                //     }
                // }
                // $query = $sql.$values;
                
                // echo "<pre>";
                // print_r ($query);
                // echo "</pre>";
                
                
                // if($itemCount != 0)
                //     mysql_query($query);
            }
        }
    }

    // tutup koneksi ke database mysql
    tutup_koneksi();