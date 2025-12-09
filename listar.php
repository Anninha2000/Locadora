<?php
require_once 'verifica_login.php';
require_once 'conexao.php';

$termo = "";
$filmes = [];

if (isset($_POST['busca'])) {
    $termo = $_POST['busca'];
    $termoBusca = "%{$termo}%";
    
    $sql = "SELECT * FROM filmes WHERE titulo LIKE ? OR genero LIKE ? OR diretor LIKE ? ORDER BY titulo ASC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $termoBusca, $termoBusca, $termoBusca);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $sql = "SELECT * FROM filmes ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
}
if (!$result) {
    die("Erro na consulta: " . mysqli_error($conn));
}

$filmes = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Filmes - Cine Verse</title>
    <link rel="stylesheet" href="./css/styleFilmes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>

        <?php foreach ($filmes as $f): ?>
            #detalhes-<?php echo $f['id']; ?>:checked ~ #modal-<?php echo $f['id']; ?> {
                display: block !important;
                opacity: 1;
                visibility: visible;
            }
        <?php endforeach; ?>
        
      
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="logo"><h1><span>Cine</span> Verse </h1></div>
        <div class="menu">
            <?php if (isset($_SESSION['usuario_nome'])): ?>
        <span style="color:white; margin-right:15px; font-size:18px;">Olá, <?php echo $_SESSION['usuario_nome']; ?></span>
    <?php endif; ?>
    <a href="paginaprincipal.html" id="topo">Página principal</a>
            <a href="listar.php">Filmes</a>
            <a href="cadastrar.php">Novo Filme</a>

            <a href="logout.php" style="color: #ff4d4d;">Sair</a>
        </div>
    </nav>

    <a href="cadastrar.php" class="btn-novo-filme">+ Adicionar Filme</a>

    <div class="conteudo">
        
    <div class="mensagens">
        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
            <div class="msg-feedback msg-sucesso">
                Operação realizada com sucesso!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['atualizado']) && $_GET['atualizado'] == 1): ?>
            <div class="msg-feedback msg-sucesso">
                Filme atualizado com sucesso!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['removido']) && $_GET['removido'] == 1): ?>
            <div class="msg-feedback msg-erro" >
                Filme removido com sucesso!
            </div>
        <?php endif; ?>
 
</div>
        

        <h1>Nossos Filmes</h1>
<div class="botaoPesquisa">
            <form method="POST" action="listar.php">
                <input type="text" name="busca" placeholder="Pesquisar filme" >
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
      

        <section>
            <?php foreach ($filmes as $f): ?>
                <input type="checkbox" id="detalhes-<?php echo $f['id']; ?>" hidden>
            <?php endforeach; ?>

            <?php if (count($filmes) > 0): ?>
                <?php foreach ($filmes as $f): ?>
                    <div class="filme">
                        
                        <div class="deletar-card">
                            <a href="editar.php?id=<?php echo $f['id']; ?>"><i class="fas fa-pen"></i></a>
                            <a href="remover.php?id=<?php echo $f['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este filme?')"><i class="fas fa-trash"></i></a>
                        </div>

                        <img src="<?php echo file_exists($f['imagem']) ? $f['imagem'] : 'img/default.jpg'; ?>" alt="Capa" style="object-fit: cover;">
                        
                        <h2><?php echo $f['titulo']; ?></h2>
                        <div class="generos"><p><?php echo $f['genero']; ?></p></div>
                        <p class="avaliacao">★ <?php echo $f['nota']; ?></p>
                        <span>R$ <?php echo number_format($f['preco_aluguel'], 2, ',', '.'); ?></span>
                        
                        <label for="detalhes-<?php echo $f['id']; ?>" class="ver-detalhes">Ver detalhes</label>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color:white; width:100%; text-align:center;">Nenhum filme encontrado.</p>
            <?php endif; ?>

            <?php foreach ($filmes as $f): ?>
                <div class="detalhes" id="modal-<?php echo $f['id']; ?>">
                    <div class="detalhes-conteudo">
                        <img src="<?php echo file_exists($f['imagem']) ? $f['imagem'] : 'img/default.jpg'; ?>" alt="Poster">
                        <h4><?php echo $f['titulo']; ?> (<?php echo $f['ano_lancamento']; ?>)</h4>
                        <p><strong>Diretor:</strong> <?php echo $f['diretor']; ?></p>
                        <p><strong>Atores:</strong> <?php echo $f['atores']; ?></p>
                        <p><strong>Gênero:</strong> <?php echo $f['genero']; ?></p>
                        <p><strong>Classificação:</strong> <?php echo $f['classificacao']; ?></p>
                        <p><strong>Duração:</strong> <?php echo $f['duracao']; ?> min</p>
                        <p class="sinopse"><strong>Sinopse:</strong> <?php echo $f['sinopse']; ?></p>
                        <label for="detalhes-<?php echo $f['id']; ?>" class="fechar-modal"> ✕ </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
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