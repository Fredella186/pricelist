(function($) {
    $(document).ready(function(){
        var link_url = "matahari.data.php";

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
            var url = "matahari.form.php";
            var id_mm = this.id;

            if(id_mm == 0)
                $("#myModalLabel").html("Tambah Data Link MatahariMall");

            $.post(url, {id: id_mm} ,function(data) {
                $(".modal-body").html(data).show();
            });
        });

        $("#simpan-link").bind("click", function(event) {
            var url = "matahari.input.php";

            var id_mm       = $('input:hidden[name=id_mm]').val();
            var kode_prod   = $('input:text[name=kode_prod]').val();
            var link_produk = $('input:text[name=link_prod]').val();

            $.post(url, {
                id          : id_mm,
                link_prod   : link_produk,
                kd_prod     : kode_prod} ,function() {
                    $("#data-link").load(link_url);
                    $('#dialog-link').modal('hide');
                    $("#myModalLabel").html("Tambah Data Link");
            });
        });
    });
}) (jQuery);
