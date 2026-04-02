<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

function usuarioLogado(): bool {
  return isset($_SESSION['id_usuario']);
}

function roleAtual(): ?string {
  return $_SESSION['role'] ?? null;
}

function exigirLogin(): void {
  if (!usuarioLogado()) {
    header('Location: /komunicatec/view/login.php?erro=login');
    exit;
  }
}

function exigirAdminOuComunicador(): void {
  exigirLogin();
  $r = roleAtual();
  if (!in_array($r, ['admin','comunicador'], true)) {
    header('Location: /komunicatec/view/view_profile.php?erro=perm');
    exit;
  }
}

function exigirAlunoOuEgresso(): void {
  exigirLogin();
  $r = roleAtual();
  if (!in_array($r, ['aluno','egresso'], true)) {
    header('Location: /komunicatec/view/publicacao.php?erro=perm');
    exit;
  }
}

function logout(): void {
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
  }
  session_destroy();
}
