<?php
// ViewProfileControler.php
// Controlador para visualização de perfil de usuário

require_once __DIR__ . '/../model/UsuarioModel.php';

class ViewProfileControler {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    public function visualizarPerfil($id) {
        return $this->usuarioModel->buscarPorId($id);
    }
}
