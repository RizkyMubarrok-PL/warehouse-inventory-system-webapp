<?php
session_start();

include "/xampp/htdocs/inventaris/koneksi.php";

$delete = "DELETE FROM users WHERE id = ?";
$params = [$_GET['id']];

$status = $conn->execute_query($delete, $params);

if ($status) {
    echo "
        <script>
            alert('Success, Menghapus User')
            window.location.href = 'crud_users.php'
        </script>";
}
