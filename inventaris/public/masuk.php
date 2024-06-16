<?php
session_start();

include "/xampp/htdocs/inventaris/koneksi.php";

if (!isset($_SESSION['user_id'])){
    header("Location: /inventaris/login.php");
}

$sql_barang = "SELECT * FROM barang ";

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    unset($_SESSION['kategori']);
    if (isset($_POST['kategori'])){
        $id_kategori = $_POST['kategori'];
        $sql_barang = $sql_barang . "WHERE kategori_id = {$id_kategori}";
        if (!isset($_SESSION['kategori'])){
            $_SESSION['kategori'] = $conn->query("SELECT kategori FROM kategori WHERE id = $id_kategori")->fetch_assoc()['kategori'];
            $_SESSION['kategori_id'] = $id_kategori;
        }
    }
    
    if (isset($_POST['add'])){
        if (!empty($_POST['barang']) && !empty($_POST['jumlah'])){        
    
            $jumlah = $_POST['jumlah'];
            $id_barang = $_POST['barang'];
            $dataBarang = $conn->query("SELECT * FROM barang WHERE id = $id_barang")->fetch_assoc();
            $nama_barang = $dataBarang['nama'];
            $harga = $dataBarang['harga'];
            $total_harga = $harga * $jumlah;


            $_SESSION['list'][] = ['nama' => $nama_barang, 'barang' => $id_barang, 'harga' => $harga, 'jumlah' => $jumlah, 'total_harga' => $total_harga];
        }
    }
    
    if (isset($_POST['masukan'])){
        $lenght = $_SESSION['list'];
        if ($lenght <= 0 ){
            echo 
            "<script>
                alert('Error, List empty')
            </script>";
        } else {
            $insert_pencatatan = $conn->query("INSERT INTO pencatatan_barang (users_id, tanggal, jenis_catatan) VALUES ({$_SESSION['user_id']}, NOW(), 'masuk')");
            $inserted_id_pencatatan = $conn->insert_id;

            foreach ($_SESSION['list'] as $list){
                $insert_detail = $conn->query("INSERT INTO detail_pencatatan (pencatatan_id, barang_id, jumlah_barang, total_harga) VALUES ($inserted_id_pencatatan, {$list['barang']}, {$list['jumlah']}, {$list['total_harga']})");

                $update_stok = $conn->query("UPDATE stock SET stok = stok + {$list['jumlah']} WHERE barang_id = {$list['barang']}");
            }

            $_SESSION['list'] = [];

            if ($_SESSION['role'] == 'user'){
                echo 
                "<script>
                    alert('Success, Barang Masuk')
                    window.location.href = '/inventaris/Index.php';
                </script>";       
            } else {
                echo 
                "<script>
                    alert('Success, Barang Masuk')
                    window.location.href = '/inventaris/dashboard/Index.php';
                </script>";   
            }
        }
    }

    if (isset($_POST['delete'])){
        $id = $_POST['delete'];

        unset($_SESSION['list'][$id]);
        $_SESSION['list'] = array_values($_SESSION['list']);

        echo 
            "<script>
                alert('Success, Delete List')
            </script>";

        $data_barang = $conn->query($sql_barang)->fetch_all(MYSQLI_ASSOC);
    }
}
$data_barang = $conn->query($sql_barang)->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Barang Masuk</title>
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
                <a href="/inventaris/logout.php" class="btn bg-danger-2 text-white my-2 mx-3">Logout</a>
            </div>
        </div>

        <div class="container-fluid my-5 ">
            <div class="row d-flex bg-secondary-2 rounded">
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h3 class="text-white">Barang Masuk</h3>
                    <!-- <a href=""></a> -->
                </div>

                <div class="col-5 my-3">
                    <form action="" method="post" id="form-kategori">
                        <label class="text-white fw-bold" for="kategoir">Kategori</label>
                        <select class="form-select" name="kategori" id="kategori">                        
                            <?php
                            if (!isset($_SESSION['kategori'])){
                                echo "<option value=''>Pilih Kategori</option>";
                            } else {
                                echo "<option value='{$_SESSION['kategori_id']}'>{$_SESSION['kategori']}</option>";
                                echo "<option value=''>Pilih Kategori</option>";
                            }

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

                        <button class="btn bg-light-2 my-2" type="submit" name="add">Add Barang</button>
                    </form>
                </div>

                <div class="col-12 table-responsive px-2">
                    <table class="table">
                        <thead>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                            <th>Action</th>
                        </thead>
                    
                        <tbody>
                            <?php
                            $index = 0;
                            if (isset($_SESSION['list'])){  
                                foreach ($_SESSION['list'] as $data){
                                    echo "
                                    <tr>
                                        <td>{$data['nama']}</td>
                                        <td>{$data['jumlah']}</td>
                                        <td>{$data['harga']}</td>
                                        <td>{$data['total_harga']}</td>
                                        <td>
                                            <form action='' method='post'>
                                                <button class='btn-danger' type='submit' value='$index' name='delete'>Delete</button>
                                            </form>
                                        </td>
                                    </tr>";
                    
                                    $index ++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <form class="mb-2" action="" method="post">
                    <button class="btn bg-light-2" type="submit" name="masukan">Masukan</button>
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