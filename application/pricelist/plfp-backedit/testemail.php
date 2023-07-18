<?php
    session_start();
    // panggil berkas koneksi.php
    require 'connect.php';

    // buat koneksi ke database mysql
    buka_koneksi();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>FastPrint - Price List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="assets/css/custom.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
  </head>
  <body>
    <br>
	<div class="container">
    <button id="test_kirim" class="btn btn-primary">Tes Kirim Email</button>
    <div id="tesemail"></div>  
    </div>
    <script src="assets/js/jquery.min.js"></script>

    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Magnific Popup core JS file -->
    <script src="assets/js/jquery.magnific-popup.js"></script>
    <!--
    <script src="assets/js/custom.js"></script>
    -->
    <script src="pricelist.js"></script>
</body>
</html>  

<script type="text/javascript">

    $('#test_kirim').on("click", function(){
        var url = "kirim_email.php";
        var nama = "Lintar";
        $.post(url, {nm: nama} ,function(data) {
            console.log(data);
        });
        
    });

</script>
<?php
    // tutup koneksi ke database mysql
    tutup_koneksi();
?>