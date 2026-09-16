<?php // Arquivo de modelagem da classe "Link_Publicacao"

require_once __DIR__ . "/conexao.php"; // Requer arquivo de conexão ao banco de dados

class Link_Publicacao // Declaração da classe, herda atributos e características de "Publicacao"
{
    // Características de classe: Atributos de "link_publicacao"
    private $id_link_publicacao;
    private $endereco_link;
    private $id_publicacao_fk;

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



    // CRUD da tabela "link_publicacao"
    public function criar_link() // Cadastra dados na tabela
    {
        // Comando SQL de inserção
        $cadastro_SQL = "INSERT INTO link_publicacao (endereco_link, id_publicacao_fk) VALUES (?, ?)";
        $valores_cadastro = array($this->endereco_link, $this->id_publicacao_fk); // Valores de inserção
        $executar = $this->con->prepare($cadastro_SQL); // Prepara o comando de cadastro e o armazena
        $executar->execute($valores_cadastro); // Executa o comando com os valores especificados
    }

    public function editar_link()
    {
        // Comando SQL de atualização
        $atualiza_SQL = "UPDATE link_publicacao SET endereco_link = ?
        WHERE id_link_publicacao = ? ORDER BY id_link_publicacao ASC LIMIT 1";

        $valores_atualizacao = array($this->endereco_link, $this->id_link_publicacao); // Valores de atualização
        $executar = $this->con->prepare($atualiza_SQL); // Prepara o comando de atualização e o armazena
        $executar->execute($valores_atualizacao); // Executa o comando com os valores especificados        
    }

}

?>