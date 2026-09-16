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
	<link rel="stylesheet" href="cabecario.css">
	<link rel="stylesheet" href="footer.css">
	<link rel="stylesheet" href="edit_publi.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
	<!-- Cabeçalho e navegação principal -->
	<?php
	include_once 'cabecario.php'; // Inclui o código arquivo uma vez, evitando repetição ao recarregar a página
	?>

	<main class="main-editar-perfil">
		<!-- Card lateral -->
		<?php
		include_once 'card_perfil.php'; // Inclui o código arquivo uma vez, evitando repetição ao recarregar a página
		?>

		<section class="secao-formulario">
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

				<div class="linha-formulario">
					<div class="grupo-formulario">
						<label for="expiracao">Expiração:</label>
						<?php echo '<input type="date" id="expiracao" name="expiracao"';
						if (isset($data_expiracao))
						{
							echo ' value="'.$data_expiracao.'"';
						}
						echo '>';
						?>
					</div>
					<div class="grupo-formulario">
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
				<div class="area-upload">
					<div class="caixa-upload">Selecione imagem</div>
					<div class="caixa-upload">Selecione imagem</div>
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
				if (isset($id_cpf_fk))
				{
					echo '<input type="hidden" id="id_cpf_fk" name="id_cpf_fk" value='.$id_cpf_fk.'>';
				}
				?>

				<div class="buttons">
					<?php
					echo '<button type="button" class="botao-cancelar" onclick="location.href=`publicacao_usuario.php';
					if (isset($id_cpf_fk)) { echo '?comunicador='.$id_cpf_fk; }
					else
					{
						if (session_status() === PHP_SESSION_NONE) session_start(); // Se não houver sessão iniciada, inicia sessão
						echo '?comunicador='.$_SESSION["id_cpf"];
					}
					echo '`">Voltar</button>';
					?>
					<!--button type="button" class="botao-cancelar" onclick="location.href='publicacao_usuario.php'">Voltar</button-->
					<button class="botao-salvar" type="submit">Salvar</button>
				</div>
			</form>
		</section>
	</main>
	<!-- Rodapé -->
	<footer>
		<p>© 2025 - KomunicaTec</p>
	</footer>
</body>
</html>