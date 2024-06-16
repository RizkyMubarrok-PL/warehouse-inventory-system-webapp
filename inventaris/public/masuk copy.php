<?php
session_start();

include "/xampp/htdocs/inventaris/koneksi.php";

// table
$sql_barang = "SELECT * FROM barang ";
$data_barang = $conn->query($sql_barang)->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if (isset($_POST['kategori'])){
        $id_kategori = $_POST['kategori'];
        $sql_barang = $sql_barang . "WHERE kategori_id = {$id_kategori}";
    }
    
    $tableName = "list_barang_masuk";
    
    if (isset($_POST['add'])){
        if (!empty($_POST['barang']) && !empty($_POST['jumlah'])){        
            $checkTable = $conn->query("SHOW TABLES LIKE '$tableName'")->num_rows;        
            if ($checkTable == 0){
                $createTableQuery = "CREATE TABLE list_barang_masuk (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    barang VARCHAR(30) NOT NULL,
                    jumlah VARCHAR(30) NOT NULL,
                    total_harga INT NOT NULL
                )";
    
                $conn->query($createTableQuery);
            }
    
            $jumlah = $_POST['jumlah'];
            $id_barang = $_POST['barang'];
            $total_harga = $conn->query("SELECT harga FROM barang WHERE id = {$_POST['barang']}")->fetch_assoc()['harga'] * $jumlah;
    
            $add = "INSERT INTO $tableName (barang, jumlah, total_harga) VALUE (?, ?, ?)";
            $params = [$_POST['barang'], $_POST['jumlah'], $total_harga];
            $status_add = $conn->execute_query($add, $params);
            if ($status_add){
                echo "<script>alert('Success, Add    Barang')</script>";
            }
    
            $sql_masuk = "SELECT $tableName.id, barang.nama, barang.harga, $tableName.jumlah, $tableName.total_harga
            FROM $tableName
            LEFT JOIN barang on $tableName.barang = barang.id";
            $data_list = $conn->query($sql_masuk)->fetch_all(MYSQLI_ASSOC);
        }
    }
    
    if (isset($_POST['masukan'])){
        $checkData = $conn->query("SELECT * FROM $tableName");
        if ($checkData->num_rows == 0){
            echo "<script>alert('Success, Delete List')</script>";
        } else {
            $dateNow = new DateTime();
            $date = date_format($dateNow, "yyyy-mm-dd");
            $insert_pencatatan = "INSERT INTO pencatatan_barang (users_id, tanggal, jenis_catatan) VALUES (?, NOW(), ?)";
            $pencatatan_params = [$_SESSION['user_id'], 'masuk'];
            $conn->execute_query($insert_pencatatan, $pencatatan_params);
            $id_pencatatan = $conn->insert_id;
    
            $list_data = $checkData->fetch_all(MYSQLI_ASSOC);
    
            foreach ($list_data as $data){
                $insert_barang = "INSERT INTO detail_pencatatan (pencatatan_id, barang_id, jumlah_barang, total_harga) VALUES (?, ?, ?, ?)";
                $params_barang = [$id_pencatatan, $data['barang'], $data['jumlah'], $data['total_harga']];
                $conn->execute_query($insert_barang, $params_barang);

                $update_stok = "UPDATE stok SET stok = stok + ? WHERE barang_id = ?";
                $params_updateStok = [$data['jumlah'], $data['barang']];
            }
    
            $delete_table = "DROP TABLE list_barang_masuk";
            $conn->query($delete_table);
    
            echo 
            "<script>
                alert('Success, Barang Masuk')
                // window.location.href = '../Index.php'
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Barang Masuk</title>
</head>
<body class="row">
    <div class="col-2 bg-primary">
        <h2 class="text-white mx-3">Hallo</h2>

        <ul class="navbar-nav sidebar sidebar-dark">
            <div class="sidebar-divider"></div>
            <li class="nav-item active">
                <a href="masuk" class="btn btn-primary">Barang Masuk</a>
            </li>
    
            <li class="nav-item active">
                <a href="keluar.php" class="btn btn-primary">Barang Keluar</a>
            </li>
    
            <li class="nav-item active">
                <a href="../Index.php" class="btn btn-primary">Pencatatan</a>
            </li>
        </ul>
    </div>

    <div class="col-10">
        <div class="row">
            <div class="col-12 d-flex shadow justify-content-end">
                <a href="../logout.php" class="btn btn-danger my-2 mx-3">Logout</a>
            </div>
        </div>

        <div class="container-fluid my-5 ">
            <div class="row d-flex bg-primary rounded-top">
                <div class="col-5 my-3">
                    <form action="" method="post" id="form-kategori">
                        <label class="text-white fw-bold" for="kategoir">Kategori</label>
                        <select class="form-select" name="kategori" id="kategori">
                            <option value="">Pilih Kategor</option>
                            <?php
                            $data_kategori = $conn->query("SELECT * FROM kategori")->fetch_all(MYSQLI_ASSOC);
                            foreach ($data_kategori as $data){
                                echo "<option value='{$data['id']}'>{$data['kategori']}</option>";
                            }
                            ?>
                        </select>
                    </form>

                    <form action="" class="d-flex flex-column my-3" method="post">
                        <label class="text-white fw-bold" for="barang">Barang</label>
                        <select class="form-select" name="barang" id="barang">
                            <option value="">Pilih Barang</option>
                            <?php
                            foreach ($data_barang as $data){
                                echo "<option value='{$data['id']}'>{$data['nama']}</option>";
                            }
                            ?>
                        </select>
                        
                        <label class="text-white fw-bold" for="jumlah">Jumlah</label>
                        <input class="form-control" type="number" name="jumlah" id="jumlah" min="1">
    
                        <input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>">

                        <button class="btn btn-success text-white" type="submit" name="add">Add Barang</button>
                    </form>
                </div>

                <table class="col-12 table">
                    <thead>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total Harga</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($data_list as $data){
                            echo "
                            <tr>
                                <td>{$data['nama']}</td>
                                <td>{$data['jumlah']}</td>
                                <td>{$data['harga']}</td>
                                <td>{$data['total_harga']}</td>
                                <td>
                                    <a id='delete' href='delete_list.php?id={$data['id']}&table=list_barang_masuk'>Delete</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
                
                <form action="" method="post">
                    <button class="btn btn-success" type="submit" name="masukan">Masukan</button>
                </form>
            </div>
        </div>
    </div>
</body>

    <script>
        const kategori = document.getElementById("kategori");
        kategori.addEventListener('change', () =>{
            document.getElementById("form-kategori").submit();
        });        
    </script>
</html>