(function($) {
    $(document).ready(function(){
        var link_url = "lazada.data.php";

        $('#data-link').load(link_url);

        $('#btnCari').on('click',function(e){
            var cari = $('input:text[name=cari]').val();

            if (cari != "" && cari.length > 2) {
                $.post(link_url, {src: cari} ,function(data) {
                    $("#data-link").html(data).show();
                });
            } else {
                $("#data-link").load(link_url);
            }
        });

        $('.tambah').on("click", function(){
            var url = "lazada.form.php";
            var id_lzd = this.id;

            if(id_lzd == 0)
                $("#myModalLabel").html("Tambah Data Link Lazada");

            $.post(url, {id: id_lzd} ,function(data) {
                $(".modal-body").html(data).show();
            });
        });

        $("#simpan-link").on("click", function() {
            var url = "lazada.input.php";

            var id_lzd      = $('input:hidden[name=id_lazada]').val();
            var kode_prod   = $('input:text[name=kode_prod]').val();
            var link_produk = $('input:text[name=link_prod]').val();

            $.post(url, {
                id          : id_lzd,
                link_prod   : link_produk,
                kd_prod     : kode_prod} ,function() {
                    $("#data-link").load(link_url);
                    $('#dialog-link').modal('hide');
                    $("#myModalLabel").html("Tambah Data Link");
            });
        });
    });
}) (jQuery);
