<?php
include "service/database.php";
session_start();

$register_message = "";
$use_hash = false;

if (isset($_SESSION["is_login"])) {
    header("location: dasboard.php");
    exit;
}

if (isset($_POST["register"])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username)) {
        $register_message = "Username tidak boleh kosong.";
    }
    else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/', $password)) {
        $register_message = "Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.";
    } else {
        try {
            if ($use_hash) {
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $password_hashed = $password;
            }

            $sql = "INSERT INTO users (USERNAME, PASSWORD) VALUES ('$username', '$password_hashed')";

            if ($db->query($sql)) {
                $register_message = "Akun anda sudah teregistrasi, silahkan login.";
            } else {
                $register_message = "Daftar akun gagal, silahkan coba lagi.";
            }
        } catch (mysqli_sql_exception $e) {
            $register_message = "Username sudah digunakan.";
        }
        $db->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <?php include "layout/header.html"?>
    
    <h3>DAFTAR AKUN</h3>
    <i><?= $register_message ?></i>
    <form action="register.php" method="POST">
        <input type="text" placeholder="username" name="username">
        <input type="password" placeholder="password" name="password">
        <button type="submit" name="register">Daftar Sekarang</button>
    </form>

    <?php include "layout/footer.html"?>

</body>
</html>