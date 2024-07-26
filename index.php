<?php
require 'function.php';
require 'cek.php';

//menambah barang baru
if (isset($_POST['submit'])) {
    $namabarang = $_POST['namabarang'];
    $jenis = $_POST['jenis'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $allowed_ext = array('png', 'jpg', 'jpeg');
    $file_name = $_FILES['file']['name'];
    $dot = explode('.', $file_name);
    $file_ext = strtolower(end($dot));
    $size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $image = md5(uniqid($file_name, true) . time()) . '.' . $file_ext;

    //cek barang sudah ada atau belum
    $cek = mysqli_query($connection, "SELECT * FROM stock WHERE namabarang='$namabarang'");
    $hitung = mysqli_num_rows($cek);

    if ($hitung < 1) {
        if (in_array($file_ext, $allowed_ext) === true) {
            if ($size < 1044070) {
                move_uploaded_file($file_tmp, 'images/' . $image);
                $sql = "INSERT INTO stock (namabarang, jenis, stock, harga, image) VALUES ('$namabarang', '$jenis', '$stock', '$harga', '$image')";
                $result = mysqli_query($connection, $sql);
                if (!$result) {
                    die("Query Error: " . mysqli_error($connection));
                }
                header("Location: index.php");
                exit();
            } else {
                echo '<script>
                alert("Ukuran File Terlalu Besar!");
                window.location.href ="index.php";
                </script>';
            }
        } else {
            echo '<script>
            alert("Ekstensi File Tidak Diperbolehkan!");
            window.location.href ="index.php";
            </script>';
        }
    } else {
        echo '<script>
        alert("Barang Sudah Terdaftar!");
        window.location.href ="index.php";
        </script>';
    }
}

//update barang
if (isset($_POST['updatebarang'])) {
    $idbarang = $_POST['idbarang'];
    $namabarang = $_POST['namabarang'];
    $jenis = $_POST['jenis'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $allowed_ext = array('png', 'jpg', 'jpeg');
    $file_name = $_FILES['file']['name'];
    $dot = explode('.', $file_name);
    $file_ext = strtolower(end($dot));
    $size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $image = md5(uniqid($file_name, true) . time()) . '.' . $file_ext;

    if ($file_name == null) {
        $sql = "UPDATE stock SET namabarang='$namabarang', jenis='$jenis', stock='$stock', harga='$harga' WHERE idbarang='$idbarang'";
        $result = mysqli_query($connection, $sql);
        if (!$result) {
            die("Query Error: " . mysqli_error($connection));
        }
        header("Location: index.php");
        exit();
    } else {
        if (in_array($file_ext, $allowed_ext) === true) {
            if ($size < 1044070) {
                move_uploaded_file($file_tmp, 'images/' . $image);
                $sql = "SELECT * FROM stock WHERE idbarang='$idbarang'";
                $result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_array($result);
                unlink("images/" . $row['image']);

                $sql = "UPDATE stock SET namabarang='$namabarang', jenis='$jenis', stock='$stock', harga='$harga', image='$image' WHERE idbarang='$idbarang'";
                $result = mysqli_query($connection, $sql);
                if (!$result) {
                    die("Query Error: " . mysqli_error($connection));
                }
                header("Location: index.php");
                exit();
            } else {
                echo '<script>
                alert("Ukuran File Terlalu Besar!");
                window.location.href ="index.php";
                </script>';
            }
        } else {
            echo '<script>
            alert("Ekstensi File Tidak Diperbolehkan!");
            window.location.href ="index.php";
            </script>';
        }
    }
}

//hapus barang
if (isset($_POST['hapusbarang'])) {
    $idbarang = $_POST['idbarang'];
    //hapus gambar
    $sql = "SELECT * FROM stock WHERE idbarang='$idbarang'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($result);
    $image = $row['image'];
    unlink("images/" . $image);

    //hapus data
    $sql = "DELETE FROM stock WHERE idbarang='$idbarang'";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        die("Query Error: " . mysqli_error($connection));
    }
    header("Location: index.php");
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
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Keluar
                        </a>
                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
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
                    <h1 class="mt-4">Stock Barang</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Barang
                            </button>
                            <a href="export.php" class="btn btn-info">Export Data</a>
                        </div>
                        <div class="card-body">
                            <?php
                            $ambildatastock = mysqli_query($connection, "SELECT * FROM stock WHERE stock < 1");
                            while ($fetch = mysqli_fetch_array($ambildatastock)) {
                                $barang = $fetch['namabarang'];

                            ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button class="close" type="button" data-bs-dismiss="alert">&times;</button>
                                    <strong>Perhatian!</strong> Stock <?= $barang; ?> Telah Habis
                                </div>
                            <?php
                            }
                            ?>

                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Nama Barang</th>
                                        <th>Jenis</th>
                                        <th>Stock</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM stock";
                                    $sql = mysqli_query($connection, $sql);
                                    $no = 1;
                                    while ($row = mysqli_fetch_array($sql)) {
                                        $image = $row['image'];
                                        if ($image == null) {
                                            $image = "No photo";
                                        } else {
                                            $image = '<img src="images/' . $image . '" width="50px" height="50px">';
                                        }
                                        $namabarang = $row['namabarang'];
                                        $jenis = $row['jenis'];
                                        $stock = $row['stock'];
                                        $harga = $row['harga'];
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $image ?></td>
                                            <td><?= $namabarang; ?></td>
                                            <td><?= $jenis; ?></td>
                                            <td><?= $stock; ?></td>
                                            <td><?= $harga; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $row['idbarang']; ?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $row['idbarang']; ?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- The Modal Edit -->
                                        <div class="modal fade" id="edit<?= $row['idbarang']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Barang</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type="text" name="namabarang" value="<?= $namabarang; ?>" class="form-control" required>
                                                            <br>
                                                            <input type="text" name="jenis" value="<?= $jenis; ?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="stock" value="<?= $stock; ?>" class="form-control" readonly>
                                                            <br>
                                                            <input type="number" name="harga" value="<?= $harga; ?>" class="form-control" required>
                                                            <br>
                                                            <input type="file" name="file" class="form-control">
                                                            <br>
                                                            <input type="hidden" name="idbarang" value="<?= $row['idbarang']; ?>">
                                                            <button type="submit" class="btn btn-primary" name="updatebarang">Update</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- The Modal Delete -->
                                        <div class="modal fade" id="delete<?= $row['idbarang']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Barang</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body                                                    ">
                                                            Apakah Anda Yakin Ingin Menghapus <?= $namabarang; ?>?
                                                            <input type="hidden" name="idbarang" value="<?= $row['idbarang']; ?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    };
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