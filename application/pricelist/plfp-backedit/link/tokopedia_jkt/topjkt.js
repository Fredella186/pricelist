(function($) {
    $(document).ready(function(){
        var link_url = "topjkt.data.php";

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
            var url = "topjkt.form.php";
            var id_tpd = this.id;

            if(id_tpd == 0)
                $("#myModalLabel").html("Tambah Data Link Tokopedia Jakarta");

            $.post(url, {id: id_tpd} ,function(data) {
                $(".modal-body").html(data).show();
            });
        });

        $("#simpan-link").bind("click", function(event) {
            var url = "topjkt.input.php";

            var id_tpd      = $('input:hidden[name=id_tpd]').val();
            var kode_prod   = $('input:text[name=kode_prod]').val();
            var link_prod1  = $('input:text[name=link_prod1]').val();
            var link_prod2  = $('input:text[name=link_prod2]').val();

            $.post(url, {
                id          : id_tpd,
                link_1      : link_prod1,
                link_2      : link_prod2,
                kd_prod     : kode_prod} ,function() {
                    $("#data-link").load(link_url);
                    $('#dialog-link').modal('hide');
                    $("#myModalLabel").html("Tambah Data Link");
            });
        });
    });
}) (jQuery);
