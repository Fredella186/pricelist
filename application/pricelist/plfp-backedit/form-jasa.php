<form action="simpan-jasa.php?id=<?=$_GET['id']?>" method="post">
    <?php
     include "connect.php";
     buka_koneksi(); 
        $jasa = "";
        $susah = "";
        $harga = "";
        $ket = "";
        if(isset($_GET['id']) && $_GET['id']!==''){

            $query = mysql_query("select * from tb_jasa where id_jasa = '{$_GET['id']}'");
            $f = mysql_fetch_assoc($query);
            $jasa   = $f['nama_kerusakan'];
            $susah  = $f['tingkat_kesusahan'];
            $harga  = $f['harga'];
            $ket    = $f['keterangan'];

        }

    ?>


    Nama Kerusakan
    <input type="text" class="form-control" name="jasa" value="<?=$jasa?>">
    Tingkat Kesulitan
    <input type="text" class="form-control" name="sulit"  value="<?=$susah?>">
    Harga
    <input type="text" class="form-control" id='rupiah'  value="<?="Rp. " . number_format($harga, 0, ".", ".");?>">
    <input type="hidden" class="form-control" id="rupiah2" name="harga" value="<?=$harga?>">
    Keterangan
    <textarea class="form-control" name="keterangan"><?=$ket?></textarea>
    <br>    
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    <input type="submit" value="SIMPAN" class="btn btn-primary">
    

</form>

<script>
var rupiah = document.getElementById('rupiah');
var rupiah2 = document.getElementById('rupiah2');
		rupiah.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
			// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            torupiah  = formatRupiah(this.value, 'Rp. ');
			rupiah.value = torupiah
            balikin = torupiah.replace(/Rp.| |\./g,"");
			rupiah2.value = balikin;

		});
 
		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
</script>