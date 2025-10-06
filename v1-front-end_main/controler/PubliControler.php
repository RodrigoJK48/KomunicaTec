<?php
// PubliControler.php
// Controlador para manipulação de publicações

require_once __DIR__ . '/../model/PubliModel.php';

class PubliControler {
    private $publiModel;

    public function __construct() {
        $this->publiModel = new PubliModel();
    }

    public function criarPubli($dados) {
        // $dados = ['titulo' => 'Título', 'conteudo' => 'Texto', ...]
        return $this->publiModel->inserirPubli($dados);
    }

    public function buscarPubli($id) {
        return $this->publiModel->buscarPorId($id);
    }

    public function atualizarPubli($id, $dados) {
        return $this->publiModel->atualizarPubli($id, $dados);
    }

    public function deletarPubli($id) {
        return $this->publiModel->deletarPubli($id);
    }
}
