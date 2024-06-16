<?php
session_start();

include "/xampp/htdocs/inventaris/koneksi.php";

$delete = "DELETE FROM kategori WHERE id = ?";
$params = [$_GET['id']];

$status = $conn->execute_query($delete, $params);

if ($status) {
    echo "
        <script>
            alert('Success, Menghapus Kategori')
            window.location.href = 'crud_kategori.php'
        </script>";  
}
