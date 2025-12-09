<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    unset($_SESSION['usuario_id']);
}

if (isset($_SESSION['usuario_nome'])) {
    unset($_SESSION['usuario_nome']);
}

if (isset($_SESSION['usuario_email'])) {
    unset($_SESSION['usuario_email']);
}
session_destroy();
header("Location: login.php?logout=1");
exit;
?>