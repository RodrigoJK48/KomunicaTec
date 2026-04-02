<?php // Formulário de cadastro/atualização de publicação
require_once '../controller/controlar_publicacao.php'; // Requer arquivo controlador para exibição
$categorias = $categoria->consultar(); // Executa função de consulta, recebe dados de publicações
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Atualizar Publicação - KomunicaTec</title>
	<link rel="stylesheet" href="edit_publi.css">
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

	<main class="main-editar-perfil">
		<!-- Card do usuário -->
		<aside class="perfil-card">
			<img src="imagens/user_icon.jpg" alt="Foto de Perfil" class="foto-perfil">
			<h2>Silvia Farani</h2>
			<h1>Coordenadora</h1>
			<p class="subtitulo">Administrador</p>
			<div class="info-perfil">
				<p><strong>E-mail institucional:</strong><br>
					<a href="mailto:aluno@fatec.sp.gov.br">aluno@fatec.sp.gov.br</a>
				</p>
				<p><strong>Telefone:</strong><br> (11) XXXX-XXXX</p>
			</div>
		</aside>



		<section class="form-section">
			<h2>Atualizar Publicação</h2>

			<?php echo '<form method="post" action="../controller/controlar_publicacao.php?acao=';
			if (isset($acao_form))
			{
				echo $acao_form;
			}
			else
			{
				echo 'publicar';
			}
			echo '">'
			?>
				<label for="titulo">Título:</label>
				<?php echo '<input type="text" id="titulo" name="titulo" placeholder="Digite o título" required';
				if (isset($titulo))
				{
					echo ' value="'.$titulo.'"';
				}
				echo '>';
				?>

				<label for="descricao">Descrição:</label>
				<?php echo '<textarea id="descricao" name="descricao" rows="4" placeholder="Digite a descrição" required>';
				if (isset($descricao))
				{
					echo $descricao;
				}
				echo '</textarea>';
				?>

				<div class="form-row">
					<div class="form-group">
						<label for="expiracao">Expiração:</label>
						<?php echo '<input type="date" id="expiracao" name="expiracao"';
						if (isset($data_de_expiracao))
						{
							echo ' value="'.$data_de_expiracao.'"';
						}
						echo '>';
						?>
					</div>
					<div class="form-group">
						<label for="categoria">Categoria:</label>
						<select id="categoria" name="categoria" required>
							<option value="">Selecione</option>
							<?php
							foreach ($categorias as $opcao)
							{
								echo "<option value=".$opcao['id_categoria'];
								if (isset($id_categoria) && $id_categoria == $opcao['id_categoria'])
								{
									echo " selected";
								}
								echo ">".$opcao['nome_categoria']."</option>";
							}
							?>
						</select>
					</div>
				</div>

				<label>Imagens:</label>
				<div class="upload-area">
					<div class="upload-box">Selecione imagem</div>
					<div class="upload-box">Selecione imagem</div>
				</div>

				<label for="link">Link de redirecionamento:</label>
				<?php echo '<input type="url" id="link" name="link" placeholder="https://"';
				if (isset($endereco_link))
				{
					echo ' value="'.$endereco_link.'">';
					echo '<input type="hidden" id="id_link" name="id_link" value="'.$id_link_publicacao.'">';
				}
				else
				{
					echo '>';
				}
				?>

				<?php if (isset($id_publicacao))
				{
					echo '<input type="hidden" id="id_publicacao" name="id_publicacao" value='.$id_publicacao.'>';
				}
				?>

				<div class="buttons">
					<button type="button" class="btn-cancel" onclick="location.href='publicacao_usuario.php'">Voltar</button>
					<button class="btn-save" type="submit">Salvar</button>
				</div>
			</form>
		</section>
	</main>
</body>
</html>