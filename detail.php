<?php
require 'function.php';
require 'cek.php';

//get data berdasarkan id yang di pasing
$idbarang = $_GET['id'];
$get = mysqli_query($connection, "SELECT * FROM stock WHERE idbarang='$idbarang'");
$fetch = mysqli_fetch_assoc($get);

// set variabel
$namabarang = $fetch['namabarang'];
$jenis = $fetch['jenis'];
$stock = $fetch['stock'];
$harga = $fetch['harga'];
$image = $fetch['image'];
if ($image == null) {
    $image = "No photo";
} else {
    $image = '<img src="images/' . $image . '" width="130px" height="150px">';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Onevape Store</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Onevape Store</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Stock Barang
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-cloud-download"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-cloud-upload"></i></div>
                            Barang Keluar
                        </a>
                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Kelola User
                        </a>
                        <a class="nav-link" href="logout.php">
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Detail Barang</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <?= $namabarang; ?>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <?= $image; ?>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Nama Barang</td>
                                            <td><?= $namabarang; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Jenis</td>
                                            <td><?= $jenis; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Stock</td>
                                            <td><?= $stock; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Harga</td>
                                            <td><?= $harga; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <h3>Barang Masuk</h3>
                            <div class="tabel-responsive">
                            <table class="table table-bordered" id="detailmasuk" width="100%" cellspacing= "0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Qty</th>
                                        <th>Penerima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ambildatamasuk = mysqli_query($connection, "SELECT * FROM masuk  WHERE idbarang='$idbarang'");
                                    $no = 1;
                                    while ($fetch = mysqli_fetch_array($ambildatamasuk)) {
                                        $tanggal = $fetch['tanggal'];
                                        $qty = $fetch['qty'];
                                        $penerima = $fetch['penerima'];
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $tanggal; ?></td>
                                            <td><?= $qty; ?></td>
                                            <td><?= $penerima; ?></td>
                                        </tr>
                                    <?php
                                    };
                                    ?>
                                </tbody>
                            </table>
                            </div>

                            
                            <h3>Barang Keluar</h3>
                            <div class="tabel-responsive">
                            <table class="table table-bordered" id="detailkeluar" width="100%" cellspacing= "0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Qty</th>
                                        <th>Penerima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ambildatakeluar = mysqli_query($connection, "SELECT * FROM keluar  WHERE idbarang='$idbarang'");
                                    $no = 1;
                                    while ($fetch = mysqli_fetch_array($ambildatakeluar)) {
                                        $tanggal = $fetch['tanggal'];
                                        $qty = $fetch['qty'];
                                        $penerima = $fetch['penerima'];
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $tanggal; ?></td>
                                            <td><?= $qty; ?></td>
                                            <td><?= $penerima; ?></td>
                                        </tr>
                                    <?php
                                    };
                                    ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Onevape Store</div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Barang</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control">
                    <br>
                    <input type="text" name="jenis" placeholder="Jenis Barang" class="form-control" require>
                    <br>
                    <input type="number" name="stock" placeholder="Stock" class="form-control" require>
                    <br>
                    <input type="number" name="harga" placeholder="Harga" class="form-control" require>
                    <br>
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

</html>