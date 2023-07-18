(function($) {
    $(document).ready(function(){
        var link_url = "blibli.data.php";

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
            var url = "blibli.form.php";
            var id_bli = this.id;

            if(id_bli == 0)
                $("#myModalLabel").html("Tambah Data Link BliBli");

            $.post(url, {id: id_bli} ,function(data) {
                $(".modal-body").html(data).show();
            });
        });

        $("#simpan-link").bind("click", function(event) {
            var url = "blibli.input.php";

            var id_bli      = $('input:hidden[name=id_bli]').val();
            var kode_prod   = $('input:text[name=kode_prod]').val();
            var link_produk = $('input:text[name=link_prod]').val();

            $.post(url, {
                id          : id_bli,
                link_prod   : link_produk,
                kd_prod     : kode_prod} ,function() {
                    $("#data-link").load(link_url);
                    $('#dialog-link').modal('hide');
                    $("#myModalLabel").html("Tambah Data Link");
            });
        });
    });
}) (jQuery);
