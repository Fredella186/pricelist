<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$receiver = "prog3.fastprintsby@gmail.com";
$subject  = "test";
$message  = "<html>
<head><title></title></head>
<body>
    <h4><strong>Tim FastPrint,</strong></h4>
    <p align='justify'>
        Ada perubahan harga produk Fast Print dengan keterangan sebagai berikut :
    </p></body></html>";
$header   = "From: Lintar <prog4.fastprintsby@gmail.com>\r\n";

//$header   = "From:". $pengirim ." \r\n";
// $header  .= "MIME-Version: 1.0\r\n";
// $header  .= "Content-type: text/html\r\n";
// $kirim = mail($receiver, $subject, $message, $header);
// var_dump($kirim);

// Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {

    //Server settings
    $mail->SMTPDebug = 0;                                   // Enable verbose debug output
    $mail->isSMTP();                                       // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  					  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                              // Enable SMTP authentication
    $mail->Username = 'prog3.fastprintsby@gmail.com';                           // SMTP username
    $mail->Password = 'HataNetwork2017';                           // SMTP password
    $mail->SMTPSecure = 'tls';                        // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                               // TCP port to connect to

    //Recipients
    $mail->setFrom('prog3.fastprintsby@gmail.com', 'Sales Fast Print');
    $mail->addAddress('prog4.fastprintsby@gmail.com', 'Lintar');
    $mail->addReplyTo('prog3.fastprintsby@gmail.com', 'Sales Fast Print');
                
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;

    $mail->send();

    //echo 'Message has been sent';
    

} catch (Exception $e) {
    
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}