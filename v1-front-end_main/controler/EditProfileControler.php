<?php
// EditProfileControler.php
// Controlador para edição de perfil de usuário

require_once __DIR__ . '/../model/UsuarioModel.php';

class EditProfileControler {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    public function editarPerfil($id, $dados) {
        return $this->usuarioModel->atualizarUsuario($id, $dados);
    }
}
