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

    <!-- Custom fonts for this template -->
    <link href="<?= base_url('assets/')?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="<?= base_url('assets/')?>https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/')?>css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?= base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top" style="overflow:scroll;">

    <!-- Page Wrapper -->
    <div id="wrapper">

                
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div style="display:flex; gap:50px; margin-left:20px; margin-top:20px;">
                        <form method="GET" action="" >
                        <input type="submit" id="submitButton" onclick="toggleOptions()" class="btn btn-primary" value="Kategori"></input>
                            <select name="kategori" id="kategoriSelect" style="display:none;" onchange="updateButton(this)">
                                <?php
                                $sql = "SELECT * FROM tb_kategori";
                                $query_ktg = mysqli_query($conn, $sql);
                                while ($kategori = mysqli_fetch_array($query_ktg)) {
                                    echo '<option value="' . $kategori['id_ktg'] . '">' . htmlentities($kategori['nama_ktg']) . '</option>';
                                }
                                ?>
                            </select>
                            

                            <script>
                                function toggleOptions() {
                                    var selectElement = document.getElementById("kategoriSelect");
                                    if (selectElement.style.display === "none") {
                                        selectElement.style.display = "block";
                                    } else {
                                        selectElement.style.display = "none";
                                    }
                                }

                                function updateButton(selectElement) {
                                    var selectedOption = selectElement.options[selectElement.selectedIndex].text;
                                    var submitButton = document.getElementById("submitButton");
                                    submitButton.innerHTML = "Submit: " + selectedOption;
                                }
                            </script>
                        </form>



                            <a href="#" class="btn btn-info">Jasa</a>
                            <a href="#" class="btn btn-warning">Share Halaman Ini</a>
                        </div>
                        <div class="card-body">
                    
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tr class="success">
                                <th rowspan='2' style="text-align:center; width:15px;">No</th>
                                <th rowspan='2' style="text-align:center;" hidden>id</th>
                                <th rowspan='2' style=" width:10px; text-align:center; ">Gambar</th>
                                <th rowspan='2' style="text-align:center; width:50px;">Judul <i class="fas fa-exchange-alt"></i></th>
                                <th rowspan='2' style="text-align:center;">SKU <i class="fas fa-exchange-alt"></th>
                                <th rowspan='2' style="text-align:center;" class='th-kategori' hidden>Kategori <i class="fas fa-exchange-alt"></i></th>
                                <th colspan='3' style="text-align:center;">Harga Jawa</i></th>
                                <th colspan='2' style="text-align:center;">Harga Luar Jawa</i></th>
                                <th rowspan='2' style="text-align:center;">Berat</th>
                                <th rowspan='2' style="text-align:center; width:50px;">Link</th>
                                <th rowspan='2' style="text-align:center;">Hit</th>
                                <!-- <th>SKU</th> -->
                                </tr>
                                <tr>
                                <th class="text-center success">SBY</th>
                                <th class="text-center success">JKT</th>
                                <th class="text-center success">BDG</th>
                                <th class='text-center 'style="background:#DC5F00;color:white">MKS</th>
                                <th class='text-center 'style="background:#DC5F00;color:white">MDN</th>
                                </tr>
                                    <tbody>
                                        <?php
                                            $no  = 1;
                                            $sql = "select * from tb_pricelist";
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
                                            <td><?php echo $gambar; ?></td>
                                            <td><?php echo $judul ?></td>
                                            <td>SKU</td>
                                            <td colspan='3'><?php echo $harga_jawa; ?></td>
                                            <td colspan='2'><?php echo $harga_luar; ?></td>
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
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/')?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/')?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/')?>js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets/')?>js/demo/datatables-demo.js"></script>
    
</body>

</html>




