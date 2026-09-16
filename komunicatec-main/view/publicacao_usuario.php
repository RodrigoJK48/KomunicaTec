<?php // Página de exibição de publicações feitas por usuários
require_once '../controller/controlar_publicacao.php'; // Requer arquivo controlador para exibição de publicações

// Executa a função de consulta, recebe dados de publicações e categorias
$categorias = $categoria->consultar();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Minhas Publicações - KomunicaTec</title>
	<link rel="stylesheet" href="cabecario.css">
	<link rel="stylesheet" href="footer.css">
	<link rel="stylesheet" href="my_publi.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
	<style>
		.oculto { display: none; } /* .ativo não será usada para display, mas mantida por compatibilidade */
	</style>
</head>

<body>
	<!-- Cabeçalho e navegação principal -->
	<?php
	include_once 'cabecario.php'; // Inclui o código arquivo uma vez, evitando repetição ao recarregar a página
	?>

	<!-- Layout principal -->
	<main class="container">
		<!-- Card lateral -->
		<?php
		include_once 'card_perfil.php'; // Inclui o código arquivo uma vez, evitando repetição ao recarregar a página
		?>

		<!-- Publicações -->
		<section class="publicacoes">
			<h1>Minhas Publicações</h1>

			<!-- Filtro -->
			<div class="filtro">
				<?php
				foreach ($categorias as $opcao)
				{
					echo "<label><input type='checkbox' class='filtro-checkbox' value=".htmlspecialchars($opcao['nome_categoria']).">".htmlspecialchars($opcao['nome_categoria'])."</label>";
				}
				?>
			</div>
			
			<?php
			if (isset($_SESSION["id_cpf"])):
			if ($comunicador["id_cpf"] == $_SESSION["id_cpf"]): // Verifica se o perfil pertence ao usuario atual
			?>
			<button class="editar" onclick="location.href='form_publicacao.php'">+ Adicionar</button>
			<?php endif; endif; ?>

			<?php if ($publicados == null): // Verifica se não foi retornado nehuma publicação ?>

				<h1>Nenhuma informação encontrada</h1>

			<?php else: ?>

				<!-- Lista de publicações -->
				<?php foreach($publicados as $publicado): ?>
				<?= "<div id='pub-".$publicado['id_publicacao'].
					"'class='publicacao-card oculto'
					categoria='".htmlspecialchars($publicado["nome_categoria"] ?? "Outro").
					"'>" ?>
					<div class="cabecalho">
						<h2><?= $publicado["titulo"] ?></h2>
						<?= $publicado["nome_categoria"] ?>
						<span align="right">
							Publicado em <?= date("d/m/Y H:i", strtotime($publicado["data_publicacao"])) // Formato da data, converte valor string para tempo ?>
							<br>Valido até <?= date("d/m/Y", strtotime($publicado["data_expiracao"])) ?>
						</span>
					</div>
					<!-- "whitespace: pre-line" converte quebras de linha para HTML -->
					<p style="white-space: pre-line;"><?= $publicado["descricao"] ?></p>
					<?php
					if (isset($publicado["endereco_link"]) && $publicado["endereco_link"] != null)
					{
						echo '<a href="'.$publicado["endereco_link"].'" class="link">'.$publicado["endereco_link"].'</a>';
					}
					?>

					<?php
					if (session_status() === PHP_SESSION_NONE) session_start(); // Se não houver sessão iniciada, inicia sessão
					if (isset($_SESSION["id_cpf"])):
					if ($comunicador["id_cpf"] == $_SESSION["id_cpf"] || $_SESSION["nivel_acesso"] == "administrador"): // Verifica se o perfil pertence ao usuario atual
					?>
					<div class="acoes">
						<?php // "json_encode()" Permite tratar valores nulos e já declara variáveis para a função JavaScript
						echo "<button class='editar'
							onclick='atualizar(".json_encode([
								"id_publicacao"			=> $publicado['id_publicacao'],
								"titulo"				=> $publicado['titulo'],
								"descricao"				=> $publicado['descricao'],
								"data_publicacao"		=> $publicado['data_publicacao'],
								"data_expiracao"		=> $publicado['data_expiracao'],
								"endereco_link"			=> $publicado['endereco_link'],
								"id_categoria"			=> $publicado['id_categoria'],
								"id_link_publicacao"	=> $publicado['id_link_publicacao'],
								"id_cpf_fk"				=> $publicado['id_cpf_fk']
							]).")'
						>
							Editar
						</button>";
						echo "<button class='excluir' onclick='apagar(".$publicado['id_publicacao'].")'>Excluir</button>";
						?>
					</div>
					<?php endif; endif; ?>
				</div>
				<?php endforeach; ?>

			<?php endif; ?>
			
			<!-- Base de publicações -->
			<!--div class="publicacao-card">
				<div class="cabecalho">
					<h2>Convite ao Simbaju DSM!</h2>
					<span>Publicado em 08/11/2024</span>
				</div>
				<p>
					Boa tarde a todos! Nos dias 12, 13 e 14, ocorrerão as apresentações do Simbaju do DSM.
					Estudantes do GT1 e G3E estão convidados.
				</p>
				<div class="acoes">
				   <button class="editar" onclick="location.href='form_publicacao.html'">Editar</button>
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
					<button class="editar" onclick="location.href='form_publicacao.html'">Editar</button>
					<button class="excluir">Excluir</button>
				</div>
			</div-->
		</section>
	</main>

	<!-- Rodapé -->
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

        const publicacoes = document.querySelectorAll('.publicacao-card');
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

		function atualizar(dados) // Abrir formulário de edição
		{
			// Cria formulário oculto para enviar dados e ação ao formulário de edição
			const FORM_ATUALIZACAO = document.createElement('form'); // Declara elemento de formulário
			FORM_ATUALIZACAO.method = 'POST'; // Estabelece método de requisição como POST
			FORM_ATUALIZACAO.action = 'form_publicacao.php?acao=atualizacao'; // Destino dos dados enviados
			FORM_ATUALIZACAO.style.display = 'none'; // Exibição oculta, não aparece na tela do usuário

			for (const dado in dados) // Para cada linha de "dados"
			{
				if (dados.hasOwnProperty(dado))
				{
	   				// Campos de recebimento de dados
					const ENTRADA = document.createElement('input'); // Declara elemento input
					ENTRADA.type = 'hidden'; // Tipo oculto, não aparece na tela do usuário
					ENTRADA.name = dado; // Estabelece nome para recebimento do controlador
					ENTRADA.value = dados[dado]; // Aplica valor recebido (id de publicação)
					FORM_ATUALIZACAO.appendChild(ENTRADA); // Estabelece herança com o formulário
				}
			}

			document.body.appendChild(FORM_ATUALIZACAO); // Estabelece herança com o body
			FORM_ATUALIZACAO.submit(); // Envia o formulário
		}



		function apagar(id_publicacao) // Apagar publicação selecionada
		{
			if (confirm("Deseja realmente excluir esta publicação?")) // Alerta de confirmação
			{
				// Cria formulário oculto para enviar código e ação ao controlador
				const FORM_EXCLUSAO = document.createElement('form'); // Declara elemento de formulário
				FORM_EXCLUSAO.method = 'POST'; // Estabelece método de requisição como POST
				FORM_EXCLUSAO.action = '../controller/controlar_publicacao.php?acao=excluir'; // Destino dos dados enviados
				FORM_EXCLUSAO.style.display = 'none'; // Torna oculto
		
				// Campo de recebimento de id_publicacao
				const ID_EXCLUSAO = document.createElement('input'); // Declara elemento input
				ID_EXCLUSAO.type = 'hidden'; // Tipo oculto, não aparece na tela do usuário
				ID_EXCLUSAO.name = 'id_publicacao'; // Estabelece nome para recebimento do controlador
				ID_EXCLUSAO.value = id_publicacao; // Aplica valor recebido (id de publicação)
				FORM_EXCLUSAO.appendChild(ID_EXCLUSAO); // Estabelece herança com o formulário

				document.body.appendChild(FORM_EXCLUSAO); // Estabelece herança com o body
				FORM_EXCLUSAO.submit(); // Envia o formulário
			}
		}
	</script>
</body>
</html>