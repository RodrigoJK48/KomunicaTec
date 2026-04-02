<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<nav class="nav-bar">
  <figure class="imagem-icon">
    <img src="/komunicatec/view/imagens/logo1.png" alt="KomunikaTec" class="img-logo">
  </figure>
  <div class="botao-navegacao">
    <button class="botao" onclick="location.href='/komunicatec/index.php'">Home</button>

    <?php if (!isset($_SESSION['id_usuario'])): ?>
      <button class="botaoent" onclick="location.href='/komunicatec/view/login.php'">Entrar</button>
      <button class="botao-especial" onclick="location.href='/komunicatec/view/register.php'">Cadastrar</button>
    <?php else: ?>
      <?php if (in_array($_SESSION['role'], ['admin','comunicador'])): ?>
        <button class="botao" onclick="location.href='/komunicatec/view/publicacao_usuario.php'">Meu Perfil</button>
        <?php else: ?>
          <button class="botao" onclick="location.href='/komunicatec/view/view_profile.php'">Meu Perfil</button>
          <?php endif; ?>
          <button class="botao" onclick="location.href='/komunicatec/view/publicacao.php'">Publicações</button>
      <button class="botao-especial" onclick="location.href='/komunicatec/auth/logout.php'">Sair</button>
    <?php endif; ?>
  </div>
</nav>
