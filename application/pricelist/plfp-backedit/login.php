<?php
    session_start();
    include "connect.php";
    buka_koneksi(); 
    $now = time();
    if(isset($_SESSION["user"]) || !empty($_SESSION["user"]) ){
        header("location:index.php");
    } else {

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="changeFavicon(this)" type="image/gif" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Masuk Price List</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="assets/css/custom.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">

      <form class="form-signin" method="POST" action="#">
        <h2 class="form-signin-heading"><center>FastPrint Price List</center></h2>
        <label for="inputUser" class="sr-only">Username</label>
        <input type="text" id="inputEmail" class="form-control" name="user" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" name="passwd" placeholder="Password" required>
        <input class="btn btn-lg btn-primary btn-block" name="btnLogin" value="Masuk" type="submit">
      </form>

    <?php
        $masuk = isset($_POST["btnLogin"]);
        if($masuk){
            $user = $_POST["user"];
            $pwd  = $_POST["passwd"];

            $qLog = mysql_query("SELECT user, pass, hak_akses,menutoko,toko,kota FROM users WHERE user = '".$user."' AND pass = MD5('".$pwd."')");
            $num = mysql_num_rows($qLog);
            $data = mysql_fetch_array($qLog);
            if($num > 0){
                $_SESSION["user"]       = $user;
                $_SESSION["hak_akses"]  = $data['hak_akses'];
                $_SESSION["menu_toko"]  = $data['menutoko'];
                $_SESSION["toko"]       = $data['toko'];
                $_SESSION["kota"]       = $data['kota'];
                $_SESSION["start_time"] = time();
                $_SESSION["exp_time"]   = $_SESSION["start_time"] + (60 * 60);
                header("location:index.php");
            } else {
                echo "<script type='text/javascript'>alert('Username dan Password tidak cocok, periksa kembali !');</script>";
            }
        }
    ?>
    </div> <!-- /container -->
    <script>
      var favicon_images = [
                    '//cdn.shopify.com/s/files/1/1764/2831/t/3/assets/favicon.png?9056248321425416510',
                    'assets/icons8-tags.gif'
                ],
                favicon_index = 0;
                
      function changeFavicon() {
          var link = document.querySelector("link[rel='shortcut icon']");
          link.href = favicon_images[favicon_index];
          favicon_index = (favicon_index + 1) % favicon_images.length;
          setTimeout(changeFavicon, 200);
      }
      changeFavicon();

    </script>
  </body>
</html>
<?php } tutup_koneksi(); ?>
