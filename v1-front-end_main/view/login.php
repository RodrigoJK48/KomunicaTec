<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>KomunicaTec - Login</title>
  <link rel="stylesheet" href="/komunicatec/view/login.css">
  <link rel="stylesheet" href="/komunicatec/view/reset.css">
</head>
<body>
  <?php include __DIR__ . '/navbar.php'; ?>

  <main class="campo-bg-login">
    <div class="caixa-login">
      <article>
        <figure>
          <img class="imagem-div1" src="/komunicatec/view/imagens/foto do login-cortada.png" alt="">
        </figure>

        <section class="login-size">
          <h2 class="titulo-login disp">Entrar</h2>

          <?php if (isset($_GET['erro'])): ?>
            <p style="color:#C62828;margin-bottom:10px">
              <?php
                if ($_GET['erro']==='credenciais') echo 'E-mail ou senha inválidos.';
                elseif ($_GET['erro']==='campos') echo 'Preencha e-mail e senha.';
                elseif ($_GET['erro']==='login') echo 'Faça login para continuar.';
                else echo 'Falha no login. Tente novamente.';
              ?>
            </p>
          <?php elseif (isset($_GET['ok']) && $_GET['ok']==='cadastrado'): ?>
            <p style="color:#2e7d32;margin-bottom:10px">Cadastro realizado! Faça login.</p>
          <?php endif; ?>

          <form action="/komunicatec/auth/login.php" method="post">
            <label class="visually-hidden" for="email">E-mail</label>
            <input id="email" class="inputs-login disp" type="email" name="email" placeholder="email" required><br>

            <label class="visually-hidden" for="senha">Senha</label>
            <input id="senha" class="inputs-login disp" type="password" name="senha" placeholder="senha" required><br>

            <p class="cadastro-link">
              Não tem conta? <a href="/komunicatec/view/register.php">Cadastre-se</a>
            </p>

            <button class="butenviar" type="submit">Entrar</button>
          </form>
        </section>
      </article>
    </div>
  </main>
</body>
</html>
