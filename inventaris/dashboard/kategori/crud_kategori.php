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
    <title>CRUD Kategori</title>

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
            <div class="row bg-secondary-2 rounded px-3 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="text-white">CRUD Kategori</h3>
                    <a class="btn text-white bg-success-2" href="create_kategori.php">Create Kategori</a>
                </div>

                <table class="col-6 table my-2">
                    <thead>
                        <th>Nama</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php
                        $sql = "SELECT * FROM kategori";
                        $data_kategori = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
                        foreach ($data_kategori as $data) {
                            echo "
                            <tr>
                                <td>{$data['kategori']}</td>
                                <td>
                                    <a class='btn bg-secondary-2 text-white' href='edit_kategori.php?id={$data['id']}'>Edit</a>
                                    <a class='btn bg-danger-2 text-white' id='delete' class='btn text-white btn-danger'>Delete</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

    <script>
        const deletebtn = document.getElementById("delete");
        deletebtn.addEventListener('click', () => {
            const statusConfirm = confirm("Are you sure?");

            if (statusConfirm){
                window.location.href = "delete_kategori.php?id=<?=$data['id']?>";
            }
        });          
    </script>
</html>