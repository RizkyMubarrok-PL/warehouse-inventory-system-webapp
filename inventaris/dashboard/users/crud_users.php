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
    <title>CRUD Users</title>

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
                    <h3 class="text-white">CRUD Users</h3>
                    <a class="btn text-white bg-success-2" href="create_users.php">Create Users</a>
                </div>

                <table class="col-6 table my-2">
                    <thead>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php
                        $sql = "SELECT * FROM users";
                        $data_kategori = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
                        foreach ($data_kategori as $data) {
                            echo "
                            <tr>
                                <td>{$data['username']}</td>                                
                                <td>{$data['role']}</td>
                                <td>                                    
                                    <a id='delete' class='btn bg-danger-2 text-white' href='delete_users.php?id={$data['id']}'>Delete</a>
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
        // const deletebtn = document.getElementById("delete");
        // deleteValue = deletebtn.attributes.href;
        // deletebtn.addEventListener('click', () => {
        //     const statusConfirm = confirm("Anda Yakin?");


        //     if (statusConfirm){
        //         console.log('Confirmed. Navigating to:', deleteValue);
        //         // window.location.href = ;
        //     }
        // });   
        
        document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('#delete');
        deleteButtons.forEach(a => {
            a.addEventListener('click', function () {
                const deleteValue = button.attributes.href;
                const statusConfirm = confirm("Anda Yakin?");
                if (statusConfirm) {
                    console.log('Confirmed. Navigating to:', deleteValue);
                    window.location.href = deleteValue;
                }
            });
        });
    });
    </script>
</html>