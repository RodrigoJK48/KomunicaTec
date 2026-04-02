<?php
require_once __DIR__ . '/../includes/auth.php';
exigirAlunoOuEgresso();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Meu Perfil - KomunicaTec</title>
  <link rel="stylesheet" href="/komunicatec/view/view_profile.css">
</head>
<body>
  <?php include __DIR__ . '/navbar.php'; ?>
  <!-- Reaproveite seu HTML atual e, se quiser, puxe dados do usuário pela sessão -->
  <main class="container">
    <aside class="perfil-card">
      <img src="/komunicatec/view/imagens/user_icon.jpg" class="foto-perfil" alt="">
      <h2><?= htmlspecialchars($_SESSION['nome'] ?? 'Meu Perfil') ?></h2>
      <p class="cargo"><?= in_array($_SESSION['role']??'', ['aluno','egresso']) ? 'Discente/Egresso' : '' ?></p>
      <p class="label">e-mail institucional:</p>
      <p><?= htmlspecialchars($_SESSION['email'] ?? '') ?></p>
      <a class="contatar" href="/komunicatec/auth/logout.php">Sair</a>
    </aside>

    <section class="perfil-info">
      <h1>Perfil</h1>
      <p>Bem-vindo(a) à sua área!</p>
    </section>
  </main>
</body>
</html>
