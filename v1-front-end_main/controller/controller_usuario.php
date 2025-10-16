<?php
// Arquivo controlador de "Usuario": recebe dados da view e chama o model
require_once '../model/model_usuario.php';

$usuario = new Usuario();

// Somente processa se vier "POST" e uma "acao"
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_REQUEST["acao"])) {

    switch ($_REQUEST["acao"]) {

        case 'cadastrar':
            // Campos esperados no POST:
            // nome, sobrenome, email, senha, telefone (opcional), visibilidade_telefone (0/1), foto_de_perfil (opcional)
            $usuario->nome                  = $_POST["nome"]                  ?? '';
            $usuario->sobrenome             = $_POST["sobrenome"]             ?? '';
            $usuario->email                 = $_POST["email"]                 ?? '';
            $usuario->senha                 = $_POST["senha"]                 ?? ''; // model fará o hash
            $usuario->telefone              = $_POST["telefone"]              ?? null;
            $usuario->visibilidade_telefone = isset($_POST["visibilidade_telefone"]) ? (int) $_POST["visibilidade_telefone"] : 0;
            $usuario->foto_de_perfil        = $_POST["foto_de_perfil"]        ?? null;

            $idCriado = $usuario->cadastrar();
            echo $idCriado > 0 ? "ok" : "erro";
            break;

        case 'listar':
            $lista = $usuario->consultar_todos();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($lista);
            break;

        case 'buscar_por_id':
            $usuario->id_usuario = (int) ($_POST["id_usuario"] ?? 0);
            $dado = $usuario->consultar_por_id();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($dado);
            break;

        case 'buscar_por_email':
            $usuario->email = $_POST["email"] ?? '';
            $dado = $usuario->consultar_por_email();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($dado);
            break;

        case 'atualizar':
            // Espera id_usuario + demais campos. Se "senha" vier vazia, mantém a atual.
            $usuario->id_usuario            = (int) ($_POST["id_usuario"] ?? 0);
            $usuario->nome                  = $_POST["nome"]                  ?? '';
            $usuario->sobrenome             = $_POST["sobrenome"]             ?? '';
            $usuario->email                 = $_POST["email"]                 ?? '';
            $usuario->senha                 = $_POST["senha"]                 ?? ''; // se vazio, model ignora a troca
            $usuario->telefone              = $_POST["telefone"]              ?? null;
            $usuario->visibilidade_telefone = isset($_POST["visibilidade_telefone"]) ? (int) $_POST["visibilidade_telefone"] : 0;
            $usuario->foto_de_perfil        = $_POST["foto_de_perfil"]        ?? null;

            $ok = $usuario->atualizar();
            echo $ok ? "ok" : "erro";
            break;

        case 'deletar':
            $usuario->id_usuario = (int) ($_POST["id_usuario"] ?? 0);
            $ok = $usuario->apagar();
            echo $ok ? "ok" : "erro";
            break;

        default:
            echo "Ação não encontrada";
            break;
    }
}
