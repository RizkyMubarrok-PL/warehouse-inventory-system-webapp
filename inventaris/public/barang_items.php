<?php

include "/xampp/htdocs/inventaris/koneksi.php";

$id_kategori = $_GET['id'];
$data_barang = $conn->query("SELECT * FROM barang WHERE kategori_id = ")->fetch_all(MYSQLI_ASSOC);

$data_json;
foreach ($data_barang as $data) {
    $data_json = $data;
}

echo json_encode($data_json);
?>