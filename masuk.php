<?php
require 'function.php';
require 'cek.php';

//menambah barang baru dan update stock
if(isset($_POST['barangmasuk'])){
    $idbarang = $_POST['nama_barang'];
    $qty = $_POST['qty'];
    $penerima = $_POST['penerima'];
    //ambil data stock lama
    $ambildatastock = mysqli_query($connection, "SELECT * FROM stock WHERE idbarang='$idbarang'");
    $fetcharray = mysqli_fetch_array($ambildatastock);
    $stock = $fetcharray['stock'];
    //tambahkan stock baru dengan stock lama
    $stockupdate = $stock + $qty;
    //update stock
    $addstock = mysqli_query($connection, "UPDATE stock SET stock='$stockupdate' WHERE idbarang='$idbarang'");
   
    $addtomasuk = mysqli_query($connection, "INSERT INTO masuk (idbarang, qty, penerima) VALUES ('$idbarang', '$qty', '$penerima')");
    if (!$addtomasuk && !$addstock) {
        die("Query Error: " . mysqli_error($connection));
    }
    header("Location: masuk.php");
    exit();
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
    <title>Barang Masuk</title>
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
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Keluar
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
                    <h1 class="mt-4">Barang Masuk</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Barang
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jenis</th>
                                        <th>Stock</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Ronin Jeju orange 60ml</td>
                                        <td>Liquid Freebase</td>
                                        <td>6pcs</td>
                                        <td>115000</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Bequ orange 60ml</td>
                                        <td>Liquid Freebase</td>
                                        <td>6pcs</td>
                                        <td>115000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
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
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Barang Masuk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <select name="nama_barang" class="form-control">
                        <?php
                            $ambilsemuadata = mysqli_query($connection, "SELECT * FROM stock");
                            while($fetcharray = mysqli_fetch_array($ambilsemuadata)){
                                $namabarang = $fetcharray['namabarang'];
                                $idbarang = $fetcharray['idbarang'];
                                ?>                      
                            <option value="<?=$idbarang;?>"><?=$namabarang?></option>          
                        <?php
                            }
                        ?>
                    </select>
                    <br>
                    <select name="jenis_barang" class="form-control">
                    <?php
                            $ambilsemuadata = mysqli_query($connection, "SELECT * FROM stock");
                            while($fetcharray = mysqli_fetch_array($ambilsemuadata)){
                                $jenis = $fetcharray['jenis'];
                                $idbarang = $fetcharray['idbarang'];
                                ?>                      
                            <option value="<?=$idbarang;?>"><?=$jenis?></option>          
                        <?php
                            }
                        ?>
                    </select>
                    <br>
                    <input type="number" name="qty" placeholder="Quantity" class="form-control" require>
                    <br>
                    <input type="text" name="penerima" placeholder="Penerima" class="form-control" require>
                    <br>
                    <button type="submit" class="btn btn-primary" name="barangmasuk">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>
</html>