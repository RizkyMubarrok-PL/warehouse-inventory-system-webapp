<?php
    session_start();

    include "/xampp/htdocs/inventaris/koneksi.php";

    if (!isset($_SESSION['user_id'])){
        header("Location: login.php");
    }

    $sql = "SELECT
                users.username,
                pencatatan_barang.tanggal,
                barang.nama,
                kategori.kategori,
                barang.harga,
                detail_pencatatan.jumlah_barang,
                detail_pencatatan.total_harga,
                pencatatan_barang.jenis_catatan
            FROM 
                detail_pencatatan
            LEFT JOIN barang ON detail_pencatatan.barang_id = barang.id
            LEFT JOIN kategori ON kategori.id = barang.kategori_id
            LEFT JOIN pencatatan_barang ON pencatatan_barang.id = detail_pencatatan.pencatatan_id
            LEFT JOIN users ON pencatatan_barang.users_id = users.id ";
    $params = [];            

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['search'])){
            $filter = $_POST['nama|barang'];
            $stmt = $conn->prepare($sql . "WHERE barang.nama LIKE ? OR users.username LIKE ?");
            $stmt->execute(["%$filter%", "%$filter%"]);
            $data_join = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        if (isset($_POST['filter'])){        

            $kategori_val = $_POST['kategori'];
            $catatan_val = $_POST['jenis_catatan'];

            $condition = [];
            $params = [];

            if (!empty($kategori_val)){
                $condition[] = "barang.kategori_id = ?";
                $params[] = $kategori_val;
            }
            
            if (!empty($catatan_val)){
                $condition[] = "pencatatan_barang.jenis_catatan = ?";
                $params[] = $catatan_val;
            }

            if (count($condition) > 0){
                $sql .= "WHERE ". implode(' AND ', $condition);
            }
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);

            $data_join = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
    } else {
        $data_join = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventaris/css/bootstrap.css">
    <title>Data pencatatan</title>

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
            <div class="row d-flex justify-content-between bg-secondary-2 rounded px-2">
                <form action="" class="col-4 d-flex my-3" method="post" id="search-form">
                    <input class="form-control" type="search" name="nama|barang" id="search" placeholder="Search Barang | Users">
                    <button class="btn btn bg-white text-primary mx-1" type="submit" name="search">Search</button>
                </form>

                <form action="" class="col-7 d-flex my-3" method="POST">
                        <select class="form-select mx-1" name="kategori" id="">
                            <option value="">Kategori</option>
                            <?php 
                            $data_kategori = $conn->query("SELECT * FROM kategori")->fetch_all(MYSQLI_ASSOC);
                            foreach ($data_kategori as $data){
                                echo "<option value='{$data['id']}'>{$data['kategori']}</option>";
                            }
                            ?>
                        </select>

                        <select class="form-select mx-1" name="jenis_catatan" id="">
                            <option value="">All</option>
                            <option value="masuk">Masuk</option>    
                            <option value="keluar">Keluar</option>
                        </select>

                        <button type="submit" class="btn bg-white" name="filter">Filter</button>
                </form>

                <div class="col-12 table-responsive overflow-y">
                    <table class="table">
                        <thead>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Jumlah Barang</th>
                            <th>Total Harga</th>
                            <th>Catatan</th>
                        </thead>
                    
                        <tbody>
                            <?php
                            foreach ($data_join as $data) {
                                echo "
                                <tr>
                                    <td>{$data['username']}</td>
                                    <td>{$data['tanggal']}</td>
                                    <td>{$data['nama']}</td>
                                    <td>{$data['kategori']}</td>
                                    <td>{$data['harga']}</td>
                                    <td>{$data['jumlah_barang']}</td>
                                    <td>{$data['total_harga']}</td>
                                    <td>{$data['jenis_catatan']}</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>