<?php
declare(strict_types=1);
require_once __DIR__ . '/../model/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /komunicatec/view/register.php'); exit;
}

$nome  = trim($_POST['nome']  ?? '');
$email = trim($_POST['email'] ?? '');
$ra    = trim($_POST['ra']    ?? '');
$senha = $_POST['senha'] ?? '';
$tipo  = $_POST['tipo'] ?? 'aluno'; // 'aluno' ou 'egresso'

if ($nome === '' || $email === '' || $senha === '' || !in_array($tipo, ['aluno','egresso'], true)) {
  header('Location: /komunicatec/view/register.php?erro=campos'); exit;
}

try {
  $pdo = (new Conexao())->Conectar();

  // impede email duplicado
  $stmt = $pdo->prepare("SELECT 1 FROM usuario WHERE email = ? LIMIT 1");
  $stmt->execute([$email]);
  if ($stmt->fetch()) {
    header('Location: /komunicatec/view/register.php?erro=email'); exit;
  }

  $hash = password_hash($senha, PASSWORD_DEFAULT);

  $ins = $pdo->prepare("INSERT INTO usuario (nome, email, senha, role, ra) VALUES (?, ?, ?, ?, ?)");
  $ins->execute([$nome, $email, $hash, $tipo, $ra !== '' ? $ra : null]);

  header('Location: /komunicatec/view/login.php?ok=cadastrado'); exit;

} catch (Throwable $e) {
  header('Location: /komunicatec/view/register.php?erro=servidor'); exit;
}
