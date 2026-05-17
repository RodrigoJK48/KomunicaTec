<?php
require_once '../controller/controlar_publicacao.php';
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
<style>
.oculto { display: none; }
/* .ativo não será usada para display, mas mantida por compatibilidade */
</style>
</head>
<body>
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
<main class="container">
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

    <section class="publicacoes">
        <h1>Minhas Publicações</h1>

        <!-- Filtro -->
        <div class="filtro">
            <?php foreach ($categorias as $opcao): ?>
                <?php $nomeCat = trim($opcao['nome_categoria']); ?>
                <?php if ($nomeCat !== ''): ?>
                    <label>
                        <input type="checkbox" class="filtro-checkbox" value="<?= htmlspecialchars($nomeCat) ?>"> <?= htmlspecialchars($nomeCat) ?>
                    </label>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <button class="editar" onclick="location.href='form_publicacao.php'">+ Adicionar</button>

        <!-- Lista de publicações -->
        <?php foreach($publicados as $publicado): ?>
            <?php
            // Garante que a categoria não seja vazia; se for, define como 'Outros'
            $categoriaCard = isset($publicado['nome_categoria']) ? trim($publicado['nome_categoria']) : '';
            if ($categoriaCard === '') {
                $categoriaCard = 'Outros';
            }
            ?>
            <div id="pub-<?= $publicado['id_publicacao'] ?>" class="publicacao-card oculto" data-categoria="<?= htmlspecialchars($categoriaCard) ?>">
                <div class="cabecalho">
                    <h2><?= $publicado["titulo"] ?></h2>
                    <?= htmlspecialchars($categoriaCard) ?>
                    <span>Publicado em <?= date("d/m/Y H:i", strtotime($publicado["data_de_publicacao"])) ?><br>
                    Valido até <?= date("d/m/Y", strtotime($publicado["data_de_expiracao"])) ?></span>
                </div>
                <p style="white-space: pre-line;"><?= $publicado["descricao"] ?></p>
                <?php if (isset($publicado["endereco_link"]) && $publicado["endereco_link"] != null): ?>
                    <a href="<?= $publicado["endereco_link"] ?>" class="link"><?= $publicado["endereco_link"] ?></a>
                <?php endif; ?>
                <div class="acoes">
                    <button class='editar' onclick='atualizar(
                        <?= $publicado["id_publicacao"] ?>,
                        "<?= addslashes($publicado["titulo"]) ?>",
                        "<?= addslashes($publicado["descricao"]) ?>",
                        "<?= $publicado["data_de_publicacao"] ?>",
                        "<?= $publicado["data_de_expiracao"] ?>",
                        "<?= addslashes($publicado["endereco_link"] ?? '') ?>",
                        <?= $publicado["id_categoria"] ?>,
                        <?= $publicado["id_link_publicacao"] ?>
                    )'>Editar</button>
                    <button class='excluir' onclick='apagar(<?= $publicado["id_publicacao"] ?>)'>Excluir</button>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Base de publicações -->
        <div id="pub-static1" class="publicacao-card oculto" data-categoria="Eventos">
            <div class="cabecalho">
                <h2>Convite ao Simbaju DSM!</h2>
                <span>Publicado em 08/11/2024</span>
            </div>
            <p>Boa tarde a todos! Nos dias 12, 13 e 14, ocorrerão as apresentações do Simbaju do DSM. Estudantes do GT1 e G3E estão convidados.</p>
            <div class="acoes">
                <button class="editar" onclick="location.href='form_publicacao.html'">Editar</button>
                <button class="excluir">Excluir</button>
            </div>
        </div>

        <div id="pub-static2" class="publicacao-card oculto" data-categoria="Vagas">
            <div class="cabecalho">
                <h2>Estágio em Análise de Dados</h2>
                <span>Publicado em 10/11/2024</span>
            </div>
            <p>Bom dia a todos! Um ex-aluno me posicionou sobre uma vaga de estágio em aberto para a empresa XPTO. Interessados, por favor, clicar no link.</p>
            <div class="acoes">
                <button class="editar" onclick="location.href='form_publicacao.html'">Editar</button>
                <button class="excluir">Excluir</button>
            </div>
        </div>
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

            let categoriaCard = elemento.getAttribute('data-categoria').trim();
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

    // Funções originais de editar/excluir (mantidas)
    function atualizar(ID_PUBLICACAO, TITULO, DESCRICAO, DATA_DE_PUBLICACAO, DATA_DE_EXPIRACAO, ENDERECO_LINK, ID_CATEGORIA, ID_LINK_PUBLICACAO) {
        const dados = {
            id_publicacao:      ID_PUBLICACAO,
            titulo:             TITULO,
            descricao:          DESCRICAO,
            data_de_publicacao: DATA_DE_PUBLICACAO,
            data_de_expiracao:  DATA_DE_EXPIRACAO,
            endereco_link:      ENDERECO_LINK,
            id_categoria:       ID_CATEGORIA,
            id_link_publicacao: ID_LINK_PUBLICACAO
        };

        const FORM_ATUALIZACAO = document.createElement('form');
        FORM_ATUALIZACAO.method = 'POST';
        FORM_ATUALIZACAO.action = 'form_publicacao.php?acao=atualizacao';
        FORM_ATUALIZACAO.style.display = 'none';

        for (const dado in dados) {
            if (dados.hasOwnProperty(dado)) {
                const ENTRADA = document.createElement('input');
                ENTRADA.type = 'hidden';
                ENTRADA.name = dado;
                ENTRADA.value = dados[dado];
                FORM_ATUALIZACAO.appendChild(ENTRADA);
            }
        }

        document.body.appendChild(FORM_ATUALIZACAO);
        FORM_ATUALIZACAO.submit();
    }

    function apagar(id_publicacao) {
        if (confirm("Deseja realmente excluir esta publicação?")) {
            const FORM_EXCLUSAO = document.createElement('form');
            FORM_EXCLUSAO.method = 'POST';
            FORM_EXCLUSAO.action = '../controller/controlar_publicacao.php?acao=excluir';
            FORM_EXCLUSAO.style.display = 'none';

            const ID_EXCLUSAO = document.createElement('input');
            ID_EXCLUSAO.type = 'hidden';
            ID_EXCLUSAO.name = 'id_publicacao';
            ID_EXCLUSAO.value = id_publicacao;
            FORM_EXCLUSAO.appendChild(ID_EXCLUSAO);

            document.body.appendChild(FORM_EXCLUSAO);
            FORM_EXCLUSAO.submit();
        }
    }
</script>
</body>
</html>