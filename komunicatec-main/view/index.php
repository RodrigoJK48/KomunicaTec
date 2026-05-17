<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="reset.css">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="cabecario.css">
	<!-- Fontes Google -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
		rel="stylesheet">
	<title>KomunikaTec</title>
</head>

<body>

	<!-- Cabeçalho e navegação principal -->
	<?php
	include_once 'cabecario.php'; // Inclui o código arquivo uma vez, evitando repetição ao recarregar a página
	?>

<!-- Conteúdo principal com destaque -->
	<main>
		<section class="imgf">
			<div class="overlay">
				<article class="main">
					<h1 class="textmain">|Bem vindo(a) a KomunicaTec!</h1>
					<p class="textimg">A plataforma de comunicação da Fatec Franco da Rocha.</p>
					<button class="botvisu" onclick="location.href='publicacao.php'">visualizar novidades</button>
				</article>
			</div>
		</section>
	</main>

<!-- Seção sobre a plataforma -->
	<h2 class="titulo-login disp">|Sobre a plataforma</h2>

	<section class="campo-bg-login">
		<div class="caixa-login">
			<article>
				<figure>
					<img class="imagem-div1" src="imagens/imgin.png" alt="Ilustração sobre comunicação acadêmica">
				</figure>
				<aside class="login-size">
					<p class="span-login disp">
						A KomunicaTec é uma plataforma para apoio à comunicação e integração da comunidade acadêmica da Fatec
						Franco da Rocha.<br>
						Fique por dentro de vagas publicadas, cursos e até mesmo convites para eventos.<br><br><br>
						Mantenha contato com a instituição mesmo após a formação, tendo acesso contínuo às possibilidades fornecidas por ela.
					</p>
				</aside>
			</article>
		</div>
	</section>
<!-- Rodapé -->
	<footer class="text-center py-3">
		<img class="rodapelogin" src="imagens/logo2.png" alt="Logo secundária da KomunikaTec">
	</footer>
</body>

</html>
