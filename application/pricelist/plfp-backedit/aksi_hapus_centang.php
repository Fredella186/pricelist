<?php

session_start();
require 'connect.php';

// buat koneksi ke database mysql
buka_koneksi(); 


    // echo json_encode($_SESSION['c_link']);
    $arr = array();
    if(!empty($_SESSION['c_link']) && is_array($_SESSION) == true){
        foreach($_SESSION['c_link'] as $id){
            
            $sql = "DELETE FROM tb_link WHERE id_link = '".$id."'";			
			
            if(mysql_query($sql)){
				array_push($arr,$id);
            }
            // array_push($arr,$id);
        }
        echo json_encode($arr);
    }
    $_SESSION['c_link'] = array();
tutup_koneksi();