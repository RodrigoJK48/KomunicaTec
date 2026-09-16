<?php // Arquivo de modelagem da classe "Usuario"

require_once __DIR__ . "/conexao.php"; // Requer arquivo de conexão ao banco de dados

class Usuario // Declaração da classe
{
    // Características de classe: Atributos de "usuario"
	private $id_usuario;
	private $nome;
	private $sobrenome;
	private $email;
	private $senha;
	private $telefone;
	private $visibilidade_telefone;
	private $foto_de_perfil;

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



	public function login_comunicador() // Verifica dados recebidos com os dados cadastrados
	{
		// Comando SQL de busca
        $verifica_SQL = "SELECT
            u.id_usuario, u.email, u.senha, c.id_cpf, c.nivel_acesso
        FROM usuario u
        RIGHT JOIN
            perfil_administrador_comunicador c ON u.id_usuario = c.id_usuario_fk
        WHERE email = ?
        LIMIT 1";
        // Valores de busca
		$valores_verificacao = array($this->email);
        $executar = $this->con->prepare($verifica_SQL); // Prepara o comando de busca e o armazena
        $executar->execute($valores_verificacao); // Executa o comando com os valores especificados
		$valor = $executar->fetch(); // Armazena uma linha de valores da consulta

        if ($valor) // Se existem valores na consulta
        {
            $verificacao['id_usuario']  = $valor['id_usuario']; // Armazena resultado da busca
            $verificacao['email']       = $valor['email'];
            $verificacao['senha']       = $valor['senha'];
            $verificacao['id_cpf']      = $valor['id_cpf'];
            $verificacao['nivel_acesso']      = $valor['nivel_acesso'];

            return $verificacao; // Retorna o valor da busca
        }
	}
}

?>