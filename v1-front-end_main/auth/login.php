<?php
declare(strict_types=1);
require_once __DIR__ . '/../model/conexao.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /komunicatec/view/login.php'); exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
if ($email === '' || $senha === '') {
  header('Location: /komunicatec/view/login.php?erro=campos'); exit;
}

try {
  $pdo = (new Conexao())->Conectar();
  $stmt = $pdo->prepare("SELECT id_usuario, nome, email, senha, role, ra FROM usuario WHERE email = ? LIMIT 1");
  $stmt->execute([$email]);
  $u = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$u || !password_verify($senha, $u['senha'])) {
    header('Location: /komunicatec/view/login.php?erro=credenciais'); exit;
  }

  $_SESSION['id_usuario'] = (int)$u['id_usuario'];
  $_SESSION['nome']       = $u['nome'];
  $_SESSION['email']      = $u['email'];
  $_SESSION['role']       = $u['role'];
  $_SESSION['ra']         = $u['ra'] ?? null;

  // Redireciona por perfil
  if (in_array($u['role'], ['admin','comunicador'], true)) {
    header('Location: /komunicatec/view/publicacao.php'); // área de gestão
  } else {
    header('Location: /komunicatec/view/view_profile.php'); // perfil do aluno/egresso
  }
  exit;

} catch (Throwable $e) {
  header('Location: /komunicatec/view/login.php?erro=servidor'); exit;
}
