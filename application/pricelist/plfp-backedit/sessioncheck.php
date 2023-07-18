<?php
session_start();
$data = file_get_contents("php://input");

if(!isset($_SESSION['CHECKLIST'])){

    $_SESSION['CHECKLIST'] = array();
 
}else{

    $arr = json_decode($data,true); 
    $id  = $arr['id'];
    if($arr['check']){

        $input = 0;
        foreach ($_SESSION['CHECKLIST'] as $key=>$value) {
            
            if($value === $id){

                $input = 1;
                
            }

        }

        if($input == 0){

            array_push($_SESSION['CHECKLIST'],$id);
            
        }

        print_r($_SESSION['CHECKLIST']);

    }else{
        
        foreach ($_SESSION['CHECKLIST'] as $key=>$value) {
            
            if($value === $id){

                unset($_SESSION['CHECKLIST'][$key]);
                print_r($_SESSION['CHECKLIST']);
            }

        }


    }
    
    

}


if(isset($_GET['view'])){

    echo json_encode($_SESSION['CHECKLIST']);

}


