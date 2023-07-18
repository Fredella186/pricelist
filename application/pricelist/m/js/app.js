// Dom7
//var $$ = Dom7;
var id_kat = [];
// Framework7 App main instance
var app  = new Framework7({
  root: '#app', // App root element
  id: 'io.framework7.testapp', // App bundle ID
  name: 'Framework7', // App name
  theme: 'auto', // Automatic theme detection
  routes: routes,
});

// Init/Create main view
var mainView = app.views.create('.view-main', {
  url: '/'
});

var img = [];

/*=== Default standalone ===*/
var myPhotoBrowserStandalone = app.photoBrowser.create({
  photos : img,
  theme: 'light',
  type: 'standalone',
  toolbar:false,
  navbar:true
});

var page = 1;

if(document.URL.search("https://") < 0){
            	
   // window.location = document.URL.replace("http://","https://");
            	
}


var lastItemIndex = 0;

app.request.get('pjson.php?p=1', function (data) {
  data = JSON.parse(data);
  //console.log(data);
  var html ='';
  data.forEach(function (e){
   // console.log(e);
    html += '<li>'+
                '<div class="item-content">'+
                  '<div class="item-media"><img class="gambar" src="../plfp-backedit/assets/images/'+e['gambar_produk']+'" width="90"/></div>'+
                  '<div class="item-inner">'+
                    '<a class="item-link" href="detail/'+e['kode_produk']+'" >'+
                        '<div class="item-title-row">'+
                          '<div class="item-title">'+e['judul_produk']+'</div>'+
                        '</div>'+
                        '<div class="item-subtitle">'+e['harga']+' <b class="link">( '+e['kategori']+' )</b></div>'+
                    '</a>'+
                    '<div class="item-subtitle">'+
                      '<a target="_blank" href='+e['link_produk']+' class="link external"><i class="fas fa-bookmark"></i> &nbsp;Link Produk</a>'+                      
                      '</div>'+ 
                  '</div>'+
                '</div>'+
              '</li>';
  })

  $('.list ul').append(html);
  
  //Open photo browser on click
  $('.gambar').on('click', function (e) {
    img.splice(0,img.length);
    setTimeout(function(){

      myPhotoBrowserStandalone.open(0);

    },300)
    
    img.push(e['target']['src']);
    
  });
  
      
});

var Urll   = document.URL;
var getURL = Urll.split("?key=");
var element=document.getElementById("cari");
if(getURL.length > 1){
  element.value = getURL[1];
  if ("createEvent" in document) {
      var evt = document.createEvent("HTMLEvents");
      evt.initEvent("change", false, true);
      element.dispatchEvent(evt);
  }else{
      element.fireEvent("onchange");
  }
}

// Loading flag
var allowInfinite = true;

// Max items to load
var maxItems = 0;
app.request.get('banyak_data.php', function (data) {

  maxItems = data;
  //console.log(maxItems);
  //alert(maxItems);
})



// Attach 'infinite' event handler
$('.infinite-scroll-content').on('infinite', function () {
  //alert('hello');
  lastItemIndex = $('.list li').length;

  // Exit, if loading in progress
  if (!allowInfinite) return;

  // Set loading flag
  allowInfinite = false;

  // Emulate 1s loading
  setTimeout(function () {
    // Reset loading flag
    allowInfinite = true;
    //console.log(page);
    if (lastItemIndex >= maxItems) {
      // Nothing more to load, detach infinite scroll events to prevent unnecessary loadings
      app.infiniteScroll.destroy('.infinite-scroll-content');
      // Remove preloader
      $('.infinite-scroll-preloader').remove();
      //return;
    }
  
  page++;

    // Generate new items HTML
    var html2 = '';

    app.request.get('pjson.php?p='+page+'&cp='+encodeURI($('#cari').val())+'&k='+$('#id_kat').val().split('-').join(' ').split("_").join("/"), function (infinite) {
      infinite = JSON.parse(infinite);
      //console.log(data);
      infinite.forEach(function (e){
       // console.log(e);
        html2 +=  '<li>'+
                    '<div class="item-content">'+
                      '<div class="item-media"><img class="gambar" src="../plfp-backedit/assets/images/'+e['gambar_produk']+'" width="90"/></div>'+
                      '<div class="item-inner">'+
                        '<a class="item-link" href="detail/'+e['kode_produk']+'" >'+
                            '<div class="item-title-row">'+
                              '<div class="item-title">'+e['judul_produk']+'</div>'+
                            '</div>'+
                            '<div class="item-subtitle">'+e['harga']+' <b class="link">( '+e['kategori']+' )</b></div>'+
                        '</a>'+
                        '<div class="item-subtitle">'+
                          '<a target="_blank" href='+e['link_produk']+' class="link external"><i class="fas fa-bookmark"></i> &nbsp; Link Produk</a>'+                      
                          '</div>'+ 
                      '</div>'+
                    '</div>'+
                  '</li>';
      })
    
      
      // Append new items
      $('.list ul').append(html2);
            
      //Open photo browser on click
      $('.gambar').on('click', function (e) {
        img.splice(0,img.length);
        setTimeout(function(e){

          myPhotoBrowserStandalone.open(0);

        },300)
        
        img.push(e['target']['src']);
        
      });
    });

    





    // Update last loaded index
    lastItemIndex = $('.list li').length;
  }, 1000);
});

