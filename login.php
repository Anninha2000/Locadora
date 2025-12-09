<?php
require_once 'conexao.php'; 
session_start();


if (isset($_SESSION['usuario_id'])) {
    header("Location: listar.php");
    exit;
}

$erro_login = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $email = ($_POST['email']);
    $senha = $_POST['senha']; 


    $sql = "SELECT * FROM usuarios WHERE email = '$email'";

    $result = mysqli_query($conn, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($senha, $row['senha'])) {
          
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario_nome'] = $row['nome'];
            $_SESSION['usuario_email'] = $row['email'];

            header("Location: paginaprincipal.html");
            exit;
        } else {
            $erro_login = "Senha incorreta.";
        }
    } else {
        $erro_login = "E-mail não cadastrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cine Verse</title>
    <link rel="stylesheet" href="./css/styleLogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
</head>

<body>
    <div class="container">
        <h1>Login</h1>

        <?php if (!empty($erro_login)): ?>
            <div class="msg-erro">
                <i class="fas fa-exclamation-circle"></i> <?php echo $erro_login; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['erro']) && $_GET['erro'] == 'acesso_negado'): ?>
            <div class="msg-erro">
                <i class="fas fa-lock"></i> Faça login para acessar.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['logout']) && $_GET['logout'] == 1): ?>
            <div class="msg-sucesso">
                <i class="fas fa-check"></i> Você saiu com sucesso.
            </div>
        <?php endif; ?>


        <form method="POST" action="login.php">
            <div class="input">
                <div class="input-com-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Email" required value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
                </div>
                <div class="input-com-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="senha" name="senha" placeholder="Senha" required>
                </div>
            </div>
            
            <div class="checkbox">
                <input type="checkbox" id="lembrar" name="lembrar">
                <label for="lembrar">Lembrar minha senha</label>
                <a href="#">Esqueceu sua senha?</a>
            </div>

            <button class="botao" type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>

            <div class="registrar">
                <p>Ainda não tem uma conta? <a href="cadastroUsuario.php">Criar conta</a></p>
            </div>

            <div class="redes-login">
                <div class="linha">
                    <p>Ou entre com</p>
                </div>
                <div class="redes-sociais">
                    <button type="button" class="google"><i class="fab fa-google"></i></button>
                    <button type="button" class="facebook"><i class="fab fa-facebook-f"></i></button>
                    <button type="button" class="x"><i class="fab fa-x-twitter"></i></button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>