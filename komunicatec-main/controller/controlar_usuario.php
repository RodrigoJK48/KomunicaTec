<?php // Arquivo controlador intermediário de recebimento de dados da view e envio de dados à model

// Requer arquivo da classe
require_once '../model/model_usuario.php';
require_once '../model/model_comunicador_administrador.php';

// Criar objeto de classe
$usuario = new Usuario();
$comunicador_administrador = new Comunicador_Administrador();

// Verifica se há uma ação pendente
if (isset($_REQUEST["acao"]))
{
	// Verifica diferentes valores de "acao" via solicitação "GET"
	switch ($_REQUEST["acao"])
	{
		case 'entrar':
			if ($_SERVER["REQUEST_METHOD"] == "POST") // Verifica se há uma solicitação "POST"
			{
				if ($_POST["perfil"] == "comunicador")
				{
					// Recebendo dados do formulário
					$usuario->email = trim($_POST["email"]); // trim() elimina espaços em branco antes e depois da String
					$usuario->senha = $_POST["senha"];
					
					$verifica = $usuario->login_comunicador(); // Recebe valores de login
					
					if ($verifica && password_verify($usuario->senha, $verifica['senha'])) // Se a senha estiver correta
					{
						if (session_status() === PHP_SESSION_NONE) session_start(); // Se não houver sessão iniciada, inicia sessão
						$_SESSION['usuario_ativo'] = TRUE; // Armazena login na sessão
						$_SESSION['id_cpf'] = $verifica['id_cpf']; // Armazena CPF do usuário na sessão
						$_SESSION['nivel_acesso'] = $verifica['nivel_acesso']; // Armazena CPF do usuário na sessão
						header("Location: ../view/publicacao.php"); // Direciona para a página de publicações
					}
					elseif (!$verifica) // Se a verificação não retornar valores
					{
						("Location: ../view/login.php?msg=erro"); // Exibe erro de login
					}
					elseif (!password_verify($usuario->senha, $verifica['senha'])) // Se a verificação da senha estiver incorreta
					{
						header("Location: ../view/login.php?msg=erro"); // Exibe erro de login
					}
				}
			}
		break;

		case 'sair':
			if (session_status() === PHP_SESSION_NONE) // Se não houver sessão iniciada
			{
				session_start(); // Inicia sessão
			}
			session_destroy(); // Destrói a sessão atual
			header("Location: ../index.php"); // Direciona para a página inicial
		break;
	}
}
elseif (isset($_REQUEST["comunicador"])) // Verifica se está buscando um comunicador específico
{
	$comunicador_administrador->id_cpf = $_REQUEST["comunicador"]; // Recebe o CPF do comunicador
	$comunicador = $comunicador_administrador->consultar_usuario(); // Recebe os valores de busca
}
?>