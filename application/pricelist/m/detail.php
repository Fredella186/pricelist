<div class="page" data-name="detail">
  <div class="navbar">
    <div class="navbar-inner sliding">
      <div class="left">
        <a href="#" class="link back" style='color:white'>
          <i class="icon icon-back"></i>
          <span class="ios-only">Back</span>
        </a>
      </div>
      <div class="title">Detail Produk </div>
      <a href="#" onclick='barcode()' class="link" style='color:white;right:0;position:absolute'>
          <i class="fas fa-qrcode"></i>
        </a>
    </div>
  </div>
  <div class="page-content">

    <div id='gambar'></div>
    <input type='hidden' id='sku-produk'>
    <center><p id='judul_produk'></p></center>
<!--   	<center><b id='kode-barcode'></b></center> -->
  	<center><button class='button  button-fill' onclick="copybc()" id='kode-barcode'>Copy SKU</button></center>
    <div class="data-table">
    <table>
      <thead>
        <tr>
          <th style="background: #2c3e50;color:white;text-align:center;" colspan='2' class='text-center'>Harga Jawa</th>
        </tr>
        <tr id='htable'>
          <th class="label-cell" style='text-align:center;color:white;'>Qty</th>
          <th class="label-cell" style='text-align:center;color:white;'>Harga</th>
        </tr>
      </thead>
      <tbody id='tbl'>

      </tbody>
    </table>
    <hr>
    <table>
      <thead>
        <tr>
          <th style="background: #DC5F00;color:white;text-align:center;" colspan='2' class='text-center'>Harga Luar Jawa</th>
        </tr>
        <tr id='htable2'>
          <th class="label-cell" style='text-align:center;color:white;background: #DC5F00;color:white;text-align:center;'>Qty</th>
          <th class="label-cell" style='text-align:center;color:white;background: #DC5F00;color:white;text-align:center;'>Harga</th>
        </tr>
      </thead>
      <tbody id='tbl2'>

      </tbody>
    </table>
  </div>


  </div>
</div>

