<?php
    session_start();
    require '../../connect.php';

    buka_koneksi();

    $del = $_POST['del'];

    if(isset($del)) {
        mysql_query("DELETE FROM link_lazada WHERE id = '".$del."'") or die (mysql_error());
    } else {
        $link_prod      = $_POST['link_prod'];
        $kode_prod      = $_POST['kd_prod'];
        $id             = $_POST['id'];

        if ($kode_prod != "" && $link_prod != "") {
            if ($id == 0 || $id == "") {
                $insert_link = "INSERT INTO link_lazada (kode_produk, link, input_time, update_time) VALUES(
                    '".$kode_prod."',
                    '".$link_prod."',
                    NOW(),
                    NOW())";
                mysql_query($insert_link);
            } else if($id > 0){
                $update_link = " UPDATE link_lazada SET
                    link        = '".$link_prod."',
                    kode_produk = '".$kode_prod."',
                    update_time = NOW()
                    WHERE id = '".$id."'";
                mysql_query($update_link);
            }
        }
    }

    tutup_koneksi();
