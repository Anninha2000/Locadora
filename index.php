<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: paginaprincipal.html");
} else {
    header("Location: login.php");
}
exit;
?>