$('#cari').on('keyup keypress keydown focus change',function(){
  page = 1;
  app.request.get('pjson.php?p=1&cp='+encodeURI($('#cari').val())+'&k='+$('#id_kat').val().split('-').join(' ').split("_").join("/"), function (data) {
    data = JSON.parse(data);
    // console.log(data);
    var html ='';
    data.forEach(function(e){
     // console.log(e);
      html +=  '<li>'+
                '<div class="item-content">'+
                  '<div class="item-media"><img class="gambar" src="../plfp-backedit/assets/images/'+e['gambar_produk']+'" width="90"/></div>'+
                  '<div class="item-inner">'+
                    '<a class="item-link" href="detail/'+e['kode_produk']+'" >'+
                        '<div class="item-title-row">'+
                          '<div class="item-title">'+e['judul_produk']+'</div>'+
                        '</div>'+
                        '<div class="item-subtitle">'+e['harga']+' <b class="link">( '+e['kategori']+' )</b></div>'+
                    '</a>'+
                    '<div class="item-subtitle">'+
                      '<a target="_blank" href='+e['link_produk']+' class="link external"><i class="fas fa-bookmark"></i> &nbsp;Link Produk</a>'+                      
                      '</div>'+ 
                  '</div>'+
                '</div>'+
              '</li>';
    })
  
    $('.list ul').html(html);
    lastItemIndex = $('.list li').length;

    if(lastItemIndex < 20){
      $('.infinite-scroll-preloader').remove();
    }
    
    
    

    //Open photo browser on click
    $('.gambar').on('click', function (e) {
      img.splice(0,img.length);
      setTimeout(function(e){

        myPhotoBrowserStandalone.open(0);

      },300)
      
      img.push(e['target']['src']);
      
    });
        
  });
})

$(document).on('page:init','.page[data-name="detail"]', function (e) {
  // Page Data contains all required information about loaded and initialized page
  var page = e.detail;
  id = page.route.params.id;
  console.log(id);
  app.request.get('../hit.php?kode-bc='+id, function (data) {

      // console.log(data);
  })


  app.request.get('detailJson.php?id='+encodeURI(id), function (data) {
    data = JSON.parse(data);
    
    $('#judul_produk').html(data['p']['judul_produk']);
    $('#sku-produk').val(data['p']['kode_produk']);
    $('#kode-barcode').html(data['p']['kode_produk']);
    $('#gambar').html("<center><img src='../plfp-backedit/assets/images/"+data['p']['gambar_produk']+"' width='80%'></center>");
    var doption = '';
      data['d'].forEach(function(e){
        doption += "<tr>";
        doption += "<td  style='text-align:center'>"+e['rentang_qty']+"</td>";
        doption += "<td  style='text-align:center'>"+e['rp']+"</td>";
        doption += "</tr>";
      })

      $('#tbl').html(doption);

      var doption2 = '';
      data['d'].forEach(function(e2){
        doption2 += "<tr>";
        doption2 += "<td  style='text-align:center'>"+e2['rentang_qty']+"</td>";
        doption2 += "<td  style='text-align:center'>"+e2['rp_luar']+"</td>";
        doption2 += "</tr>";
      })
     

      $('#tbl2').html(doption2);

  })

})

function tag_kategori(){
  var data = $('#id_kat').val();
  var tags = '';
  app.request.get('kategori.php?c='+data.split('-').join(' ').split("_").join("/"), function (d) {
  console.log(d);
    d = JSON.parse(d);
    d.forEach(function(e){
        tags +='<div class="chip color-blue" id="tagke-'+e['nama_ktg'].split(" ").join("-").split("/").join("_")+'">'+
                  '<div class="chip-label">'+e['nama_ktg']+'</div><a href="#" class="chip-delete" data-id="'+e['nama_ktg'].split(" ").join("-").split("/").join("_")+'" onclick="hapus_tag(this)" style="color:white"></a>'+
                '</div>';
    })


    $('#tag-kategori').html(tags)
    
    setTimeout(function(e){
      load_kategori();
    },1000)
  })


}

function hapus_tag(e){
  id = $(e).data('id')
  console.log(id);
  var index = id_kat.indexOf(id);
  if (index !== -1) id_kat.splice(index, 1);
  $('#id_kat').val(id_kat);
  $('#tagke-'+id).remove();
  console.log($('#tagke-'+id.split(" ").join("-").split("/").join("_")));
  if(id_kat.length > 0 ){

    setTimeout(function(){
      tag_kategori();
    },1000)
  }else{
    setTimeout(function(){
      load_kategori();
    },1000)
  }
}

