<!DOCTYPE html>
<html>
<head>
  <html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="theme-color" content="#2196f3">
<meta http-equiv="Content-Security-Policy" content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap:">
  <title>Fastprint - pricelist</title>

  <link rel="stylesheet" href="css/fw.css">
  <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js" integrity="sha384-0pzryjIRos8mFBWMzSSZApWtPl/5++eIfzYmTgBBmXYdhvxPc+XcFEk+zJwDgWbP" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/icons.css">
  <link href="https://fonts.googleapis.com/css?family=Rokkitt" rel="stylesheet">
  <link rel="stylesheet" href="css/app.css?<?php echo(md5(date("YmdHis").rand()))?>">

</head>
<body>
  <div id="app">
    <!-- Status bar overlay for fullscreen mode-->
    <div class="statusbar"></div>
    <!-- kategori -->
    <div class="popup popup-kategori">
      <div class="navbar">
        <div class="navbar-inner sliding">
          <div class="left">
            <a href="#" class="link popup-close" style='color:white'>
              <i class="icon icon-back"></i>
              <span class="ios-only">Back</span>
            </a>
          </div>
          <div class="title">Pilih Kategori</div>
        </div>
      </div>
      <div class="page-content" style='margin-top:-50px'>
        
          <div class="row kategori-content">
             
          </div>
      </div>
    </div>

    <input type='hidden' id='id_kat'>

    <!-- Your main view, should have "view-main" class -->
    <div class="view view-main safe-areas">
      <!-- Page, data-name contains page name which can be used in callbacks -->
      <div class="page" data-name="home">
        <!-- Top Navbar -->
        <div class="navbar">
          <div class="navbar-inner">
            <div class="right">
              <a href="#" class="link icon-only popup-open" href="#" data-popup=".popup-kategori" onclick="open_kategori()">
                <i class="fas fa-th-large kategori-link"></i>
              </a>
            </div>
            <div class="title sliding">Pricelist </div>
            <div class="subnavbar">
            <form class="searchbar" onsubmit='return false'>
              <div class="searchbar-inner">
                <div class="searchbar-input-wrap">
                  <input type="search" placeholder="Search" id='cari' autocomplete="off">
                  <i class="searchbar-icon"></i>
                  <span class="input-clear-button"></span>
                </div>
                <span class="searchbar-disable-button">Cancel</span>
              </div>
            </form>
          </div>
          </div>
        </div>
        <!-- Scrollable page content-->
        <div class="page-content infinite-scroll-content">
        <div class="block" id='tag-kategori'>

        </div>
        <div class="list media-list">
          <ul>
            
          </ul>
          
        </div>
        <div class="preloader infinite-scroll-preloader"></div>
        </div>
      </div>
    
  <div class="toolbar toolbar-bottom">
    <div class="toolbar-inner">
      <a href="#" class="link "></a>
     <a href="http://pcls.fastprint.co.id?d=1" class="link external">Mode Desktop</a>
     <a href="#" class="link "></a>
    </div>
  </div>
    </div>

  </div>
  <!-- Framework7 library -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <script src="js/fw.js"></script>

  <!-- App routes -->
  <script src="js/routes.js?<?php echo(md5(date("YmdHis").rand()))?>"></script>

  <!-- Your custom app scripts -->
  <script src="js/app.js?<?php echo(md5(date("YmdHis").rand()))?>"></script>
</body>
</html>
