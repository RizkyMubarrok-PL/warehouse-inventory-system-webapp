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
            <div class="row d-flex bg-secondary-2 rounded px-3 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="text-white">CRUD Barang</h3>
                    <a class="btn text-white bg-success-2" href="create_barang.php">Create Barang</a>
                </div>

                <div class="table-responsive-sm my-2">
                    <table class="col-12 table">
                        <thead>
                            <th>Nama</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Action</th>
                        </thead>
                    
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM barang";
                            $data_barang = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
                            foreach ($data_barang as $data) {
                                $kategori = $conn->query("SELECT * FROM kategori WHERE id = {$data['kategori_id']}")->fetch_assoc()['kategori'];
                                echo "
                                <tr>
                                    <td>{$data['nama']}</td>
                                    <td>{$data['harga']}</td>
                                    <td>$kategori</td>
                                    <td>
                                        <a class='btn bg-success-2 text-white' href='edit_barang.php?id={$data['id']}'>Edit</a>
                                        <a class='btn bg-danger-2 text-white' id='delete' href='delete_barang.php?id={$data['id']}'>Delete</a>
                                    </td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const deletebtn = document.getElementById("delete");
        deletebtn.addEventListener('click', () => {
            const statusConfirm = confirm("Are you sure?");

            if (statusConfirm){
                window.location.href = "delete_kategori.php?id=<?=$data['id']?>";
            }
        });          
    </script>

</body>