<header>
	<nav class="nav-bar">
		<figure class="imagem-icon">
			<img src="imagens/logo1.png" alt="Logo da KomunikaTec" class="img-logo">
		</figure>
		<div class="botao-navegacao">
			<button class="botao" onclick="location.href='index.php'">Home</button>
			<?php
			if (session_status() === PHP_SESSION_NONE) session_start(); // Se não houver sessão iniciada, inicia sessão
			
			if (!isset($_SESSION['usuario_ativo']) || $_SESSION['usuario_ativo'] == FALSE) : // Verifica se há um usuário ativo, se a variável foi declarada
			?>
				<button class="botaoent" onclick="location.href='login.php'">Entrar</button>
				<button class="botao-especial" onclick="location.href='register.html'">Cadastrar</button>
			<?php else: // Se a variável foi declarada ?>
				<button class="botvisu" onclick="location.href='publicacao.php'">Publicações</button>
				<?php
				echo '<img src="imagens/user_icon.jpg" alt="Acessar Perfil" class="nav-profile" title="Acessar Perfil"';
				if (isset($_SESSION['id_cpf']))
				{
					echo " onclick=\"location.href='publicacao_usuario.php?comunicador=".$_SESSION["id_cpf"]."'\">";
				}
				else
				{
					echo " onclick=\"location.href='publicacao_usuario.php?perfil=".$_SESSION["id_cpf"]."'\">";
				}
				?>
			<?php endif ?>
		</div>
		<div class="menu-toggle">☰</div><!-- Menu para versão mobile -->
	</nav>
</header>