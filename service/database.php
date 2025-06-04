<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "buku_tamu";

$db = new mysqli($hostname, $username, $password, $database_name);

if ($db->connect_error){
    echo "Koneksi database rusak!!!";
    die("Error: " . $db->connect_error);
}

?>