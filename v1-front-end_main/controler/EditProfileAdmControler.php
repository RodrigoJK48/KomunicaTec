<?php
// EditProfileAdmControler.php
// Controlador para edição de perfil de administrador

require_once __DIR__ . '/../model/UsuarioModel.php';

class EditProfileAdmControler {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    public function editarPerfilAdm($id, $dados) {
        // Lógica específica para admin pode ser adicionada aqui
        return $this->usuarioModel->atualizarUsuario($id, $dados);
    }
}
