<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="login.css">
	<link rel="stylesheet" href="reset.css">
	<link rel="stylesheet" href="cabecario.css">
	<!-- Fontes Google -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
		rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
	<title>KomunikaTec</title>
</head>

<body>
	
	<!-- Cabeçalho e navegação principal -->
	<?php
	include_once 'cabecario.php'; // Inclui o código arquivo uma vez, evitando repetição ao recarregar a página
	?>

	<main>
		<section class="campo-bg-login">
			<div class="caixa-login">
				<article>
					<figure>
						<img class="imagem-div1" src="imagens/foto do login-cortada.png"
							alt="Imagem decorativa de login">
					</figure>
					<section class="login-size">
						<h2 class="titulo-login disp">Entrar</h2>
						<!-- Links para alternar entre tipo de usuário -->
						<p class="span-login disp">
							<a href="#" id="adminLink" class="active">admin ou comunicador </a> &ensp;|&ensp;
							<a href="#" id="alunoLink" class="inactive"> aluno ou ex-aluno</a>
						</p>
						<!-- Formulário dinâmico (campos trocados via JS) -->
						<form action="../controller/controlar_usuario.php?acao=entrar" method="post">
							<div id="formFields">

								<label for="email" class="visually-hidden">Email ou CPF</label>
								<input id="email" name="email" class="inputs-login disp" type="text" placeholder="email ou CPF"
									required><br>

								<label for="senha" class="visually-hidden">Senha</label>
								<input id="senha" name="senha" class="inputs-login disp" type="password" placeholder="senha"
									required><br>
								<input id="perfil" name="perfil" type="hidden" value="comunicador">
							</div>

							<p class="cadastro-link">
								Não tem conta? <a href="register.html">Cadastre-se</a>
							</p>

							<button class="butenviar" type="submit">
								Entrar
							</button>
							<br><br>

							<?php
							if (isset($_GET['msg']))
								switch ($_GET['msg'])
								{
									case 'erro':
										echo "<font color='red'>".
											"Dados incorretos!<br>Faça login novamente.".
										"</font>";
									break;
								}
								?>

						</form>
					</section>

				</article>
			</div>
		</section>
	</main>

	<footer>

	</footer>

	<script>
		const adminLink = document.getElementById("adminLink");
		const alunoLink = document.getElementById("alunoLink");
		const formFields = document.getElementById("formFields");

		adminLink.addEventListener("click", (e) => {
			e.preventDefault();
			formFields.innerHTML = `
		<label for="email" class="visually-hidden">Email ou CPF</label>
		<input id="email" name="email" class="inputs-login disp" type="text" placeholder="email ou CPF"><br>
		<label for="senha" class="visually-hidden">Senha</label>
		<input id="senha" name="senha" class="inputs-login disp" type="password" placeholder="senha"><br>
		<input id="perfil" name="perfil" type="hidden" value="comunicador">
	`;
			adminLink.classList.add("active");
			adminLink.classList.remove("texto-secundario");
			alunoLink.classList.remove("active");
			alunoLink.classList.add("texto-secundario");
		});

		alunoLink.addEventListener("click", (e) => {
			e.preventDefault();
			formFields.innerHTML = `
		<label for="ra" class="visually-hidden">RA</label>
		<input id="ra" name="ra" class="inputs-login disp" type="text" placeholder="RA (registro acadêmico)"><br>
		<label for="senhaAluno" class="visually-hidden">Senha</label>
		<input id="senhaAluno" name="senhaAluno" class="inputs-login disp" type="password" placeholder="senha"><br>
		<input id="perfil" name="perfil" type="hidden" value="discente_egresso">
	`;
			alunoLink.classList.add("active");
			alunoLink.classList.remove("texto-secundario");
			adminLink.classList.remove("active");
			adminLink.classList.add("texto-secundario");
		});

	</script>
</body>

</html>