function load_kategori(){
  var html1 = '';

    app.request.get('pjson.php?p=1'+'&cp='+encodeURI($('#cari').val())+'&k='+$('#id_kat').val().split('-').join(' ').split("_").join("/"), function (data1) {
      data1 = JSON.parse(data1);
      console.log($('#id_kat').val().split('-').join(' ').split("_").join("/"));
      data1.forEach(function(e){
       // console.log(e);
        html1 += '<li>'+
                  '<div class="item-content">'+
                    '<div class="item-media"><img class="gambar" src="../plfp-backedit/assets/images/'+e['gambar_produk']+'" width="90"/></div>'+
                    '<div class="item-inner">'+
                      '<a class="item-link" href="detail/'+e['kode_produk']+'" >'+
                          '<div class="item-title-row">'+
                            '<div class="item-title">'+e['judul_produk']+'</div>'+
                          '</div>'+
                          '<div class="item-subtitle">'+e['harga']+' <b class="link">( '+e['kategori']+' )</b></div>'+
                      '</a>'+
                      '<div class="item-subtitle">'+
                        '<a target="_blank" href='+e['link_produk']+' class="link external"><i class="fas fa-bookmark"></i> &nbsp;Link Produk</a>'+                      
                        '</div>'+ 
                    '</div>'+
                  '</div>'+
                '</li>';
      })

      $('.list ul').html(html1);
      //Open photo browser on click
      $('.gambar').on('click', function (e) {
        img.splice(0,img.length);
        setTimeout(function(e){

          myPhotoBrowserStandalone.open(0);

        },1000)
        
        img.push(e['target']['src']);
        
      });


    })
}

function pilih_kategori(e){
  var id = $(e).data('id')
  var index = id_kat.indexOf(id);
  if (index !== -1) id_kat.splice(index, 1);
  id_kat.push(id);
  $('#id_kat').val(id_kat);

  setTimeout(function(){
    tag_kategori();
  },1000)

}


function open_kategori(){
  
  app.request.get('kategori.php', function (data) {
    data = JSON.parse(data);
    var content = '';
    data.forEach(function(e){


      //if(e['gambar_produk'] !== null){

          content +='<div class="col-33 kategori-item popup-close" data-id="'+e['nama_ktg'].split(" ").join("-").split("/").join("_")+'"  onClick="pilih_kategori(this)">'+
                        '<div><center><img height="60px" src="'+e['gambar_produk']+'"></center></div>'+
                        '<div><center>'+
                        e['nama_ktg']+
                    '</center></div></div>';
        

     // }

    })

    $('.kategori-content').html(content);

  })



}

function barcode(){
console.log("hello")
var barcode      = document.querySelector('#sku-produk').value;
var judul_produk = document.querySelector('#judul_produk').innerText;
var dynamicPopup = app.popup.create({
    content:  
              '<div class="popup">'+
                '<div class="navbar">'+
                  '<div class="navbar-bg"></div>'+
                  '<div class="navbar-inner">'+
                    '<div class="left">'+
                      '<a class="link popup-close">'+
                        '<i class="icon icon-back" style="color:white"></i>'+
							'<span class="ios-only" style="color:white">Back</span>'+
                      '</a>'+
                    '</div>'+
                    '<div class="title">Barcode</div>'+
                    '<div class="right"></div>'+
                  '</div>'+
                '</div>'+
                '<div class="block">'+
                '<center id="qr-code"></center>'+
                '<hr>'+
                '<center><div  id="barcode-code"></div></center>'+
                '<hr>'+
                '<center id="judul-pro"></center>'+
                '<center><b id="kodenya"></b></center>'+
				'<p>'+
				'<center><button class="col button button-fill" onclick="copybc()">Copy SKU</button></center>'+
                '</div>'+
              '</div>',
    // Events
    on: {
      open: function (popup) {
        console.log('Popup open');
      },
      opened: function (popup) {
        console.log('Popup opened');
      },
    }
  });

  dynamicPopup.open();

  $('#judul-pro').html(judul_produk);
  $('#kodenya').html("( " + barcode + " )");
  $('#qr-code').qrcode({
    render: "canvas", //设置渲染方式，有table和canvas，使用canvas方式渲染性能相对来说比较好
    text: barcode, //扫描二维码后显示的内容,可以直接填一个网址，扫描二维码后自动跳向该链接
    width: 200, //二维码的宽度
    height: 200,
    background: "#ffffff", //二维码的后景色
    foreground: "#000000", //二维码的前景色
    src: '../q.png',
    imgWidth: 50,
    imgHeight: 50
  });

  $("#barcode-code").barcode(
    barcode, // Value barcode (dependent on the type of barcode)
   "code128",
   {
      barWidth: 2,
      barHeight: 50,
      moduleSize: 5,
      showHRI: true,
      addQuietZone: true,
      marginHRI: 5,
      bgColor: "#FFFFFF",
      color: "#000000",
      fontSize: 14,
      output: "svg",
      posX: 0,
      posY: 0
   } // type (string)
);   
  
}

function copybc(){

var barcode      = document.querySelector('#sku-produk').value;
var $temp = $("<input>");
               $("body").append($temp);
               $temp.val(barcode).select();
               document.execCommand("copy");
               $temp.remove();
var toastTop = app.toast.create({
  text: 'SKU dicopy',
  position: 'bottom',
  closeTimeout: 2000,
});

 toastTop.open();

}

