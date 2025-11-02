<?php // Página de exibição de publicações feitas por usuários
require_once '../controller/controlar_publicacao.php'; // Requer arquivo controlador para exibição

// Executa funções de consulta, recebe dados de publicações e categorias
$publicados = $publicacao->consultar_todos();
$categorias = $categoria->consultar();
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
                <button class="botao" onclick="location.href='publicacao.php'">Home</button>
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
                <?php
				foreach ($categorias as $opcao)
				{
					echo "<label><input type='checkbox'> ".$opcao['nome_categoria']."</label>";
				}
				?>
            </div>
            
            <button class="editar" onclick="location.href='form_publicacao.php'">+ Adicionar</button>

            <!-- Lista de publicações -->
            <?php foreach($publicados as $publicado): ?>
            <div class="publicacao-card">
                <div class="cabecalho">
                    <h2><?= $publicado["titulo"] ?></h2>
                    <?= $publicado["nome_categoria"] ?>
                    <span>
                        Publicado em <?= date("d/m/Y H:i", strtotime($publicado["data_de_publicacao"])) // Formato da data, converte valor string para tempo ?>
                    	<br>Valido até <?= date("d/m/Y", strtotime($publicado["data_de_expiracao"])) ?></span>
                </div>
                <!-- "whitespace: pre-line" converte quebras de linha para HTML -->
                <p style="white-space: pre-line;"><?= $publicado["descricao"] ?></p>
                <?php
                if (isset($publicado["endereco_link"]) && $publicado["endereco_link"] != null)
				{
					echo '<a href="'.$publicado["endereco_link"].'" class="link">'.$publicado["endereco_link"].'</a>';
				}
                ?>
                <div class="acoes">
                    <?php
                    echo "<button class='editar'
                        onclick='atualizar(
                            ".$publicado["id_publicacao"].",
                            \"".$publicado["titulo"]."\",
                            \"".$publicado["descricao"]."\",
                            \"".$publicado["data_de_publicacao"]."\",
                            \"".$publicado["data_de_expiracao"]."\",
                            \"".$publicado["endereco_link"]."\",
                            ".$publicado["id_categoria"].",
                            ".$publicado["id_link_publicacao"]."
                        )'
                    >
                        Editar
                    </button>";
                    echo "<button class='excluir' onclick='apagar(".$publicado["id_publicacao"].")'>Excluir</button>";
                    ?>
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
            </div>
        </section>
    </main>

    <!-- Rodapé -->
    <footer>
        <p>© 2025 - KomunicaTec</p>
    </footer>



    <script>
        function atualizar(
			ID_PUBLICACAO, TITULO, DESCRICAO, DATA_DE_PUBLICACAO, DATA_DE_EXPIRACAO, ENDERECO_LINK, ID_CATEGORIA, ID_LINK_PUBLICACAO
		){
            const dados = {
				id_publicacao:		ID_PUBLICACAO,
				titulo:				TITULO,
				descricao:			DESCRICAO,
				data_de_publicacao:	DATA_DE_PUBLICACAO,
				data_de_expiracao:	DATA_DE_EXPIRACAO,
				endereco_link:		ENDERECO_LINK,
				id_categoria:		ID_CATEGORIA,
				id_link_publicacao:	ID_LINK_PUBLICACAO
			};

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



        function apagar(id_publicacao)
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