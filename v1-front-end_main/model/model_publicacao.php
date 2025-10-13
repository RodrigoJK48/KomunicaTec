<?php // Arquivo de modelagem da classe "Publicacao"

require_once __DIR__ . "/conexao.php"; // Requer arquivo de conexão ao banco de dados

class Publicacao // Declaração da classe
{
    // Características de classe: Atributos de "publicacao"
    private $id_publicacao;
    private $titulo;
    private $descricao;
    private $data_de_publicacao;
    private $data_de_ultima_modificacao;
    private $log_ultima_modificacao;
    private $data_de_expiracao;
    private $id_categoria_fk;
    private $id_cpf_fk;

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



    // CRUD da tabela "publicacao"
    public function publicar() // Cadastra dados na tabela
    {
        // Comando SQL de inserção
        $cadastro_SQL = "INSERT INTO publicacao
            (
                titulo,
                descricao,
                data_de_publicacao,
                data_de_ultima_modificacao,
                log_ultima_modificacao,
                data_de_expiracao,
                id_categoria_fk,
                id_cpf_fk
            )
            VALUES (?, ?, ?, NULL, NULL, ?, ?, ?)";
        // Valores de inserção
        $valores_cadastro = array(
            $this->titulo,
            $this->descricao,
            date('Y-m-d H:i:s'), // Gera data e hora no formato MySQL: yyyy-mm-dd
            $this->data_de_expiracao,
            $this->id_categoria_fk,
            $this->id_cpf_fk
        );

        $executar = $this->con->prepare($cadastro_SQL); // Prepara o comando de cadastro e o armazena
        $executar->execute($valores_cadastro); // Executa o comando com os valores especificados
    }

    public function consultar_todos() // Consulta dados da tabela, sem especificações
    {
        $consulta_SQL = "SELECT * FROM publicacao"; // Comando SQL de seleção
        $executar = $this->con->prepare($consulta_SQL); // Prepara o comando de seleção e o armazena
        $executar->execute(); // Executa o comando sem especificações
        
        $publicacoes = array(); // Array que armazena resultado da consulta
        foreach ($executar->fetchAll() as $valor) // Para cada linha do resultado da execução (consulta), armazena a linha em $valor
        {
            $publicacoes [] = [
                "id_publicacao"                 => $valor['id_publicacao'],
                "titulo"                        => $valor['titulo'],
                "descricao"                     => $valor['descricao'],
                "data_de_publicacao"            => $valor['data_de_publicacao'],
                "data_de_ultima_modificacao"    => $valor['data_de_ultima_modificacao'],
                "log_ultima_modificacao"        => $valor['log_ultima_modificacao'],
                "data_de_expiracao"             => $valor['data_de_expiracao'],
                "id_categoria_fk"               => $valor['id_categoria_fk'],
                "id_cpf_fk"                     => $valor['id_cpf_fk']
            ];
        }
        return $publicacoes; // Retorna o array da consulta
    }

    /*
    public function apagar() // Deleta uma publicação específica
    {
        $exclusao_SQL = "DELETE FROM publicacao WHERE id_publicacao = ?"; // Comando SQL de exclusão
        $valores_exclusao = array($this->id_publicacao);
        $executar = $this->con->prepare($exclusao_SQL); // Prepara o comando de seleção e o armazena
        $executar->execute($valores_exclusao); // Executa o comando com os valores especificados
    }
    */
}

?>