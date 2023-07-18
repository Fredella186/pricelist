<?php

 include "../plfp-backedit/connect.php";
 buka_koneksi();
 if(isset($_GET['p'])){

        $batas = 20;
        $halaman = $_GET['p'];

        $sql = "SELECT * FROM tb_pricelist left join tb_kategori ON (tb_kategori.id_ktg =tb_pricelist.ktg_produk)  WHERE status_view = 1";

        if(isset($_GET['cp'])){
             $sql = "SELECT * FROM tb_pricelist left join tb_kategori ON (tb_kategori.id_ktg =tb_pricelist.ktg_produk) ";

            $cari = $_GET['cp'];
            $pecah_kata = explode(' ',$cari);
        	if(is_numeric($cari)){
            
            	$sql .="where kode_produk='".$cari."' and status_view = 1";
            
            
            }else{
           		
            	if(count($pecah_kata) > 0){
            
                $sql .= "where status_view = 1 and ";
                $i = 1;
                foreach($pecah_kata as $dc){
                    $sql .= "judul_produk Like '%".$dc."%'";

                    if( $i < count($pecah_kata)){
                    $sql .=' And ';
                    }

                    $i++;
                }


            }
            
            }
        //echo $sql;
        
        }

        if(isset($_GET['k']) && $_GET['k']!==''){

            $cari = $_GET['k'];
            $pecah_kata = explode(',',$cari);
           // echo count($pecah_kata);
            if(count($pecah_kata) > 0){
                $sql .= " and status_view = 1 and ";
                $i = 1;
                foreach($pecah_kata as $dc){
                    $sql .= " nama_ktg = '".$dc."'";

                    if( $i < count($pecah_kata)){
                    $sql .=' or ';
                    }
                    $i++;
                }
            }

        }

        

        $sql .=" order by tb_pricelist.judul_produk asc";
        $sql .=" limit ".($halaman-1)*$batas.",".$batas;
        //echo $sql;
        $query = mysql_query($sql);
        $jsonData = array();

        while($data = mysql_fetch_assoc($query))
        {   	
            $link = $data['link_produk'];	
            if (filter_var($link, FILTER_VALIDATE_URL)) {
            $link = $data['link_produk'];
            } else {
                $link = 'https://'.$data['link_produk'];
            }
            $data_sementara = array();
            $data_sementara['id_pricelist'] = $data['id_pricelist'];
            $data_sementara['kode_produk'] = $data['kode_produk'];
            $data_sementara['gambar_produk']= $data['gambar_produk'];
            $data_sementara['judul_produk'] = $data['judul_produk'];
            $data_sementara['harga']        = "Rp. " . number_format($data['harga'],0,'',',');
            $data_sementara['link_produk']  = $link;
            $data_sementara['kategori']  = $data['nama_ktg'];

            array_push($jsonData,$data_sementara);
        }
        //echo "<pre>";
        echo $rs = json_encode($jsonData);
 }
?>