<?php
require_once 'verifica_login.php';
require_once 'conexao.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo  = trim($_POST['titulo']);
    $genero  =trim($_POST['genero']);
    $diretor = trim($_POST['diretor']);
    $atores  = trim($_POST['atores']);
    $classif =trim($_POST['classificacao']);
    $sinopse = trim($_POST['sinopse']);
 
    $ano     = (int) $_POST['ano'];
    $preco   = (float) $_POST['preco'];
    $duracao = (int) $_POST['duracao'];
    $nota    = (float) $_POST['nota'];

  
    $erros = []; 
  
    if (empty($titulo)) {
        $erros[] = "O título do filme não pode ser vazio.";
    }

   
    if ($preco < 0) {
        $erros[] = "O preço não pode ser negativo.";
    }

   
    if ($duracao < 0) {
        $erros[] = "A duração não pode ser negativa.";
    }

    
    if ($nota < 0 || $nota > 5) {
        $erros[] = "A nota deve ser um valor entre 0 e 5.";
    }

  
    $generosPermitidos = ["Ação", "Animação", "Comédia", "Drama", "Ficção", "Terror"];
    if (!in_array($_POST['genero'], $generosPermitidos)) { 
         $erros[] = "Gênero selecionado inválido.";
    }

    if (empty($erros)) {
        
        
        $caminhoBanco = 'img/default.jpg'; 

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
            $pastaDestino = __DIR__ . "/img/";
            if (!is_dir($pastaDestino)) mkdir($pastaDestino, 0777, true);
            
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
           
            $extensoesValidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array(strtolower($extensao), $extensoesValidas)) {
                $erro = "Formato de imagem inválido. Use JPG, PNG ou WEBP.";
            } else {
                $novoNome = "filme_" . uniqid() . "." . $extensao;
                $caminhoFisico = $pastaDestino . $novoNome;
                
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoFisico)) {
                    $caminhoBanco = "img/" . $novoNome;
                } else {
                    $erro = "Erro de permissão ao salvar imagem.";
                }
            }
        }

        
        if (empty($erro)) {
            $sql = "INSERT INTO filmes (titulo, genero, ano_lancamento, preco_aluguel, diretor, atores, classificacao, duracao, sinopse, imagem, nota) 
                    VALUES ('$titulo', '$genero', '$ano', '$preco', '$diretor', '$atores', '$classif', '$duracao', '$sinopse', '$caminhoBanco', '$nota')";

            if (mysqli_query($conn, $sql)) {
                header("Location: listar.php?sucesso=1");
                exit;
            } else {
                $erro = "Erro no MySQL: " . mysqli_error($conn);
            }
        }
    } else {
       
        $erro = implode("<br>", $erros);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Filme - Cine Verse</title>
    <link rel="stylesheet" href="./css/styleCadastroFilme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo"><h1><span>Cine</span> Verse </h1></div>
        <div class="menu">
            <?php if (isset($_SESSION['usuario_nome'])): ?>
        <span style="color:white; margin-right:15px;">Olá, <?php echo $_SESSION['usuario_nome']; ?></span>
    <?php endif; ?>
    <a href="paginaprincipal.html" id="topo">Página principal</a>
            <a href="listar.php">Filmes</a>
            <a href="cadastrar.php">Novo Filme</a>
            <a href="logout.php" style="color: #ff4d4d;">Sair</a>
        </div>
    </nav>

    <div class="conteudo">
        <div class="form-container">
            <h2>Cadastrar Filme</h2>
           
            <?php if (!empty($erro)) echo "<div class='msg-feedback msg-erro'>$erro</div>"; ?>

            <form method="POST" action="cadastrar.php" enctype="multipart/form-data">
                
                <div class="container-info">
                    <label>Título <span class="required-mark">*</span></label>
                    <input type="text" name="titulo" required placeholder="Ex: Matrix">
                </div>

                <div class="container-info">
                    <label>Imagem de Capa:</label>
                    <input type="file" name="imagem" accept="image/*">
                </div>

                <div class="container-info" style="display:flex; gap:10px;">
                    <div style="flex:1">
                        <label>Gênero <span class="required-mark">*</span></label>
                        <select name="genero" required>
                            <option value="">Selecione...</option>
                            <option value="Ação">Ação</option>
                            <option value="Animação">Animação</option>
                            <option value="Comédia">Comédia</option>
                            <option value="Drama">Drama</option>
                            <option value="Ficção">Ficção Científica</option>
                            <option value="Terror">Terror</option>
                        </select>
                    </div>
                    <div style="flex:1">
                         <label>Classificação:</label>
                         <select name="classificacao">
                            <option value="Livre">Livre</option>
                            <option value="10 anos">10 anos</option>
                            <option value="12 anos">12 anos</option>
                            <option value="14 anos">14 anos</option>
                            <option value="16 anos">16 anos</option>
                            <option value="18 anos">18 anos</option>
                         </select>
                    </div>
                </div>

                <div class="container-info" style="display:flex; gap:10px;">
                    <div style="flex:1">
                        <label>Ano <span class="required-mark">*</span></label>
                        <input type="number" name="ano" required placeholder="Ex: 1999">
                    </div>
                    <div style="flex:1">
                        <label>Preço (R$) <span class="required-mark">*</span></label>
                        <input type="number" name="preco" step="0.01" required placeholder="0.00">
                    </div>
                    <div style="flex:1">
                        <label>Duração (min):</label>
                        <input type="number" name="duracao">
                    </div>
                </div>

                <div class="container-info"><label>Diretor:</label><input type="text" name="diretor"></div>
                <div class="container-info"><label>Atores:</label><input type="text" name="atores"></div>

                <div class="container-info">
                    <label>Sinopse:</label>
                    <textarea name="sinopse" rows="4" style="width:100%; background:#0a0e23; color:white; border:1px solid rgba(129, 179, 255, 0.5); padding:10px;"></textarea>
                </div>
                
                <div class="container-info">
                    <label>Nota (0 a 5):</label>
                    <input type="number" name="nota" step="0.1" min="0" max="5" value="5.0">
                </div>

                <button type="submit" class="botaoEnviar">Cadastrar Filme</button>
            </form>
        </div>
    </div>


     <footer>
        <div class="footer-links">
            <a href="paginaprincipal.html">Página principal</a>
            <a href="listar.php">Filmes</a>
            <a href="cadastrar.php">Novo Filme</a>
            <a href="logout.php" style="color: #ff4d4d;">Sair</a>
        </div>
        <div class="social-media">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
        <p>&copy; - Instituto Federal do Sul de Minas Gerais - 2025</p>
    </footer>
</body>
</html>