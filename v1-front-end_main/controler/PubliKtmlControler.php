<?php
// PubliKtmlControler.php
// Controlador para manipulação de publicações do tipo KTML

require_once __DIR__ . '/../model/PubliModel.php';

class PubliKtmlControler {
    private $publiModel;

    public function __construct() {
        $this->publiModel = new PubliModel();
    }

    public function criarPubliKtml($dados) {
        // $dados = ['titulo' => 'Título', 'conteudo' => 'Texto', ...]
        return $this->publiModel->inserirPubli($dados);
    }
}
