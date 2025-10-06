<?php
// UsuarioControler.php
// Controlador intermediário para manipular dados de usuários no banco de dados

require_once __DIR__ . '/../model/UsuarioModel.php';

class UsuarioControler {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    public function criarUsuario($dados) {
        // Exemplo: $dados = ['nome' => 'João', 'email' => 'joao@email.com', ...]
        return $this->usuarioModel->inserirUsuario($dados);
    }

    public function buscarUsuario($id) {
        return $this->usuarioModel->buscarPorId($id);
    }

    public function atualizarUsuario($id, $dados) {
        return $this->usuarioModel->atualizarUsuario($id, $dados);
    }

    public function deletarUsuario($id) {
        return $this->usuarioModel->deletarUsuario($id);
    }
}

// Exemplo de uso (remova em produção):
// $controler = new UsuarioControler();
// $controler->criarUsuario(['nome' => 'Teste', 'email' => 'teste@teste.com']);
