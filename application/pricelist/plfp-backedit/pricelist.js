(function($) {
    // fungsi dijalankan setelah seluruh dokumen ditampilkan
    $(document).ready(function(e) { 

        // deklarasikan variabel
        var kode_produk = 0;
        var main        = "pricelist.data2.php";      

        // tampilkan data pricelist dari berkas pricelist.data.php
        // ke dalam <div id="data-pl"></div>
        $("#data-pl").load(main);
      
      	// ketika pilihan tampilan per kategori dipilih
        $('select[name=view_data]').on('change', function(){
            var view = $('select[name=view_data]').val();

            if(view != ""){
                $.post(main, {view_data:view}, function(data){
                    $("#data-pl").html(data).show();
                });
            } else {
                $("#data-pl").load(main);
            }
        });
      
        // ketika inputbox pencarian diisi
        $('input:text[name=cari]').on('keyup',function(e){
            var v_cari = $('input:text[name=cari]').val();

            if (v_cari != "" && v_cari.length > 2) {                
              	$.post(main, {cari: v_cari} ,function(data) {
                    // tampilkan data pricelist yang sudah di perbaharui
                    // ke dalam <div id="data-pl"></div>
                    $("#data-pl").html(data).show();
                });
                //console.log(main);
            } else {
              	// tampilkan data pricelist dari berkas pricelist.data.php
                // ke dalam <div id="data-pl"></div>
                $("#data-pl").load(main);
            }
        });
      
      	$('#btnCari').on('click',function(e){
            var v_cari = $('input:text[name=cari]').val();

            if (v_cari != "" && v_cari.length > 2) {                
              	$.post(main, {cari: v_cari} ,function(data) {
                    // tampilkan data pricelist yang sudah di perbaharui
                    // ke dalam <div id="data-pl"></div>
                    $("#data-pl").html(data).show();
                });
                
            } else {
              	// tampilkan data pricelist dari berkas pricelist.data.php
                // ke dalam <div id="data-pl"></div>
                $("#data-pl").load(main);
            }
          //console.log(data);
        });	
      	    	
        // ketika tombol ubah/tambah ditekan
        $('.tambah').on("click", function(){
            var url = "pricelist.form.php";
            // ambil nilai id dari tombol ubah
            kode_produk = this.id;
            var id_pl = 0;
            //alert(kode_produk);
            if(kode_produk == 0) {
                // ubah judul modal dialog
                $("#myModalLabel").html("Tambah Data Price List");
            }

            $.post(url, {kd_produk: kode_produk, id_pl: id_pl} ,function(data) {
                // tampilkan pricelist.form.php ke dalam <div class="modal-body"></div>
                $(".modal-body").html(data).show();
            });
        });

        $('.edit').on("click", function(){
            var url = "pricelist.form.php";
            // ambil nilai id dari tombol ubah 
            kode_produk = this.id;
            //alert(kode_produk);
            if(kode_produk != 0) {
                // ubah judul modal dialog
                $("#myModalLabel").html("Ubah Data Price List");
            }

            $.post(url, {kd_produk: kode_produk} ,function(data) {
                // tampilkan pricelist.form.php ke dalam <div class="modal-body"></div>
                $(".modal-body").html(data).show();
            });
        });

        // ketika tombol hapus ditekan
        $('.delete').on("click", function(){
            var url = "pricelist.input.php";
            // ambil nilai id dari tombol hapus
            kode_produk = this.id;
            // tampilkan dialog konfirmasi
            var answer = confirm("Hapus data ini ?");

            // ketika ditekan tombol ok
            if (answer) {
                // mengirimkan perintah penghapusan ke berkas pricelist.input.php
                $.post(url, {hapus: kode_produk} ,function() {
                    // tampilkan data pricelist yang sudah di perbaharui
                    // ke dalam <div id="data-pl"></div>
                    $("#data-pl").load(main);
                });
            }
        });

        // ketika tombol halaman ditekan
        $('.halaman').on("click", function(event){
            // mengambil nilai dari inputbox
            kd_hal = this.id;

            $.post(main, {halaman: kd_hal} ,function(data) {
                // tampilkan data mahasiswa yang sudah di perbaharui
                // ke dalam <div id="data-mahasiswa"></div>
                $("#data-pl").html(data).show();
            });
        });

        // ketika tombol simpan ditekan
        $("#simpan-pricelist").bind("click", function(event) {
          	// alert('maintenance')
            var url = "pricelist.input.php";
            var qty = [];
            var nmr = [];
            var hrg = [];
            i = 0; 
            j = 1;
            // mengambil nilai dari inputbox, textbox dan select
            var kode_prod       = $('input:text[name=kode_prod]').val();
        	var kode_lama       = $('input:text[name=kode_lama]').val();
            var text_gbr_prod   = $('#gambar_text').val();
            var kat_prod        = $('select[name=ktg_prod]').val();
            var judul_prod      = $('textarea[name=judul_prod]').val();
        	var nama_alias      = $('textarea[name=nama_alias]').val();
            var deskripsi_prod  = $('textarea[name=deskripsi_prod]').val();
            var harga_prod      = $('input:text[name=harga_prod]').val();

            $('input:checkbox[name^=cb]').each(function() {
                nmr[i] = $('input:hidden[name=nmr_'+j+']').val();
                qty[i] = $('input:text[name=qty_'+j+']').val();
                hrg[i] = $('input:text[name=hrg_'+j+']').val();
                i++;
                j++;
            });
            //console.log(kat_prod);
            var harga_10_prod   = $('input:text[name=harga_10_prod]').val();
            var harga_up_blanja = $('input:text[name=harga_up_blanja]').val();
            var harga_up_bhinn  = $('input:text[name=harga_up_bhinn]').val();
            var harga_up_elv 	= $('input:text[name=harga_up_elv]').val();
            var harga_up_mm		= $('input:text[name=harga_up_mm]').val();
            var harga_up_lzd 	= $('input:text[name=harga_up_lzd]').val();
            var harga_up_bb 	= $('input:text[name=harga_up_bb]').val();
            var berat_prod      = $('input:text[name=berat_prod]').val();
            var dimensi_prod    = $('input:text[name=dimensi_prod]').val();
            var link_produk     = $('input:text[name=link_prod]').val();
            var id_pricelist    = $('input:hidden[name=id_pricelist]').val();
        
        	var link_web        = $('input:text[name=link_web]').val();
            var datainput       = {
                                    id_pl       : id_pricelist,
                                    txt_gbr_prod: text_gbr_prod,
                                    ktg_prod    : kat_prod,
                                    jdl_prod    : judul_prod,
                                    nama_alias  : nama_alias,
                                    des_prod    : deskripsi_prod, 
                                    hrg_prod    : harga_prod,
                                    Nmr         : nmr,
                                    Qty         : qty,
                                    Hrg         : hrg,
                                    hrg10_prod  : harga_10_prod, 
                                    up_blanja  	: harga_up_blanja,
                                    up_bhinn  	: harga_up_bhinn,
                                    up_elv  	: harga_up_elv,
                                    up_mm	  	: harga_up_mm,
                                    up_lzd	  	: harga_up_lzd,
                                    up_bb	  	: harga_up_bb,
                                    brt_prod    : berat_prod,
                                    dmnsi_prod  : dimensi_prod,
                                    link_prod   : link_produk,
                                    id          : kode_produk,
                                    kd_lama     : kode_lama,
                                    kd_prod     : kode_prod,
                                    lk_web		: link_web
                                };
            console.log(datainput)
            // mengirimkan data ke berkas transaksi.input.php untuk di proses
            $.post(url, datainput ,function(e) {
                    console.log(e)
                    // tampilkan data pricelist yang sudah di perbaharui
                    // ke dalam <div id="data-pricelist"></div>
                    $("#data-pl").load(main);

                    // sembunyikan modal dialog
                    $('#dialog-pl').modal('hide');

                    // kembalikan judul modal dialog
                    $("#myModalLabel").html("Tambah Data Price List");
            });
          	
        });

        $("#hidden-pricelist").bind("click", function(event){

            var kode_prod       = $('input:text[name=kode_prod]').val();
            var kode_lama       = $('input:text[name=kode_lama]').val();

            if (kode_prod !== '' && kode_lama !== ''){

                $.post("hidden.php", { kd_prod : kode_prod} ,function() {

                    alert( "Data Berhasil dihidden" );

                    $("#data-pl").load(main);
    
                    // sembunyikan modal dialog
                    $('#dialog-pl').modal('hide');
    
                }).fail(function() {
                    alert( "SKU atau Kode Produk Tidak Boleh Kosong" );
                });
            } else {

                alert( "SKU atau Kode Produk Tidak Boleh Kosong atau Data Belum Ada di Database" );
            }
            
        });

       
        // saat tombol salin ditekan
        $("#salin-pricelist").bind("click", function(event) {
            if($('#kode_prod').val() == $('#kode_lama').val()){
                alert('SKU tidak boleh sama')
            }else{
            
                var url = "pricelist.salin.php";
                var qty = [];
                var nmr = [];
                var hrg = [];
                i = 0; 
                j = 1;
                // mengambil nilai dari inputbox, textbox dan select
                var kode_prod       = $('input:text[name=kode_prod]').val();
                var kode_lama       = $('input:text[name=kode_lama]').val();
                var text_gbr_prod   = $('#gambar_text').val();
                var kat_prod        = $('select[name=ktg_prod]').val();
                var judul_prod      = $('textarea[name=judul_prod]').val();
                var nama_alias      = $('textarea[name=nama_alias]').val();
                var deskripsi_prod  = $('textarea[name=deskripsi_prod]').val();
                var harga_prod      = $('input:text[name=harga_prod]').val();

                $('input:checkbox[name^=cb]').each(function() {
                    nmr[i] = $('input:hidden[name=nmr_'+j+']').val();
                    qty[i] = $('input:text[name=qty_'+j+']').val();
                    hrg[i] = $('input:text[name=hrg_'+j+']').val();
                    i++;
                    j++;
                });
                //console.log(kat_prod);
                var harga_10_prod   = $('input:text[name=harga_10_prod]').val();
                var harga_up_blanja = $('input:text[name=harga_up_blanja]').val();
                var harga_up_bhinn  = $('input:text[name=harga_up_bhinn]').val();
                var harga_up_elv 	= $('input:text[name=harga_up_elv]').val();
                var harga_up_mm		= $('input:text[name=harga_up_mm]').val();
                var harga_up_lzd 	= $('input:text[name=harga_up_lzd]').val();
                var harga_up_bb 	= $('input:text[name=harga_up_bb]').val();
                var berat_prod      = $('input:text[name=berat_prod]').val();
                var dimensi_prod    = $('input:text[name=dimensi_prod]').val();
                var link_produk     = $('input:text[name=link_prod]').val();
                var id_pricelist    = $('input:hidden[name=id_pricelist]').val();
            
                var link_web        = $('input:text[name=link_web]').val();
                var datainput       = {
                                        id_pl       : id_pricelist,
                                        txt_gbr_prod: text_gbr_prod,
                                        ktg_prod    : kat_prod,
                                        jdl_prod    : judul_prod,
                                        nama_alias  : nama_alias,
                                        des_prod    : deskripsi_prod, 
                                        hrg_prod    : harga_prod,
                                        Nmr         : nmr,
                                        Qty         : qty,
                                        Hrg         : hrg,
                                        hrg10_prod  : harga_10_prod, 
                                        up_blanja  	: harga_up_blanja,
                                        up_bhinn  	: harga_up_bhinn,
                                        up_elv  	: harga_up_elv,
                                        up_mm	  	: harga_up_mm,
                                        up_lzd	  	: harga_up_lzd,
                                        up_bb	  	: harga_up_bb,
                                        brt_prod    : berat_prod,
                                        dmnsi_prod  : dimensi_prod,
                                        link_prod   : link_produk,
                                        id          : kode_produk,
                                        kd_lama     : kode_lama,
                                        kd_prod     : kode_prod,
                                        lk_web		: link_web
                                    };
                // console.log(datainput)
                // mengirimkan data ke berkas transaksi.input.php untuk di proses
                $.post(url, datainput ,function(e) {
                        console.log(e)
                        // tampilkan data pricelist yang sudah di perbaharui
                        // ke dalam <div id="data-pricelist"></div>
                        $("#data-pl").load(main);

                        // sembunyikan modal dialog
                        $('#dialog-pl').modal('hide');

                        // kembalikan judul modal dialog
                        $("#myModalLabel").html("Tambah Data Price List");
                });
                // console.log('hi')
        }
        });
        
        $('#dialog-pl').on('hidden.bs.modal', function (e) {
            $('#salin-pricelist').hide()
            $('#hidden-pricelist').show()
            $('#simpan-pricelist').show()
        })


        // jika button clear centang ditekan
        $("#btn-clear-centang").bind("click", function(event){
            var url = "aksi_clear_centang.php";
            $.post(url, {
                nama_session : 'c_link'
            } ,function(e) {
                // console.log(e)
                $('#div-info-cek').fadeOut()
                
                $('.c_link').each(function(i, obj) {
                    $(obj).prop('checked',false)
                });
                $('#c_all').prop('checked',false)

            });
        })

        // jika modal link ditutup
        $('#dialog-link').on('hidden.bs.modal', function (e) {
            var url = "aksi_clear_centang.php";
            $.post(url, {
                nama_session : 'c_link'
            } ,function(e) {
                // console.log(e)
                $('#div-info-cek').fadeOut()
            });
        })
    });
}) (jQuery);
