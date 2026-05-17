<?php // Página de exibição de todas as publicações
require_once '../controller/controlar_publicacao.php'; // Requer arquivo controlador para exibição
$publicados = $publicacao->consultar_todos(); // Executa função de consulta, recebe dados de publicações
$categorias = $categoria->consultar();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Publicações - KomunicaTec</title>
	<link rel="stylesheet" href="cabecario.css">
	<link rel="stylesheet" href="footer.css">
	<link rel="stylesheet" href="publi.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
	<style>
		.oculto { display: none; } /* .ativo não será usada para display, mas mantida por compatibilidade */
	</style>
	</head>
<body>

	<!-- Cabeçalho e navegação principal -->
	<?php
	include_once 'cabecario.php'; // Inclui o código arquivo uma vez, evitando repetição ao recarregar a página
	?>

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
			<?php
			foreach ($categorias as $opcao)
			{
				echo "<label><input type='checkbox' class='filtro-checkbox' value=".htmlspecialchars($opcao['nome_categoria']).">".htmlspecialchars($opcao['nome_categoria'])."</label>";
			}
			?>
		</div>

		<!-- Lista de publicações -->
		<section class="publicacoes">

			<?php if ($publicados == null): // Verifica se não foi retornado nehuma publicação ?>

				<h1>Nenhuma informação encontrada</h1>

			<?php else: ?>
            
				<?php foreach($publicados as $publicado): // Para cada publicação. Se não houver, exibe nenhuma ?>
				<?= "<div id='pub-".$publicado['id_publicacao'].
					"'class='card oculto'
					categoria='".htmlspecialchars($publicado["nome_categoria"] ?? "Outro").
					"'>" ?>
					<div class="card-header">
						<img src="imagens/user_icon.jpg" alt="Foto perfil" class="card-profile">
						<div>
							<h4><?= $publicado["nome"].' '.$publicado["sobrenome"] ?></h4>
							<p class="role"><?= ucfirst($publicado["cargo"]) ?></p>
						</div>
						<?="<button class='btn-view'
							onclick='location.href=\"publicacao_usuario.php?comunicador=".$publicado['id_cpf_fk']."\"'>
							Visualizar Perfil</button>"?>
					</div>

					<div class="card-content">
						<u><?= $publicado["nome_categoria"] ?></u>
						<h3><?= $publicado["titulo"] ?></h3>
						<span class="date">Publicado em <?= date("d/m/Y H:i", strtotime($publicado["data_publicacao"])) // Formato da data, converte valor string para tempo ?></span>
						<!-- "whitespace: pre-line" converte quebras de linha para HTML -->
						<p style="white-space: pre-line;"><?= $publicado["descricao"] ?></p>
						<!--div class="images">
							<img src="simbaju.png" alt="Imagem 1">
							<img src="evento.png" alt="Imagem 2">
						</div-->
						<?php
						if (isset($publicado["endereco_link"]) && $publicado["endereco_link"] != null)
						{
							echo '<a href="'.$publicado["endereco_link"].'" class="link">'.$publicado["endereco_link"].'</a>';
						}
						?>
						<span class="date">Valido até <?= date("d/m/Y", strtotime($publicado["data_expiracao"])) ?></span>
					</div>
				</div>
				<?php endforeach; ?>

            <?php endif; ?>

            <!-- Publicações base -->
			<!--div class="card">
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
			</div-->

		</section>
	</main>

	<footer>
		<p>© 2025 - KomunicaTec</p>
	</footer>

	<script>
		// ========== FUNCIONALIDADE DE FILTRO CORRIGIDA ==========
    let idsPublicacoes = [];

    function inicializarFiltro() {
        const checkboxes = document.querySelectorAll('.filtro-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', aplicarFiltro);
        });

        const publicacoes = document.querySelectorAll('.card');
        publicacoes.forEach(pub => {
            idsPublicacoes.push(pub.id);
        });

        // Mostra todos os cards ao carregar a página
        aplicarFiltro();
    }

    function aplicarFiltro() {
        const categoriasSelecionadas = [];
        const checkboxes = document.querySelectorAll('.filtro-checkbox:checked');
        checkboxes.forEach(checkbox => {
            categoriasSelecionadas.push(checkbox.value.trim());
        });

        const exibirTodos = categoriasSelecionadas.length === 0;

        idsPublicacoes.forEach(id => {
            const elemento = document.getElementById(id);
            if (!elemento) return;

            let categoriaCard = elemento.getAttribute('categoria').trim();
            // Se a categoria do card estiver vazia, considera 'Outros'
            if (categoriaCard === '') {
                categoriaCard = 'Outros';
            }

            if (exibirTodos || categoriasSelecionadas.includes(categoriaCard)) {
                // Mostra o card: simplesmente remove a classe 'oculto'
                elemento.classList.remove('oculto');
            } else {
                // Esconde o card: adiciona a classe 'oculto'
                elemento.classList.add('oculto');
            }
        });
    }

    // Inicializa quando o DOM estiver pronto (apenas uma vez)
    document.addEventListener('DOMContentLoaded', inicializarFiltro);
    // ========== FIM DO FILTRO ==========
	</script>
</body>

</html>