<?php
session_start();

include "/xampp/htdocs/inventaris/koneksi.php";

$tableName = $_GET['table'];
$href;
$id = $_GET['id'];

$delete = "DELETE FROM $tableName WHERE id = $id";
$status_delete = $conn->query($delete);

if ($tableName == "list_barang_masuk"){
    $href = "masuk.php";
}

if ($status_delete) {
    echo 
    "<script>
        alert('Success, Delete List')
        window.location.href = '$href'
    </script>";
}