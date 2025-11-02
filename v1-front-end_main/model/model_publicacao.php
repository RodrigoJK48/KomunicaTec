<?php // Arquivo de modelagem da classe "Publicacao"

require_once __DIR__ . "/conexao.php"; // Requer arquivo de conexão ao banco de dados

date_default_timezone_set('Brazil/East'); // Formato de data

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
                data_de_expiracao,
                id_categoria_fk,
                id_cpf_fk
            )
        VALUES (?, ?, ?, ?, ?, ?)";

        // Valores de inserção
        $valores_cadastro = array(
            $this->titulo,
            $this->descricao,
            date('Y-m-d H:i:s'), // data_de_publicação: Gera data e hora no formato MySQL: yyyy-mm-dd
            $this->data_de_expiracao,
            $this->id_categoria_fk,
            $this->id_cpf_fk
        );

        $executar = $this->con->prepare($cadastro_SQL); // Prepara o comando de cadastro e o armazena
        $executar->execute($valores_cadastro); // Executa o comando com os valores especificados

        return $this->con->lastInsertId();
    }



    public function consultar_todos() // Consulta dados da tabela, sem especificações
    {
        // Comando SQL de seleção
        $consulta_SQL = "SELECT
            p.id_publicacao,
            p.titulo,
            p.descricao,
            p.data_de_publicacao,
            p.data_de_ultima_modificacao,
            p.log_ultima_modificacao,
            p.data_de_expiracao,

            c.id_categoria,
            c.nome_categoria,

            p.id_cpf_fk,

            l.id_link_publicacao,
            l.endereco_link
        FROM
            publicacao p
        LEFT JOIN
            categoria c ON c.id_categoria = p.id_categoria_fk
        LEFT JOIN
            link_publicacao l ON p.id_publicacao = l.id_publicacao_fk
        ORDER BY
            p.data_de_publicacao DESC";
        // LEFT JOIN permite que publicações sem links ou categorias sejam exibidas

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

                "id_categoria"                  => $valor['id_categoria'],
                "nome_categoria"                => $valor['nome_categoria'],

                "id_cpf_fk"                     => $valor['id_cpf_fk'],
                
                "id_link_publicacao"            => $valor['id_link_publicacao'],
                "endereco_link"                 => $valor['endereco_link']
            ];
        }
        return $publicacoes; // Retorna o array da consulta
    }



    public function atualizar() // Atualiza uma publicação específica
    {
        // Comando SQL de atualização
        $atualiza_SQL = "UPDATE publicacao SET
            titulo = ?,
            descricao = ?,
            data_de_ultima_modificacao = ?,
            log_ultima_modificacao = ?,
            data_de_expiracao = ?,
            id_categoria_fk = ?
        WHERE id_publicacao = ? ORDER BY id_publicacao ASC LIMIT 1";

        // Valores de atualização
        $valores_atualizacao = array(
            $this->titulo,
            $this->descricao,
            date('Y-m-d H:i:s'), // data_de_ultima_modificacao: Gera data e hora no formato MySQL: yyyy-mm-dd
            $this->log_ultima_modificacao,
            $this->data_de_expiracao,
            $this->id_categoria_fk,
            $this->id_publicacao
        );

        $executar = $this->con->prepare($atualiza_SQL); // Prepara o comando de atualização e o armazena
        $executar->execute($valores_atualizacao); // Executa o comando com os valores especificados
    }



    public function apagar() // Deleta uma publicação específica
    {
        // Comando SQL de exclusão
        $exclusao_SQL = "DELETE FROM link_publicacao WHERE id_publicacao_fk = ?;
        DELETE FROM publicacao WHERE id_publicacao = ?";
        $valores_exclusao = array($this->id_publicacao, $this->id_publicacao);
        $executar = $this->con->prepare($exclusao_SQL); // Prepara o comando de seleção e o armazena
        $executar->execute($valores_exclusao); // Executa o comando com os valores especificados
    }
}

?>