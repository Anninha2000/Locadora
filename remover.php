<?php
require_once 'verifica_login.php';
require_once 'conexao.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    

    $sql_busca = "SELECT imagem FROM filmes WHERE id = $id";
    $result = mysqli_query($conn, $sql_busca);
    $filme = mysqli_fetch_assoc($result);

    $sql_delete = "DELETE FROM filmes WHERE id = $id";
    
    if (mysqli_query($conn, $sql_delete)) {
        if ($filme && !empty($filme['imagem']) && $filme['imagem'] != 'img/default.jpg') {
            if (file_exists(__DIR__ . "/" . $filme['imagem'])) {
                unlink(__DIR__ . "/" . $filme['imagem']);
            }
        }

        header("Location: listar.php?removido=1");
        exit;
    } else {
        echo "Erro ao remover: " . mysqli_error($conn);
    }
} else {
    echo "ID inválido.";
}
?>