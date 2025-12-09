<?php
$host = "localhost";
$user = "root";
$pass = "";
$db= "locadora";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>