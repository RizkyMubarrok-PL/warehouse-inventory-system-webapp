<?php
session_start();
include "/xampp/htdocs/inventaris/koneksi.php";

if (!isset($_SESSION['user_id'])){
    header("Location: /inventaris/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventaris/css/bootstrap.css">
    <title>Add Barang</title>

    <?php include "/xampp/htdocs/inventaris/style.php"?>
</head>
<body class="row bg-primary-2">
    <div class="col-2 bg-secondary-2">
        <?php
        if ($_SESSION['role'] == 'admin'){
            include "/xampp/htdocs/inventaris/layouts/sidebar.php";
        } else {
            include "/xampp/htdocs/inventaris/layouts/sidebar_user.php";
        }
        ?>
    </div>

    <div class="col-10">
        <div class="row">
            <div class="col-12 d-flex shadow justify-content-end">
                <a class="btn bg-danger-2 text-white my-2 mx-3" href="/inventaris/logout.php">Logout</a>
            </div>
        </div>

        <div class="container-fluid my-5 ">
            <div class="row d-flex bg-secondary-2 rounded-top">
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h3 class="text-white">Create Barang</h3>
                    <!-- <a href=""></a> -->
                </div>

                <form action="" class="col-4 d-flex flex-column my-3" method="post">
                    <div class="">
                        <label class="fw-bold text-white" for="nama">Nama</label>
                        <input class="form-control" type="text" name="nama" id="nama">
                    </div>

                    <div class="my-3">
                        <label class="fw-bold text-white" for="harga">Harga</label>
                        <input class="form-control" type="number" name="harga" id="harga">
                    </div>

                    <div class="">
                        <label class="fw-bold text-white" for="stok">Stok</label>
                        <input class="form-control" type="number" name="stok" id="stok">
                    </div>

                    <div class="my-3">
                        <select class="form-select" name="kategori" id="" >
                            <option value="">Pilih Kategori</option>
                            <?php
                            $data_kategori = $conn->query("SELECT * FROM kategori")->fetch_all(MYSQLI_ASSOC);
                            foreach ($data_kategori as $data){
                                echo "<option value='{$data['id']}'>{$data['kategori']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button class="btn bg-success-2 text-white my-2" type="submit" name="create">Create Barang</button>
                    <a class="btn bg-danger-2 text-white fw-bold" href="/inventaris/dashboard/barang/crud_barang.php">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

<?php

if (isset($_POST['create'])){
    if (!empty($_POST['nama']) || !empty($_POST['harga']) || !empty($_POST['stok'])){
        $insert_barang = "INSERT INTO barang (nama, harga, kategori_id) VALUES (?, ?, ?)";
        $params = [$_POST['nama'], $_POST['harga'], $_POST['kategori']];
        $status_barang = $conn->execute_query($insert_barang, $params);

        $new_barang_id = $conn->insert_id;

        $insert_stok = "INSERT INTO stock (barang_id, stok) VALUES (?, ?)";
        $params = [$new_barang_id, $_POST['stok']];
        $status_stok = $conn->execute_query($insert_stok, $params);

        $insert_pencatatan = "INSERT INTO pencatatan_barang (users_id, tanggal, jenis_catatan) VALUES (?, NOW(), ?)";
        $params = [$_SESSION['user_id'], 'masuk'];
        $status_pencatatan = $conn->execute_query($insert_pencatatan, $params);

        $new_pencatatan_id = $conn->insert_id;

        $insert_detail = "INSERT INTO detail_pencatatan (pencatatan_id, barang_id, jumlah_barang, total_harga) VALUES (?, ?, ?, ?)";
        $total_harga = $_POST['stok'] * $_POST['harga'];
        $params = [$new_pencatatan_id, $new_barang_id, $_POST['stok'], $total_harga];
        $status_detail = $conn->execute_query($insert_detail, $params);

        if ($status_barang && $status_stok && $status_pencatatan && $status_detail){
            echo "
            <script>
                alert('Success, Membuat Barang')
                window.location.href = 'crud_barang.php'
            </script>";  
        } else {
            echo "<script>alert('Failed, Create Barang')</script>";
        }
    }
}