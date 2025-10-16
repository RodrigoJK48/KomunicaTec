<?php
// Arquivo de modelagem da classe "Usuario"
require_once __DIR__ . "/conexao.php"; // Requer arquivo de conexão ao banco de dados

class Usuario
{
    // Atributos da tabela `usuario`
    private $id_usuario;
    private $nome;
    private $sobrenome;
    private $email;
    private $senha; // RECEBE a senha em texto → o model fará o hash no INSERT/UPDATE
    private $telefone; // pode ser null
    private $visibilidade_telefone; // TINYINT (0/1)
    private $foto_de_perfil; // pode ser null

    private $con; // PDO

    // Métodos mágicos
    public function __get($atributo)
    {
        return $this->$atributo ?? null;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    // Construtor (abre conexão via PDO)
    public function __construct()
    {
        $conectar = new Conexao();
        $this->con = $conectar->Conectar();
    }

    // ===== CRUD =====

    // Cadastrar usuário
    public function cadastrar()
    {
        $sql = "INSERT INTO usuario
                (nome, sobrenome, email, senha, telefone, visibilidade_telefone, foto_de_perfil)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $values = array(
            $this->nome,
            $this->sobrenome,
            $this->email,
            password_hash($this->senha, PASSWORD_DEFAULT), // segurança
            $this->telefone,
            (int) $this->visibilidade_telefone,
            $this->foto_de_perfil
        );

        $stmt = $this->con->prepare($sql);
        $stmt->execute($values);

        // Retorna o ID criado (pode ser útil ao controller)
        return (int) $this->con->lastInsertId();
    }

    // Listar todos os usuários
    public function consultar_todos()
    {
        $sql = "SELECT * FROM usuario";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();

        $usuarios = array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $usuarios[] = [
                "id_usuario"            => $row['id_usuario'],
                "nome"                  => $row['nome'],
                "sobrenome"             => $row['sobrenome'],
                "email"                 => $row['email'],
                // Nunca devolva a hash da senha na listagem pública. Se precisar, remova a linha abaixo.
                //"senha"               => $row['senha'],
                "telefone"              => $row['telefone'],
                "visibilidade_telefone" => $row['visibilidade_telefone'],
                "foto_de_perfil"        => $row['foto_de_perfil']
            ];
        }
        return $usuarios;
    }

    // Buscar por ID (útil para telas de edição/visualização)
    public function consultar_por_id()
    {
        $sql = "SELECT * FROM usuario WHERE id_usuario = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$this->id_usuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    // Buscar por e-mail (útil para login)
    public function consultar_por_email()
    {
        $sql = "SELECT * FROM usuario WHERE email = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$this->email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    // Atualizar (se $this->senha estiver setada, faz hash novo; senão mantém a atual)
    public function atualizar()
    {
        // Monta SQL dinamicamente para só atualizar senha se ela vier preenchida
        if (!empty($this->senha)) {
            $sql = "UPDATE usuario
                    SET nome = ?, sobrenome = ?, email = ?, senha = ?, telefone = ?, visibilidade_telefone = ?, foto_de_perfil = ?
                    WHERE id_usuario = ?";
            $values = array(
                $this->nome,
                $this->sobrenome,
                $this->email,
                password_hash($this->senha, PASSWORD_DEFAULT),
                $this->telefone,
                (int) $this->visibilidade_telefone,
                $this->foto_de_perfil,
                (int) $this->id_usuario
            );
        } else {
            $sql = "UPDATE usuario
                    SET nome = ?, sobrenome = ?, email = ?, telefone = ?, visibilidade_telefone = ?, foto_de_perfil = ?
                    WHERE id_usuario = ?";
            $values = array(
                $this->nome,
                $this->sobrenome,
                $this->email,
                $this->telefone,
                (int) $this->visibilidade_telefone,
                $this->foto_de_perfil,
                (int) $this->id_usuario
            );
        }

        $stmt = $this->con->prepare($sql);
        return $stmt->execute($values);
    }

    // Excluir
    public function apagar()
    {
        $sql = "DELETE FROM usuario WHERE id_usuario = ?";
        $stmt = $this->con->prepare($sql);
        return $stmt->execute([(int) $this->id_usuario]);
    }
}