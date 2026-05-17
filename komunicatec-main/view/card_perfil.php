<?php
require_once '../controller/controlar_usuario.php'; // Requer arquivo controlador para exibição do perfil
$publicacao->id_cpf_fk = $comunicador_administrador->id_cpf;
$publicados = $publicacao->consultar_usuario();
?>

<aside class="perfil-card">
	<img src="imagens/user_icon.jpg" alt="Foto de Perfil" class="foto-perfil">
	<h2><?= $comunicador["nome"].' '.$comunicador["sobrenome"] ?></h2>
	<p class="cargo"><?= ucfirst($comunicador["cargo"]) // ucfirst() → Converte a primeira letra da string para maíusculo ?></p>
	<p class="subcargo"><?= ucfirst($comunicador["nivel_acesso"]) ?></p>

	<p class="label">e-mail corporativo:</p>
	<p><?= $comunicador["email"] ?></p>

	<?php if ($comunicador["visibilidade_telefone"] == 1): ?>
		<p class="label">Telefone:</p>
		<p><?=$comunicador["telefone"]?></p>
	<?php endif; ?>
	<br>
	<?php
    if (isset($_SESSION["id_cpf"])):
    if ($comunicador["id_cpf"] == $_SESSION["id_cpf"] || $_SESSION["nivel_acesso"] == "administrador"): // Verifica se o perfil pode editar dados
    ?>
		<button class="botao-especial">Editar Dados</button>
	<?php
    endif;
    if ($comunicador["id_cpf"] == $_SESSION["id_cpf"]): // Verifica se o perfil pertence ao usuario atual
    ?>
		<button class="botao" onclick="logout()">Encerrar Sessão</button>
	<?php endif; endif; ?>
</aside>

<script>
    function logout() // Encerrar sessão atual
	{
    	if (confirm("Deseja realmente sair da conta?")) // Alerta de confirmação
		{
    	    location.href='../controller/controlar_usuario.php?acao=sair'; // Envia ação de encerrar sessão
    	}
	}
</script>