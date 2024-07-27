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

//update barang masuk
if(isset($_POST['updatebarang'])){
    $qty = $_POST['qty'];
    $penerima = $_POST['penerima'];
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $qtyskrg = $_POST['qtyskrg'];
    $idbarang = $_POST['nama_barang'];
    //ambil data stock lama
    $ambildatastock = mysqli_query($connection, "SELECT * FROM stock WHERE idbarang='$idbarang'");
    $fetcharray = mysqli_fetch_array($ambildatastock);
    $stock = $fetcharray['stock'];

    $stockskrng = mysqli_query($connection, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $fetcharray = mysqli_fetch_array($stockskrng);
    $stockskrng = $fetcharray['qty'];

    //kurangi stock lama dengan stock baru
    if($qty > $qtyskrg){
        $selisih = $qty - $qtyskrg;
        $stockupdate = $stock + $selisih;
        $kuranginstocknya = mysqli_query($connection, "UPDATE stock SET stock='$stockupdate' WHERE idbarang='$idbarang'");
        $updatenya = mysqli_query($connection, "UPDATE masuk SET qty='$qty', penerima='$penerima', idbarang='$idbarang' WHERE idmasuk='$idm'");
        if (!$kuranginstocknya && !$updatenya) {
            die("Query Error: " . mysqli_error($connection));
        }else{
            header("Location: masuk.php");
            exit();
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $stockupdate = $stock - $selisih;
        $kuranginstocknya = mysqli_query($connection, "UPDATE stock SET stock='$stockupdate' WHERE idbarang='$idbarang'");
        $updatenya = mysqli_query($connection, "UPDATE masuk SET qty='$qty', penerima='$penerima', idbarang='$idbarang' WHERE idmasuk='$idm'");
        if (!$kuranginstocknya && !$updatenya) {
            die("Query Error: " . mysqli_error($connection));
        }else{
            header("Location: masuk.php");
            exit();
        }
    }
 
}

//hapus barang masuk
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $qtyskrg = $_POST['qtyskrg'];
    $idbarang = $_POST['nama_barang'];
    //ambil data stock lama
    $ambildatastock = mysqli_query($connection, "SELECT * FROM stock WHERE idbarang='$idb'");
    $fetcharray = mysqli_fetch_array($ambildatastock);
    $stock = $fetcharray['stock'];
    //kurangi stock lama dengan stock baru
    $stockupdate = $stock - $qtyskrg;
    //update stock
    $addstock = mysqli_query($connection, "UPDATE stock SET stock='$stockupdate' WHERE idbarang='$idb'");
    $hapusbarang = mysqli_query($connection, "DELETE FROM masuk WHERE idmasuk='$idm'");
    if (!$hapusbarang && !$addstock) {
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
                                        <th>Gambar</th>
                                        <th>Nama Barang</th>
                                        <th>Jenis</th>
                                        <th>Qty</th>
                                        <th>Tanggal</th>
                                        <th>Penerima</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ambilsemuadatastock = mysqli_query($connection, "SELECT * FROM masuk m, stock s WHERE s.idbarang = m.idbarang");
                                    $i = 1;
                                    while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                        $image = $data['image'];
                                        if ($image == null) {
                                            $image = "No photo";
                                        } else {
                                            $image = '<img src="images/' . $image . '" width="50px" height="50px">';
                                        }
                                        $namabarang = $data['namabarang'];
                                        $jenisbarang = $data['jenis'];
                                        $qty = $data['qty'];
                                        $tanggal = $data['tanggal'];
                                        $penerima = $data['penerima'];
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $image; ?></td>
                                            <td><?= $namabarang; ?></td>
                                            <td><?= $jenisbarang; ?></td>
                                            <td><?= $qty; ?></td>
                                            <td><?= $tanggal; ?></td>
                                            <td><?= $penerima; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $data['idmasuk']; ?>">
                                                    Edit
                                                </button>
                                                <input type="hidden" class="idmasuk<?= $data['idmasuk']; ?>" value="<?= $data['idmasuk']; ?>">
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $data['idmasuk']; ?>">
                                                    Delete
                                                </button>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?= $data['idmasuk']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Barang Masuk</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <select name="nama_barang" class="form-control">
                                                                <?php
                                                                $ambilsemuadata = mysqli_query($connection, "SELECT * FROM stock");
                                                                while ($fetcharray = mysqli_fetch_array($ambilsemuadata)) {
                                                                    $namabarang = $fetcharray['namabarang'];
                                                                    $idbarang = $fetcharray['idbarang'];
                                                                ?>
                                                                    <option value="<?= $idbarang; ?>"><?= $namabarang ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <br>
                                                            <input type="number" name="qty" value="<?= $qty; ?>" class="form-control" require>
                                                            <br>
                                                            <input type="hidden" name="idb" value="<?= $data['idbarang']; ?>">
                                                            <input type="hidden" name="idm" value="<?= $data['idmasuk']; ?>">
                                                            <input type="hidden" class="qtyskrg<?= $data['idmasuk']; ?>" value="<?= $data['qty']; ?>">
                                                            <input type="text" name="penerima" value="<?= $penerima; ?>" class="form-control" require>
                                                            <br>
                                                            <button type="submit" class="btn btn-primary" name="updatebarang">Update</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?= $data['idmasuk']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Barang Masuk</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus <?= $namabarang; ?>?
                                                            <input type="hidden" name="idb" value="<?= $data['idbarang']; ?>">
                                                            <input type="hidden" name="idm" value="<?= $data['idmasuk']; ?>">
                                                            <input type="hidden" name="qtyskrg" value="<?= $data['qty']; ?>">
                                                            <input type="hidden" name="nama_barang" value="<?= $data['idbarang']; ?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
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