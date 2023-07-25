<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Fast Print</title>
        <link rel="stylesheet" href="<?php echo base_url().'assets/css/style.css';?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    </head>
    <body id="page-top" style="overflow:scroll;">
        <!-- Tabel untuk menampilkan data -->
        <table id="myTable" class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr class="success">
                <!-- Isi kolom header sesuai dengan data yang diinginkan -->
                <th rowspan="2" style="text-align:center; width:15px;">No</th>
                <th rowspan="2" style="text-align:center;" hidden>id</th>
                <th rowspan="2" style="width:10px; text-align:center;">Gambar</th>
                <th rowspan="2" style="text-align:center; width:50px;">Judul <i class="fas fa-exchange-alt"></i></th>
                <th rowspan="2" style="text-align:center;">SKU <i class="fas fa-exchange-alt"></i></th>
                <th rowspan="2" style="text-align:center;" class="th-kategori" hidden>Kategori <i class="fas fa-exchange-alt"></i></th>
                <th colspan="3" style="text-align:center;">Harga Jawa</th>
                <th colspan="2" style="text-align:center;">Harga Luar Jawa</th>
                <th rowspan="2" style="text-align:center;">Berat</th>
                <th rowspan="2" style="text-align:center; width:50px;">Link</th>
                <th rowspan="2" style="text-align:center;">Hit</th>
            </tr>
            <tr>
                <!-- Isi kolom header sesuai dengan data yang diinginkan -->
                <th class="text-center success">SBY</th>
                <th class="text-center success">JKT</th>
                <th class="text-center success">BDG</th>
                <th class="text-center" style="background:#DC5F00;color:white">MKS</th>
                <th class="text-center" style="background:#DC5F00;color:white">MDN</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($tb_pricelist as $kategori):
                ?>
            <tr>
                <!-- Isi data untuk setiap kolom sesuai dengan data yang ingin ditampilkan -->
                <td><?php echo $no; ?></td>
                <td hidden><?php echo $kategori->id_pricelist; ?></td>
                <td><?php echo $kategori->gambar_produk; ?></td>
                <td><?php echo $kategori->judul_produk; ?></td>
                <td><?php echo $kategori->kode_produk; ?></td>
                <td hidden><?php echo $kategori->ktg_produk; ?></td>
                <td><?php echo $kategori->harga; ?></td>
                <td><?php echo $kategori->harga; ?></td>
                <td><?php echo $kategori->harga; ?></td>
                <td><?php echo $kategori->harga_luar_jawa; ?></td>
                <td><?php echo $kategori->harga_luar_jawa; ?></td>
                <td><?php echo $kategori->berat_produk; ?></td>
                <td><?php echo $kategori->link_produk; ?></td>
                <td><?php echo $kategori->hit; ?></td>
            </tr>
            <?php
            $no++;
        endforeach;
        ?>
        </tbody>
    </table>

    <!-- JavaScript untuk mengaktifkan fungsi DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready( function() {
            $('#myTable').DataTable();
        });
    </script>
</body>
</html>
