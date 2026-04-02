<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>KomunicaTec - Cadastro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/komunicatec/view/register.css">
  <link rel="stylesheet" href="/komunicatec/view/reset.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <?php include __DIR__ . '/navbar.php'; ?>

  <main>
    <section class="campo-bg-login">
      <div class="caixa-login">
        <article>
          <figure>
            <img class="imagem-div1" src="/komunicatec/view/imagens/foto do login-cortada.png" alt="Imagem decorativa de cadastro">
          </figure>

          <section class="login-size">
            <h2 class="titulo-login disp">Cadastrar</h2>

            <?php if (isset($_GET['erro'])): ?>
              <p style="color:#C62828;margin-bottom:10px">
                <?php
                  if ($_GET['erro']==='email')   echo 'Este e-mail já está cadastrado.';
                  elseif ($_GET['erro']==='campos') echo 'Preencha todos os campos obrigatórios.';
                  else echo 'Erro no cadastro. Tente novamente.';
                ?>
              </p>
            <?php endif; ?>

            <form action="/komunicatec/auth/register_aluno.php" method="post" novalidate>
              <!-- Define o tipo real enviado ao backend -->
              <input type="hidden" name="tipo" value="aluno" id="tipoPerfil">

              <label for="nome" class="visually-hidden">Nome completo</label>
              <input id="nome" class="inputs-login disp" type="text" name="nome" placeholder="nome completo" required><br>

              <label for="email" class="visually-hidden">E-mail</label>
              <input id="email" class="inputs-login disp" type="email" name="email" placeholder="email" required><br>

              <label for="ra" class="visually-hidden">RA</label>
              <input id="ra" class="inputs-login disp" type="text" name="ra" placeholder="RA (opcional)"><br>

              <label for="senha" class="visually-hidden">Senha</label>
              <input id="senha" class="inputs-login disp" type="password" name="senha" placeholder="senha" required><br>

              <!-- Escolha entre Aluno e Egresso -->
              <div class="cadastro-link" style="margin:8px 0">
                <label>
                  <input type="radio" name="tipoSel" value="aluno" checked
                         onclick="document.getElementById('tipoPerfil').value='aluno'">
                  Aluno
                </label>
                &nbsp;&nbsp;
                <label>
                  <input type="radio" name="tipoSel" value="egresso"
                         onclick="document.getElementById('tipoPerfil').value='egresso'">
                  Egresso
                </label>
              </div>

              <p class="cadastro-link">
                Já tem conta? <a href="/komunicatec/view/login.php">Entrar</a>
              </p>

              <label class="checkbox-container">
                <input type="checkbox" required>
                <span class="custom-checkbox"></span>
                <span>Eu li e aceito a Política de Privacidade</span>
              </label>

              <button class="butenviar" type="submit">Cadastrar</button>
            </form>
          </section>
        </article>
      </div>
    </section>
  </main>
</body>
</html>
