<?php
session_start();
include "/xampp/htdocs/inventaris/koneksi.php";

if (!isset($_SESSION['user_id'])){
    header("Location: /inventaris/login.php");
}

$sql_barang = "SELECT * FROM barang WHERE id = {$_GET['id']}";
$data_barang = $conn->query($sql_barang)->fetch_assoc();

$sql_kategori = "SELECT * FROM kategori WHERE id = {$data_barang['kategori_id']}";
$data_kategori = $conn->query($sql_kategori)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventaris/css/bootstrap.css">
    <title>Edit Barang</title>

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
                    <h3 class="text-white">Edit Barang</h3>
                    <!-- <a href=""></a> -->
                </div>



                <form action="" class="col-7 d-flex my-3 flex-column" method="post"> 
                    <div>
                        <label class="text-white fw-bold" for="nama">Nama</label>
                        <input class="form-control" type="text" name="nama" id="nama" value="<?=$data_barang['nama']?>">
                    </div>

                    <div class="my-3">
                        <label class="text-white fw-bold" for="harga">Harga</label>
                        <input class="form-control" type="number" name="harga" id="harga" value="<?=$data_barang['harga']?>">
                    </div>

                    <div class="">
                    <label class="text-white fw-bold" for="kategori">Kategori</label>
                        <select class="form-select" name="kategori" id="kategori" >
                            <option value="<?=$data_kategori['id']?>"><?=$data_kategori['kategori']?></option>
                            <option value="">Pilih Kategori</option>
                            <?php
                            $data_kategori = $conn->query("SELECT * FROM kategori")->fetch_all(MYSQLI_ASSOC);
                            foreach ($data_kategori as $data){
                                echo "<option value='{$data['id']}'>{$data['kategori']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button class="btn bg-success-2 text-white mt-2" type="submit" name="edit">Add Barang</button>
                    <a class="btn bg-danger-2 text-white fw-bold" href="/inventaris/dashboard/barang/crud_barang.php">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

<?php

if (isset($_POST['edit'])){
    if (!empty($_POST['nama']) || !empty($_POST['harga']) || !empty($_POST['kategori'])){
        $update = "UPDATE barang SET nama = ? , harga = ? , kategori_id = ? WHERE id = ?";
        $params = [$_POST['nama'], $_POST['harga'], $_POST['kategori'], $_GET['id']];
        $status_update = $conn->execute_query($update, $params);

        if ($status_update){
            echo "
            <script>
                alert('Success, Mengubah Barang')
                window.location.href = 'crud_barang.php'
            </script>";  
        } else {
            echo "<script>alert('Failed, Update Barang')</script>";
        }
    }
}