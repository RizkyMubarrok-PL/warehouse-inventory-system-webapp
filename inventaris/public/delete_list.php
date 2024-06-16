<?php
session_start();

$id = $_GET['id'];


function deleteRow ($array, $row){
    if (isset($array[$row])){
        unset($array[$row]);

        $array = array_values($array);
        return true;
    }
    return false;
}


if (deleteRow($_SESSION['list'], $id)) {
    echo 
    "<script>
        alert('Success, Delete List')
        window.location.href = 'masuk.php'
    </script>";
}