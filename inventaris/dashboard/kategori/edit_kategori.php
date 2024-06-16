<?php
session_start();
include "/xampp/htdocs/inventaris/koneksi.php";

if (!isset($_SESSION['user_id'])){
    header("Location: /inventaris/login.php");
}

$data_kategori = $conn->query("SELECT * FROM kategori WHERE id = {$_GET['id']}")->fetch_assoc()['kategori'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventaris/css/bootstrap.css">
    <title>Edit Kategori</title>

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
                    <h3 class="text-white">Edit Kategori</h3>
                    <!-- <a href=""></a> -->
                </div>

                <form action="" class="col-4 d-flex flex-column my-3" method="post">
                    <div class="">
                        <label class="fw-bold text-white" for="nama">Kategori</label>
                        <input class="form-control" type="text" name="kategori" id="nama" placeholder="Kategori" value="<?=$data_kategori?>">
                    </div>

                    <button class="btn bg-success-2 text-white mb-1 mt-2" type="submit" name="edit">Edit Kategori</button>

                    <a class="btn bg-danger-2 text-white text-white" href="crud_kategori.php">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

<?php

if (isset($_POST['edit'])){
    if (!empty($_POST['kategori'])){
        $update = "UPDATE kategori SET kategori = ? WHERE id = ?";
        $params = [$_POST['kategori'], $_GET['id']];
        $status = $conn->execute_query($update, $params);

        if ($status = true){
            echo "
            <script>
                alert('Success, Mengubah Kategori')
                window.location.href = 'crud_kategori.php'
            </script>";  
        } else {
            echo "<script>alert('Failed, Edit Kategori')</script>";
        }
    }
}