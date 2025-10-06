<?php
// RegisterControler.php
// Controlador para registro de novos usuários

require_once __DIR__ . '/../model/UsuarioModel.php';

class RegisterControler {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    public function registrar($dados) {
        // $dados = ['nome' => 'Novo', 'email' => 'novo@email.com', ...]
        return $this->usuarioModel->inserirUsuario($dados);
    }
}
