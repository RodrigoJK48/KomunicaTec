<?php // Arquivo de modelagem de classe "Categoria"

require_once __DIR__ . "/conexao.php"; // Requer arquivo de conexão ao banco de dados

class Categoria // Declaração da classe
{
    // Características de classe: Atributos de "categoria"
    private $id_categoria;
    private $nome_categoria;

    private $con; // Objeto de acesso para conexão com BD

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



    public function consultar() // Consulta dados da tabela
    {
        $consulta_SQL = "SELECT * FROM categoria ORDER BY id_categoria"; // Comando SQL de seleção
        $executar = $this->con->prepare($consulta_SQL); // Prepara o comando de seleção e o armazena
        $executar->execute(); // Executa o comando sem especificações

        $categorias = array(); // Array que armazena resultado da consulta
        foreach ($executar->fetchAll() as $valor) // Para cada linha do resultado da execução (consulta), armazena a linha em $valor
        {
            $categorias [] = [
                "id_categoria"      => $valor['id_categoria'],
                "nome_categoria"    => $valor['nome_categoria']
            ];
        }

        return $categorias;
    }
}

?>