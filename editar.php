<?php
require_once 'verifica_login.php';
require_once 'conexao.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        die("Erro: ID não informado.");
    }
    $id = (int) $_POST['id'];

    
    $titulo  = trim($_POST['titulo']);
    $genero  =  trim($_POST['genero']);
    $diretor = trim( $_POST['diretor']);
    $atores  = trim( $_POST['atores']);
    $classif =  trim($_POST['classificacao']);
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
    if ($nota < 0 || $nota > 5) {
        $erros[] = "A nota deve ser um valor entre 0 e 5.";
    }
    if (!empty($erros)) {
        $erro = implode("<br>", $erros); 
    } else {
        $caminhoImagem = $_POST['imagem_atual']; 
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
            $pastaDestino = __DIR__ . "/img/";
            if (!is_dir($pastaDestino)) mkdir($pastaDestino, 0777, true);
            
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $extensoesValidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array(strtolower($extensao), $extensoesValidas)) {
                $novoNome = "filme_" . uniqid() . "." . $extensao;
                $caminhoFisico = $pastaDestino . $novoNome;
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoFisico)) {
                    $caminhoImagem = "img/" . $novoNome;
                }
            } else {
                 
            }
        }

        $sql = "UPDATE filmes SET 
                titulo='$titulo', genero='$genero', ano_lancamento='$ano', 
                preco_aluguel='$preco', diretor='$diretor', atores='$atores', 
                classificacao='$classif', duracao='$duracao', sinopse='$sinopse', 
                nota='$nota', imagem='$caminhoImagem' 
                WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            header("Location: listar.php?atualizado=1");
            exit;
        } else {
            $erro = "Erro SQL: " . mysqli_error($conn);
        }
    }
}

if (isset($_REQUEST['id'])) { 
    $id = (int) $_REQUEST['id'];
    $sql = "SELECT * FROM filmes WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $filme = mysqli_fetch_assoc($result);

    if (!$filme) die("Filme não encontrado.");
} else {
    die("ID não informado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Filme - Cine Verse</title>
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
            <a href="listar.php">Filmes</a>
            <a href="cadastrar.php">Novo Filme</a>
            <a href="logout.php" style="color: #ff4d4d;">Sair</a>
        </div>
    </nav>

    <div class="conteudo">
        <div class="form-container">
            <h2>Editar Filme</h2>
    
            
            <form method="POST" action="editar.php" enctype="multipart/form-data">
                
                <input type="hidden" name="id" value="<?php echo $filme['id']; ?>">
                <input type="hidden" name="imagem_atual" value="<?php echo $filme['imagem']; ?>">

                <div style="text-align:center; margin-bottom:20px;">
                    <p style="color:white; margin-bottom:5px;">Capa Atual:</p>
                    <?php if(file_exists($filme['imagem'])): ?>
                        <img src="<?php echo $filme['imagem']; ?>" style="width:120px; height:180px; object-fit:cover; border:2px solid #00f0ff; border-radius:5px;">
                    <?php else: ?>
                        <p style="color:red">Imagem não encontrada</p>
                    <?php endif; ?>
                </div>

                <div class="container-info">
                    <label>Trocar Capa (Opcional)</label>
                    <input type="file" name="imagem" accept="image/*">
                </div>

                <div class="container-info">
                    <label>Título <span class="required-mark">*</span></label>
                    <input type="text" name="titulo" value="<?php echo $filme['titulo']; ?>" required>
                </div>

                <div class="container-info" style="display:flex; gap:10px;">
                    <div style="flex:1">
                        <label>Gênero <span class="required-mark">*</span></label>
                        <select name="genero" required>
                            <?php 
                            $generos = ["Ação", "Animação", "Comédia", "Drama", "Ficção", "Terror"];
                            foreach($generos as $g) {
                                $sel = (stripos($filme['genero'], $g) !== false) ? 'selected' : '';
                                echo "<option value='$g' $sel>$g</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div style="flex:1">
                        <label>Ano <span class="required-mark">*</span></label>
                        <input type="number" name="ano" value="<?php echo $filme['ano_lancamento']; ?>" required>
                    </div>
                </div>

                <div class="container-info" style="display:flex; gap:10px;">
                    <div style="flex:1">
                        <label>Preço (R$) <span class="required-mark">*</span></label>
                        <input type="number" name="preco" step="0.01" value="<?php echo $filme['preco_aluguel']; ?>" required>
                    </div>
                    <div style="flex:1">
                        <label>Duração (min):</label>
                        <input type="number" name="duracao" value="<?php echo $filme['duracao']; ?>">
                    </div>
                </div>


                <div class="container-info"><label>Diretor:</label><input type="text" name="diretor" value="<?php echo $filme['diretor']; ?>"></div>
                <div class="container-info"><label>Atores:</label><input type="text" name="atores" value="<?php echo $filme['atores']; ?>"></div>

                 <div class="container-info">
                    <label>Classificação:</label>
                    <select name="classificacao">
                        <?php 
                        $classifs = ["Livre", "10 anos", "12 anos", "14 anos", "16 anos", "18 anos"];
                        foreach ($classifs as $c) {
                            $sel = ($filme['classificacao'] == $c) ? 'selected' : '';
                            echo "<option value='$c' $sel>$c</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="container-info">
                    <label>Sinopse:</label>
                    <textarea name="sinopse" rows="5" style="width:100%; background:#0a0e23; color:white; border:1px solid rgba(129, 179, 255, 0.5); padding:10px;"><?php echo $filme['sinopse']; ?></textarea>
                </div>

                <div class="container-info">
                    <label>Nota:</label>
                    <input type="number" name="nota" step="0.1" min="0" max="5" value="<?php echo $filme['nota']; ?>">
                </div>

                <button type="submit" class="botaoEnviar">Salvar Alterações</button>
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
            <a href="#"><i class="fab fa-x-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
        <p>&copy; Instituto Federal do Sul de Minas Gerais - 2025</p>
    </footer>
</body>
</html>