<?php
$user = "root";
$server = "localhost";
$password = "";
$db = "pricelist";

$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
    die("Database Error!");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin 2 - Tables</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
</head>

<body id="page-top" style="overflow:scroll;">
                                <table id="myTable" class="table table-bordered"  width="100%" cellspacing="0">
                                <thead>
    <tr class="success">
        <th rowspan='2' style="text-align:center; width:15px;">No</th>
        <th rowspan='2' style="text-align:center;" hidden>id</th>
        <th rowspan='2' style="width:10px; text-align:center;">Gambar</th>
        <th rowspan='2' style="text-align:center; width:50px;">Judul <i class="fas fa-exchange-alt"></i></th>
        <th rowspan='2' style="text-align:center;">SKU <i class="fas fa-exchange-alt"></i></th>
        <th rowspan='2' style="text-align:center;" class='th-kategori' hidden>Kategori <i class="fas fa-exchange-alt"></i></th>
        <th colspan='3' style="text-align:center;">Harga Jawa</th>
        <th colspan='2' style="text-align:center;">Harga Luar Jawa</th>
        <th rowspan='2' style="text-align:center;">Berat</th>
        <th rowspan='2' style="text-align:center; width:50px;">Link</th>
        <th rowspan='2' style="text-align:center;">Hit</th>
    </tr>
    <tr>
        <th class="text-center success">SBY</th>
        <th class="text-center success">JKT</th>
        <th class="text-center success">BDG</th>
        <th class='text-center' style="background:#DC5F00;color:white">MKS</th>
        <th class='text-center' style="background:#DC5F00;color:white">MDN</th>
    </tr>
</thead>
<tbody>
    <?php
        $no = 1;
        $sql = "SELECT * FROM tb_pricelist";
        $query = mysqli_query($conn, $sql);
        while ($result = mysqli_fetch_array($query)) {
            $id = $result['id_pricelist'];
            $kode = $result['kode_produk'];
            $gambar = $result['gambar_produk'];
            $judul = $result['judul_produk'];
            $ktg = $result['ktg_produk'];
            $harga_jawa = $result['harga'];
            $harga_luar = $result['harga_luar_jawa'];
            $berat = $result['berat_produk'];
            $link = $result['link_produk'];
            $hit = $result['hit'];
    ?>
    <tr>
        <td><?php echo $no; ?></td>
        <td hidden><?php echo $id; ?></td>
        <td><?php echo $gambar; ?></td>
        <td><?php echo $judul ?></td>
        <td><?php echo $kode ?></td>
        <td hidden><?php echo $ktg ?></td>
        <td><?php echo $harga_jawa; ?></td>
        <td><?php echo $harga_jawa; ?></td>
        <td><?php echo $harga_jawa; ?></td>
        <td><?php echo $harga_luar; ?></td>
        <td><?php echo $harga_luar; ?></td>
        <td><?php echo $berat; ?></td>
        <td><?php echo $link; ?></td>
        <td><?php echo $hit; ?></td>
    </tr>
    <?php
        $no++;
        }
    ?>
</tbody>

                                </table>
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
