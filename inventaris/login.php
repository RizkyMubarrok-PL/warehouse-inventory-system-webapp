<?php
session_start();
include "/xampp/htdocs/inventaris/koneksi.php";

if (!empty($_POST['username']) && !empty($_POST['password'])){
    $SQL = "SELECT * FROM users WHERE username = ? AND PASSWORD = ?";
    $stmt = $conn->prepare($SQL);
    $params = [$_POST['username'], $_POST['password']];
    $stmt->execute($params);
    $data = $stmt->get_result()->fetch_assoc(); 

    if (isset($data)){
        if ($data['role'] == 'user'){
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['username'] = $data['user'];
            $_SESSION['role'] = $data['role'];
            $_SESSION['list'] = [];
            header("Location: Index.php");
        }else if ($data['role'] == 'admin') {
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['username'] = $data['user'];
            $_SESSION['role'] = $data['role'];
            $_SESSION['list'] = [];
            header("Location: dashboard/Index.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Login</title>

    <?php include "/xampp/htdocs/inventaris/style.php"?>
</head>
<body class="bg-primary-2 item-center">
    
    <form action="" method="post" class="bg-white d-flex flex-column p-3">
        <h2>Login</h2>
    
        <div class="my-3">
            <label for="username" class="fw-bold fs-5">Username</label>
            <input class="form-control" type="text" name="username" id="username" require placeholder="Username">
        </div>
    
        <label for="password" class="fw-bold fs-5">Password</label>
        <input class="form-control" type="password" name="password" id="password" require placeholder="Password">
    
        <button type="submit" class="btn fw-bold my-2 bg-secondary-2 text-white">Login</button>
    </form>
</body>
</html> 