<?php // Arquivo de modelagem do modelo de classes: Aplica conexão, getter e setter em todas as classes filhas

require_once __DIR__ . "/conexao.php"; // Requer arquivo de conexão ao banco de dados

abstract class Model
{
    // Característica de classe
    private $con; // Chave de acesso para conexão com BD
    
    // Métodos mágicos de classe
    public function __get($atributo) // Função get mágico automaticamente recebe nome do atributo de classe
    {
        return $this->$atributo ?? null; // Retorna o valor do atributo de classe ou nulo se não encontrar
    }

    public function __set($atributo, $valor) // Função set mágico recebe automaticamente nome do atributo e o valor a aplicar
    {
        $this->$atributo = $valor; // Atribui característica de classe com o valor recebido
    }

    // Construtor de conexão
    public function __construct() // Método construtor: Executa sempre que um objeto de classe for instanciado
    {
        $conectar = new Conexao(); // Objeto de conexão ao BD
        $this->con = $conectar->Conectar(); // Executa método de conexão ao BD
    }
}
