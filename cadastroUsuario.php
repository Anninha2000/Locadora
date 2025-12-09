<?php
require_once 'conexao.php';

$erro="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    if (empty($nome) || empty($senha) || empty($email) ){

        $erro = "Por Favor, preencha todos os campos";
    }
    else{

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email,senha) VALUES ('$nome', '$email', '$senhaHash')";
    if (mysqli_query($conn, $sql)){
        header("Location: login.php?cadastro=1");
        exit;
    }
    else{
        $erro = "Erro no cadastrar: ". mysqli_error($conn);
    }
    }
}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
    <link rel="stylesheet" href="./css/estiloCadastro.css">
</head>
<body>
    <div class="containerPrincipal">
    <fieldset>
        <legend><strong>Formulário para cadastro</strong></legend>


        <?php if(!empty($erro)): ?>

            <div style="color:red; text-align:center; "> <?php echo $erro;?></div>

            <?php endif; ?>
    <form method="POST" action ="cadastroUsuario.php">
        <div value="formulario">
        <div class="informacoes-pessoais">
            <label for="nome">Nome</label>
            <input placeholder="Nome: " type="text" name="nome" id="nome" class="caixa">
            <label for="email">Email</label>
            <input placeholder="E-mail: " type="email" name="email" id="email" class="caixa">
             <label for="senha">Senha</label>
            <input placeholder="Senha: " type="password" name="senha" id="senha" class="caixa">
        </div>
   
    <div class="botoes">
        
        <button type="submit" >Enviar</button>

        <button type="reset">Limpar</button>
    </div>
    <a href="login.php" class="voltar">Voltar</a>
    </form>
    </fieldset>
    </div>
</body>
</html>