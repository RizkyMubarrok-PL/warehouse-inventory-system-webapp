<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Document</title>
</head><?php
    session_start();

    include "/xampp/htdocs/inventaris/koneksi.php";

    if (!isset($_SESSION['user_id'])){
        header("Location: login.php");
    }

    $sql = "SELECT
                barang.nama,
                kategori.kategori,
                barang.harga,
                stock.stok
            FROM 
                barang
            LEFT JOIN stock ON barang.id = stock.barang_id
            LEFT JOIN kategori ON barang.kategori_id = kategori.id";
    $data_stock = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventaris/css/bootstrap.css">
    <title>Data Stok</title>

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
            <div id="bg-content" class="row d-flex bg-secondary-2 rounded px-2">
                <h3 class="text-white my-2">Data Stok Barang</h3>

                <div class="table-responsive-md">
                    <table class="table">
                        <thead>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($data_stock as $data){
                                echo "
                                <tr>
                                    <td>{$data['nama']}</td>
                                    <td>{$data['kategori']}</td>
                                    <td>{$data['harga']}</td>
                                    <td>{$data['stok']}</td>
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