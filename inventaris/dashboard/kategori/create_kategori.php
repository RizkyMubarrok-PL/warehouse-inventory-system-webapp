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
    <title>Create Kategori</title>

    <?php include "/xampp/htdocs/inventaris/style.php"?>
</head>
<body class="row bg-primary-3">
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
                    <h3 class="text-white">Create Kategori</h3>
                    <!-- <a href=""></a> -->
                </div>

                <form action="" class="col-4 d-flex flex-column my-3" method="post">
                    <div class="">
                        <label class="fw-bold text-white" for="nama">Nama</label>
                        <input class="form-control" type="text" name="nama" id="nama" placeholder="Kategori">
                    </div>

                    <button class="btn bg-success-2 text-white mb-1 mt-2" type="submit" name="create">Create Kategori</button>

                    <a class="btn bg-danger-2 text-white" href="crud_kategori.php">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

<?php

if (isset($_POST['create'])){
    if (!empty($_POST['nama'])){
        $insert = "INSERT INTO kategori (kategori) VALUES (?)";
        $params = [$_POST['nama']];
        $status = $conn->execute_query($insert, $params);

        if ($status = true){
            echo "
            <script>
                alert('Success, Membuat Kategori')
                window.location.href = 'crud_kategori.php'
            </script>";  
        } else {
            echo "<script>alert('Failed, Create Kategori')</script>";
        }
    }
}