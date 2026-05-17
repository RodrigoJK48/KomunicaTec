<?php // Arquivo de modelagem da classe "Comunicador_Administrador"

require_once __DIR__ . "/conexao.php"; // Requer arquivo de conexão ao banco de dados

class Comunicador_Administrador // Declaração da classe
{
	// Características de classe: Atributos de "perfil_comunicador_administrador"
	private $id_cpf;
	private $cargo;
	private $nivel_de_acesso;
	private $status;
	private $id_usuario_fk;

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

	public function consultar_usuario() // Verifica dados recebidos com os dados cadastrados
	{
		// Comando SQL de busca
		$consulta_SQL = "SELECT
			a.id_cpf,
			u.nome,
			u.sobrenome,
			u.email,
			u.telefone,
			u.visibilidade_telefone,
			a.cargo,
			a.nivel_acesso,
			a.status,
			a.id_usuario_fk
		FROM
			perfil_administrador_comunicador a
        LEFT JOIN
            usuario u ON u.id_usuario = a.id_usuario_fk
		WHERE
			a.id_cpf = ?
		LIMIT 1";

		$valores_consulta = array($this->id_cpf); // Recebe o parâmetro de busca

		$executar = $this->con->prepare($consulta_SQL); // Prepara o comando de seleção e o armazena
		$executar->execute($valores_consulta); // Executa o comando com a especificação
		
		$valores = $executar->fetchAll(); // Armazena os valores da consulta
		if ($valores) // Se existem valores na consulta
		{
			foreach ($valores as $valor) // Para cada linha do resultado da execução (consulta), armazena a linha em $valor
			{
				$consulta['id_cpf']					= $valor['id_cpf']; // Armazena resultado da busca
				$consulta["nome"]					= $valor["nome"];
				$consulta["sobrenome"]				= $valor["sobrenome"];
				$consulta["email"]					= $valor["email"];
				$consulta["telefone"]				= $valor["telefone"];
				$consulta["visibilidade_telefone"]	= $valor["visibilidade_telefone"];
				$consulta['cargo']					= $valor['cargo'];
				$consulta['nivel_acesso']			= $valor['nivel_acesso'];
				$consulta['status']					= $valor['status'];
				$consulta['id_usuario_fk']			= $valor['id_usuario_fk'];
			}
			return $consulta; // Retorna o valor da busca
		}
	}
}