<?php
	include "connect.php";
    session_start();
    $id = $_POST['id'];
    $status = $_POST['stat'];
    
    if (!isset($_SESSION['c_link']) || $_SESSION['c_link'] == ''){
        $_SESSION['c_link'] = array();
    }

    if($status == 'true'){

        if(!in_array($id,$_SESSION['c_link'])){
            array_push($_SESSION['c_link'],$id);
        }

    }else{

        if (($key = array_search($id, $_SESSION['c_link'])) !== false) {
            unset($_SESSION['c_link'][$key]);
            
        }
    }
 

    echo count($_SESSION['c_link']);
  