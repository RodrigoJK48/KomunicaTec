<?php // Página de exibição de publicações feitas pelo usuário

require_once '../controller/controlar_publicacao.php'; // Requer arquivo controlador para exibição

$publicados = $publicacao->consultar_todos(); // Executa função de consulta
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Publicações - KomunicaTec</title>
    <link rel="stylesheet" href="my_publi.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
   <header>
        <nav class="nav-bar">
            <figure class="imagem-icon">
                <img src="imagens/logo1.png" alt="Logo KomunikaTec" class="img-logo">
            </figure>
            <div class="botao-navegacao">
                <button class="botao" onclick="location.href='index.html'">Home</button>
                <button class="botaoent" onclick="location.href='login.html'">Entrar</button>
                <button class="botao-especial" onclick="location.href='register.html'">Cadastrar</button>
            </div>
        </nav>
    </header>
    <!-- Layout principal -->
    <main class="container">
        <!-- Card lateral -->
        <aside class="perfil-card">
            <img src="imagens/user_icon.jpg" alt="Foto de Perfil" class="foto-perfil">
            <h2>Silvia Farani</h2>
            <p class="cargo">Coordenadora</p>
            <p class="subcargo">Administrador</p>

            <p class="label">e-mail corporativo:</p>
            <p>silvia@fatec.sp.gov.br</p>

            <p class="label">Telefone:</p>
            <p>(11) xxxx-xxxx</p>
        </aside>

        <!-- Publicações -->
        <section class="publicacoes">
            <h1>Minhas Publicações</h1>

            <!-- Filtro -->
            <div class="filtro">
                <label><input type="checkbox"> Vagas</label>
                <label><input type="checkbox"> Cursos</label>
                <label><input type="checkbox"> Eventos</label>
                <label><input type="checkbox"> Outros</label>
            </div>

            <!-- Lista de publicações -->
            <?php foreach($publicados as $publicado): ?>
            <div class="publicacao-card">
                <div class="cabecalho">
                    <h2><?= $publicado["titulo"] ?></h2>
                    <span>
                        Publicado em <?= $publicado["data_de_publicacao"] ?>
                    </span>
                </div>
                <!-- "whitespace: pre-line" converte quebras de linha para HTML -->
                <p style="white-space: pre-line;"><?= $publicado["descricao"] ?></p>
                <div class="acoes">
                    <button class="editar" onclick="location.href='edit_publi.html'">Editar</button>
                    <button class="excluir">Excluir</button>
                </div>
            </div>
            <?php endforeach; ?>


            
            <!-- Base de publicações -->
            <div class="publicacao-card">
                <div class="cabecalho">
                    <h2>Convite ao Simbaju DSM!</h2>
                    <span>Publicado em 08/11/2024</span>
                </div>
                <p>
                    Boa tarde a todos! Nos dias 12, 13 e 14, ocorrerão as apresentações do Simbaju do DSM.
                    Estudantes do GT1 e G3E estão convidados.
                </p>
                <div class="acoes">
                   <button class="editar" onclick="location.href='edit_publi.html'">Editar</button>
                    <button class="excluir">Excluir</button>
                </div>
            </div>

            <div class="publicacao-card">
                <div class="cabecalho">
                    <h2>Estágio em Análise de Dados</h2>
                    <span>Publicado em 10/11/2024</span>
                </div>
                <p>
                    Bom dia a todos! Um ex-aluno me posicionou sobre uma vaga de estágio em aberto para a empresa XPTO.
                    Interessados, por favor, clicar no link.
                </p>
                <div class="acoes">
                    <button class="editar" onclick="location.href='edit_publi.html'">Editar</button>
                    <button class="excluir">Excluir</button>
                </div>
            </div>
        </section>
    </main>

    <!-- Rodapé -->
    <footer>
        <p>© 2025 - KomunicaTec</p>
    </footer>
</body>
</html>
