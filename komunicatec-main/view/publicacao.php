<?php // Página de exibição de todas as publicações
require_once '../controller/controlar_publicacao.php'; // Requer arquivo controlador para exibição
$publicados = $publicacao->consultar_todos(); // Executa função de consulta, recebe dados de publicações
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Publicações - KomunicaTec</title>
	<link rel="stylesheet" href="publi.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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

	<main>
		<!-- Barra de pesquisa -->
		<div class="search-bar">
			<input type="text" placeholder="pesquisar">
			<button>
				<i class="fa-solid fa-magnifying-glass"></i>
			</button>
		</div>

		<!-- Filtro de categorias -->
		<div class="filter">
			<label><input type="checkbox"> Vagas</label>
			<label><input type="checkbox"> Cursos</label>
			<label><input type="checkbox"> Eventos</label>
			<label><input type="checkbox"> Outros</label>
		</div>

		<!-- Lista de publicações -->
		<section class="publicacoes">
            
            <?php foreach($publicados as $publicado): // Para cada publicação. Se não houver, exibe nenhuma ?>
            <div class="card">
				<div class="card-header">
					<img src="imagens/user_icon.jpg" alt="Foto perfil" class="card-profile">
					<div>
						<h4>Silvia Farani</h4>
						<p class="role">Coordenadora</p>
					</div>
					<button class="btn-view" onclick="location.href='publicacao_usuario.php'">Visualizar Perfil</button>
				</div>

				<div class="card-content">
					<h3><?= $publicado["titulo"] ?></h3>
					<span class="date">Publicado em <?= date("d/m/Y H:i", strtotime($publicado["data_de_publicacao"])) // Formato da data, converte valor string para tempo ?></span>
                    <!-- "whitespace: pre-line" converte quebras de linha para HTML -->
					<p style="white-space: pre-line;"><?= $publicado["descricao"] ?></p>
					<div class="images">
						<img src="simbaju.png" alt="Imagem 1">
						<img src="evento.png" alt="Imagem 2">
					</div>
                    <?php
                    if (isset($publicado["endereco_link"]) && $publicado["endereco_link"] != null)
					{
						echo '<a href="'.$publicado["endereco_link"].'" class="link">'.$publicado["endereco_link"].'</a>';
					}
                    ?>
					<span class="date">Valido até <?= date("d/m/Y", strtotime($publicado["data_de_expiracao"])) ?></span>
				</div>
			</div>
            <?php endforeach; ?>

            <!-- Publicações base -->
			<div class="card">
				<div class="card-header">
					<img src="perfil.jpg" alt="Foto perfil" class="card-profile">
					<div>
						<h4>Silvia Farani</h4>
						<p class="role">Coordenadora</p>
					</div>
					<button class="btn-view">Visualizar Perfil</button>
				</div>

				<div class="card-content">
					<h3>Convite ao Simbaju DSM!</h3>
					<span class="date">Publicado em 08/11/2024</span>
					<p>Boa tarde a todos! Nos dias 12, 13 e 14, ocorrerão as apresentações do Simbaju do DSM. Estudantes do G1T e
						G3E estão convidados.</p>
					<div class="images">
						<img src="simbaju.png" alt="Imagem 1">
						<img src="evento.png" alt="Imagem 2">
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<img src="perfil.jpg" alt="Foto perfil" class="card-profile">
					<div>
						<h4>Silvia Farani</h4>
						<p class="role">Coordenadora</p>
					</div>
					<button class="btn-view">Visualizar Perfil</button>
				</div>

				<div class="card-content">
					<h3>Estágio em Análise de Dados</h3>
					<span class="date">Publicado em 10/11/2024</span>
					<p>Bom dia a todos! Um ex-aluno me posicionou sobre uma vaga de estágio em aberto para a empresa XPTO.
						Interessados, por favor, clicar no link.</p>
					<div class="images">
						<img src="xpto.png" alt="Imagem vaga">
					</div>
					<a href="https://www.linkparavaga.com" class="link">https://www.linkparavaga.com</a>
				</div>
			</div>

		</section>
	</main>

	<footer>
		<p>© 2025 - KomunicaTec</p>
	</footer>
</body>

</html>