<?php
// MyPubliControler.php
// Controlador para manipulação das publicações do usuário logado

require_once __DIR__ . '/../model/PubliModel.php';

class MyPubliControler {
    private $publiModel;

    public function __construct() {
        $this->publiModel = new PubliModel();
    }

    public function listarMinhasPublicacoes($usuarioId) {
        return $this->publiModel->buscarPorUsuario($usuarioId);
    }

    public function deletarMinhaPublicacao($publiId, $usuarioId) {
        // Verifica se a publicação pertence ao usuário antes de deletar
        return $this->publiModel->deletarSePertenceAoUsuario($publiId, $usuarioId);
    }
}
