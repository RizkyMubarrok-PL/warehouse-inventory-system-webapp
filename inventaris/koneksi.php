<?php
$conn = new mysqli("localhost", "root", "", "inventaris_gudang");

if ( $conn->connect_error){
    echo "koneksi gagal";
}