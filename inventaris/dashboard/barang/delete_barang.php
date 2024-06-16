<?php
session_start();
include "/xampp/htdocs/inventaris/koneksi.php";

$delete = "DELETE FROM barang WHERE id = {$_GET['id']}";
$status_delete = $conn->query($delete);

if ($status_delete){
    echo "
        <script>
            alert('Success, Menghapus')
            window.location.href = 'crud_barang.php'
        </script>";  
} else {
    echo "<script>alert('Failed, Delete Barang')</script>";
}