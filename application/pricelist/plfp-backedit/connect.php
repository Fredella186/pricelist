<?php

	use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'vendor/autoload.php';


    define("SERVER_DB", "localhost");
    define("USER_DB", "root");
    //define("PASSWORD_DB", "F45TCr3@t1v3!#%D8");
    define("PASSWORD_DB", "");
    define("NAMA_DB", "pricelist");	
    define("IMG_PATH", "assets/images/");

    function buka_koneksi(){
        $koneksi = mysql_connect(SERVER_DB, USER_DB, PASSWORD_DB);
        mysql_select_db(NAMA_DB, $koneksi);
    }

    function tutup_koneksi(){
        mysql_close(mysql_connect(SERVER_DB, USER_DB, PASSWORD_DB));
    }

	function rupiah($uang){
        $result = "Rp. ".number_format($uang, 0, '', '.' ).",-";
        return $result;
    }

    function waktu($datetime){
        $y = substr($datetime, 0, 4);
        $m = substr($datetime, 5, 2);
        $d = substr($datetime, 8, 2);
        $t = substr($datetime, 11, 8);
        $b = "";
        switch($m){
            case "01" : $b = "Jan"; break;
            case "02" : $b = "Feb"; break;
            case "03" : $b = "Mar"; break;
            case "04" : $b = "Apr"; break;
            case "05" : $b = "Mei"; break;
            case "06" : $b = "Jun"; break;
            case "07" : $b = "Jul"; break;
            case "08" : $b = "Agt"; break;
            case "09" : $b = "Sep"; break;
            case "10" : $b = "Okt"; break;
            case "11" : $b = "Nov"; break;
            case "12" : $b = "Des"; break;
            default : $b = "Bln"; break;
        }
        $hasil = $d." ".$b." ".$y." <br>".$t;
        return $hasil;
    }

    function berat($berat){
        $hasil = "";
        if($berat > 1000){
            $hitung = $berat / 1000;
            $hasil = $hitung." Kg";
        } else {
            $hitung = $berat;
            $hasil = $hitung." Gr";
        }
        return $hasil;
    }
	
	function freeStringLower($str){
        return str_replace(" ", "", strtolower($str));
    }

	function sendMail($email_penerima, $nama_pengirim, $email_pengirim, $cc_mail, $subyek, $pesan)
    {
    	$receiver = $email_penerima;
      	$subject  = $subyek;
      	$message  = $pesan;
      	$header   = "From: " . $nama_pengirim . " <" . $email_pengirim . ">\r\n";
      	
      	if($cc_mail != ""){
      		$header	 .= "Cc: ".$cc_mail."\r\n";
        }
      	//$header   = "From:". $pengirim ." \r\n";
    	$header  .= "MIME-Version: 1.0\r\n";
        $header  .= "Content-type: text/html\r\n";
        
        // if($_SESSION["user"] !== "PURCHASEPST" || $_SESSION["user"] !== "purchasepst"){
            mail($receiver, $subject, $message, $header);

        // }
          

    }

	function kirimEmail($subyek, $pesan, $tes = null){

       $subject_db = mysql_real_escape_string($subyek);
       $emailDB    = mysql_real_escape_string ($pesan);
       $tgl_up     = date("Y-m-d H:i:s");
        $status     = 0;

        $mail = new PHPMailer(true);

        try {
            
            //Server settings
            $mail->SMTPDebug = 0;                                   // Enable verbose debug output
            $mail->isSMTP();                                       // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  					  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                              // Enable SMTP authentication
            $mail->Username = 'noreply.fastprint@gmail.com';    // SMTP username
            $mail->Password = '';              // alternative solving when not supported by google 
            $mail->SMTPSecure = 'tls';                        // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                               // TCP port to connect to
        
            //Recipients
            $mail->setFrom('sales@fastprint.co.id', 'Admin PL Fast Print Indonesia');

            $mail->addAddress('prog3.fastprintsby@gmail.com', '');
            $mail->addAddress('prog5.fastprintsby@gmail.com', '');
            if($tes == null){
                
    

                    $mail->addAddress('prog4.fastprintsby@gmail.com', '');
              

            }else{
                $mail->addAddress($tes, '');
            }
            

            $mail->addReplyTo('sales@fastprint.co.id', 'Sales Fast Print');
            
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subyek;
            $mail->Body    = $pesan;

            if(!empty($_SESSION["user"]) && strtolower($_SESSION["user"]) !== "editor"){
                
                $mail->send();   
                $status = 1;
            }
            
            $status = 1;
            


        } catch (Exception $e) { 
            
            $status = 0;
            // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        
        }

        $sql  = "Insert into log_email values (null,'{$subject_db}','{$emailDB}','{$tgl_up}','{$status}') ";
        mysql_query($sql);

        return $status;
        


    }
    
    function kirimEmailTes($subyek, $pesan){

        $subject_db = mysql_real_escape_string($subyek);
        $emailDB    = mysql_real_escape_string ($pesan);
        $tgl_up     = date("Y-m-d H:i:s");
         $status     = 0;
 
         $mail = new PHPMailer(true);
 
         try {
             
             //Server settings
             $mail->SMTPDebug  = 1;                                   // Enable verbose debug output
             $mail->isSMTP();                                       // Set mailer to use SMTP
             $mail->Host       = 'smtp.gmail.com';  					   // Specify main and backup SMTP servers
             $mail->SMTPAuth   = true;                              // Enable SMTP authentication
             $mail->Username   = 'noreply.fastprint@gmail.com';    // SMTP username
             $mail->Password   = 'qwwwsgoextxjegfg';              // alternative solving when not supported by google 
             $mail->SMTPSecure = 'tls';                        // Enable TLS encryption, `ssl` also accepted
             $mail->Port = 587;                               // TCP port to connect to
         
             //Recipients
             $mail->setFrom('sales@fastprint.co.id', 'Admin PL Fast Print Indonesia');
 
             $mail->addAddress('prog4.fastprintsby@gmail.com', '');
 
            //  $mail->addAddress('sales@fastprint.co.id', '');
             $mail->addReplyTo('sales@fastprint.co.id', 'Sales Fast Print');
             
             //Content
             $mail->isHTML(true);                                  // Set email format to HTML
             $mail->Subject = $subyek;
             $mail->Body    = $pesan;
             // if($_SESSION["user"] !== "PURCHASEPST" || $_SESSION["user"] !== "purchasepst"){
                 
                 $mail->send();   
             
             // }

             print_r($mail);
             
             $status = 1;
 
 
         } catch (Exception $e) { 
            echo "<pre>";
             print_r($e);
             $status = 0;
             // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
         
         }
 
        //  $sql  = "Insert into log_email values (null,'{$subject_db}','{$emailDB}','{$tgl_up}','{$status}') ";
        //  mysql_query($sql);
 
 
         
 
 
     }

	function rapiLink($link) {
		//~ var_dump($link);
		$a = substr($link, 0, 75);
      	$text = (strpos($a, "-")) ? substr($a, 0, strrpos($a, "-")) : substr($a, 0, strrpos($a, "_"));
		$hsl = (strlen($link) > 75) ? $text."-...-.html" : $link;
		//~ var_dump($hsl);	
		return $hsl;
	}
	
	function rapiJudul($title) {
		$size = strlen($title);
		$a = substr($title, 0, 60);
      	$b = substr($title, 61, $size);
      	//$text = (strpos($a, " ")) ? substr($a, 0, strrpos($a, "-")) : substr($a, 0, strrpos($a, "_"));
		//$hsl = (strlen($title) > 75) ? $text."-...-.html" : $link;
		$hsl = $a."<br/>".$b;
      	//~ var_dump($hsl);	
		return $hsl;
	}

	function kirim_skype($pesan){
    
    	// $data = array("to"=>"29:12LSz2xQKculAIvzjZK81Dz1K-gKO9bIFm2Kse8Dtt1zJEBhoQFQv0Z-CyIXvWdfI","msg"=>$pesan);
    	// $data = json_encode($data);

    	// $ch = curl_init(); 
    	// curl_setopt($ch, CURLOPT_URL, "http://fastprint.id/botSkype/send.php");
    	// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    	// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    	// $output = curl_exec($ch); 
    	// curl_close($ch);      	
    
    }
	
