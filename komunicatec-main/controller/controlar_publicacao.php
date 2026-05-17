<?php // Arquivo controlador intermediário de recebimento de dados da view e envio de dados à model

// Requer arquivo das classes
require_once '../model/model_categoria.php';
require_once '../model/model_publicacao.php';
require_once '../model/model_link_publicacao.php';
require_once '../model/model_comunicador_administrador.php';

// Criar objetos das classes
$categoria = new Categoria();
$publicacao = new Publicacao();
$link_publicacao = new Link_Publicacao();

// Dados do usuário
$comunicador_administrador = new Comunicador_Administrador();
if (session_status() === PHP_SESSION_NONE) session_start(); // Se não houver sessão iniciada, inicia sessão
$comunicador_administrador->id_cpf = $_SESSION['id_cpf'] ?? null;
$comunicador = $comunicador_administrador->consultar_usuario(); // Recebe os valores de busca

// Verifica se há uma solicitação "POST"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST["acao"]))
{
	// Verifica diferentes valores de "acao" via solicitação "GET"
	switch ($_REQUEST["acao"])
	{
		case 'publicar':
			// Recebendo dados do formulário
			$publicacao->titulo				= $_POST["titulo"];
			$publicacao->descricao			= $_POST["descricao"];
			$publicacao->data_expiracao		= $_POST["expiracao"];
			$publicacao->id_categoria_fk	= $_POST["categoria"];

			if (session_status() === PHP_SESSION_NONE) session_start(); // Se não houver sessão iniciada, inicia sessão
			$publicacao->id_cpf_fk			= $_SESSION["id_cpf"];
			
			$link_publicacao->id_publicacao_fk = $publicacao->publicar(); // Executa método e armazena o ID cadastrado
			
			if ($_POST["link"] != null)
			{
				$link_publicacao->endereco_link = $_POST["link"];
				$link_publicacao->criar_link();
			}
			header('location: ../view/publicacao_usuario.php?comunicador='.$_SESSION["id_cpf"]);
			break;
		
			

		case 'atualizacao':
			// Armazenando dados para campos
			$id_publicacao      = $_POST["id_publicacao"]       ?? null;
			$titulo             = $_POST["titulo"]              ?? null;
			$descricao          = $_POST["descricao"]           ?? null;
			$data_publicacao = $_POST["data_publicacao"]		?? null;
			$data_expiracao  = $_POST["data_expiracao"]			?? null;
			$id_categoria       = $_POST["id_categoria"]        ?? null;

			$id_link_publicacao = $_POST["id_link_publicacao"]  ?? null;
			$endereco_link      = $_POST["endereco_link"]       ?? null;

			$id_cpf_fk			= $_POST["id_cpf_fk"]			?? null;

			$acao_form = "atualizar";
			break;
		
		case 'atualizar':
			// Recebendo dados do formulário
			$publicacao->id_publicacao          = $_POST["id_publicacao"];
			$publicacao->titulo                 = $_POST["titulo"];
			$publicacao->descricao              = $_POST["descricao"];
			$publicacao->data_expiracao			= $_POST["expiracao"];
			$publicacao->id_categoria_fk        = $_POST["categoria"];

			$publicacao->atualizar(); // Executa método

			if ($_POST["link"] != null)
				{
				$link_publicacao->id_link_publicacao    = $_POST["id_link"];
				$link_publicacao->endereco_link         = $_POST["link"];
				$link_publicacao->editar_link();
			}

			//$publicacao->log_ultima_modificacao = ;
			
			header('location: ../view/publicacao_usuario.php?comunicador='.$_POST["id_cpf_fk"]);
			break;
		


		case 'excluir':
			$publicacao->id_publicacao = $_POST["id_publicacao"]; // Recebe ID de publicação
			$publicacao->apagar(); // Executa método
			
			if (session_status() === PHP_SESSION_NONE) session_start(); // Se não houver sessão iniciada, inicia sessão
			header('location: ../view/publicacao_usuario.php?comunicador='.$_SESSION["id_cpf"]);
			break;



		default:
			echo "Ação não encontrada";
			break;
	}    
}
?>