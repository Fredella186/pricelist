<?php
	require 'connect.php';
	
    $response = "";
        
    $allowed = array("image/jpeg", "image/jpg", "image/png");
    
    if(isset($_POST['img'])){
		$img = $_POST['img'];
		$storage = IMG_PATH . $img;

        buka_koneksi(); 
		$cek_gambar = mysql_query("SELECT gambar_produk FROM `tb_pricelist` where gambar_produk = '{$img}'");
        $hasil_cek = mysql_fetch_array($cek_gambar);

		if(count($hasil_cek <= 1)){
            unlink($storage);
        }
        $response = "deleted"; 

        $arr_response = array(
            'response' => $response,
        );
        echo json_encode($arr_response); 
        tutup_koneksi();
	}
	else if ( 0 < $_FILES['file']['error'] ) {
        //~ echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        $response = "error";

        $arr_response = array(
            'response' => $response,
            );
        echo json_encode($arr_response); 
    }
    else if($_FILES['file']['size'] > 256000){
        //~ $message = 'File too large ! File must be less than 500 Kb.';
        //~ echo '<script type="text/javascript">alert("'.$message.'");</script>';
        $response = "large";

        $arr_response = array(
            'response' => $response,
            );
        echo json_encode($arr_response); 
    }
    else if(!in_array($_FILES['file']['type'], $allowed)){
        $response = "disallowed";

        $arr_response = array(
            'response' => $response,
            );
        echo json_encode($arr_response); 
    }
    else {
        //var_dump($_FILES['file']['tmp_name']);
        //var_dump($_FILES['file']['name']);
        //var_dump($_FILES['file']['type']);
        //var_dump($_FILES['file']['size']);
        $storage = IMG_PATH . $_FILES['file']['name'];

        // if(file_exists($storage)){
		// 	unlink($storage);
		// 	move_uploaded_file($_FILES['file']['tmp_name'], $storage);
		// 	$response = "replaced";
        // } else {			
		// 	move_uploaded_file($_FILES['file']['tmp_name'], $storage);
		// 	$response = "success";
		// } 
        // var_dump($storage);    
        
        $filename = $_FILES["file"]["name"];
		$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
		$file_ext = substr($filename, strripos($filename, '.')); // get file name
		
		$newfilename = md5($file_basename).rand(10,100) . $file_ext;
		move_uploaded_file($_FILES["file"]["tmp_name"], IMG_PATH. $newfilename);
		
		$a=array();
		array_push($a, array('file'=>$newfilename));
        // echo json_encode($a);
        
        $response = "success";

        $arr_response = array(
                'response' => $response,
                'error'    => $_FILES['file']['error'],
                'file_name'=> $newfilename,
            );
        echo json_encode($arr_response);
    }

    //echo $response;
