<?php 

if (isset($_GET['nama'])) {

    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');
    //$param = urldecode($_GET['nama']);
    //$param = str_replace(' ','+',$_GET['nama']);
	
    //Use file_get_contents to GET the URL in question.
    //$contents = file_get_contents("http://localhost/pricelistTest/pricelist-pl.php?alias=$param");
	//echo "http://pcls.fastprint.co.id/pricelist-pl.php?alias=".$param;
	//echo $_GET['nama'];
	
		
    $contents = file_get_contents("https://pcls.fastprint.co.id/pricelist-pl.php?alias=".urlencode($_GET['nama']));
    
    //If $contents is not a boolean FALSE value.
    if($contents !== false){
        //Print out the contents.
        echo $contents;
		
    } else {
        echo "Tidak ditemukan data yang sama";
    }

} else {
   
}
