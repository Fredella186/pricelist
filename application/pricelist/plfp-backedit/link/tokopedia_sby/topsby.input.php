<?php
    session_start();
    require '../../connect.php';

    buka_koneksi();

    $del = $_POST['del'];

    if(isset($del)) {
        mysql_query("DELETE FROM link_toped_sby WHERE id = '".$del."'") or die (mysql_error());
    } else {
        $link_prod1     = $_POST['link_1'];
        $link_prod2     = $_POST['link_2'];
        $kode_prod      = $_POST['kd_prod'];
        $id             = $_POST['id'];
        var_dump($id);
        if ($kode_prod != "" && $link_prod1 != "") {
            if ($id == 0 || $id == "") {
                $insert_link = "INSERT INTO link_toped_sby (kode_produk, link_1, link_2, insert_time, update_time) VALUES(
                    '".$kode_prod."',
                    '".$link_prod1."',
                    '".$link_prod2."',
                    NOW(),
                    NOW())";
                mysql_query($insert_link) or die (mysql_error());
            } else if($id > 0){
                $update_link = " UPDATE link_toped_sby SET
                    link_1        = '".$link_prod1."',
                    link_2        = '".$link_prod2."',
                    kode_produk = '".$kode_prod."',
                    update_time = NOW()
                    WHERE id = '".$id."'";
                mysql_query($update_link) or die (mysql_error());
            }
        }
    }

    tutup_koneksi();
