(function($) {
    $(document).ready(function(){
        var link_url = "blsby.data.php";

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
            var url = "blsby.form.php";
            var id_bl = this.id;

            if(id_bl == 0)
                $("#myModalLabel").html("Tambah Data Link Bukalapak Surabaya");

            $.post(url, {id: id_bl} ,function(data) {
                $(".modal-body").html(data).show();
            });
        });

        $("#simpan-link").bind("click", function(event) {
            var url = "blsby.input.php";

            var id_bl      = $('input:hidden[name=id_bl]').val();
            var kode_prod   = $('input:text[name=kode_prod]').val();
            var link_produk = $('input:text[name=link_prod]').val();

            $.post(url, {
                id          : id_bl,
                link_prod   : link_produk,
                kd_prod     : kode_prod} ,function() {
                    $("#data-link").load(link_url);
                    $('#dialog-link').modal('hide');
                    $("#myModalLabel").html("Tambah Data Link");
            });
        });
    });
}) (jQuery);
