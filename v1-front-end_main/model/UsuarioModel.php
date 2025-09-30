<?php
// model/UsuarioModel.php
require_once __DIR__ . "/BaseModel.php";

/**
 * CRUD e utilitários para a tabela `usuario`.
 * Importante: senhas devem estar sempre com password_hash()
 */
class UsuarioModel extends BaseModel {

    public function buscarPorId(int $id): ?array {
        $sql = "SELECT * FROM usuario WHERE id_usuario = :id LIMIT 1";
        return $this->one($sql, [':id' => $id]);
    }

    public function buscarPorEmail(string $email): ?array {
        $sql = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
        return $this->one($sql, [':email' => $email]);
    }

    /**
     * Cria usuário. Espera:
     *  nome, sobrenome, email, senhaHash, telefone|null, visibilidade_telefone(int), foto_de_perfil|null
     * Retorna id do novo usuário ou 0 se falhar.
     */
    public function criar(array $data): int {
        $sql = "INSERT INTO usuario 
                (nome, sobrenome, email, senha, telefone, visibilidade_telefone, foto_de_perfil)
                VALUES (:nome, :sobrenome, :email, :senha, :telefone, :visibilidade, :foto)";
        $ok = $this->exec($sql, [
            ':nome'         => $data['nome'],
            ':sobrenome'    => $data['sobrenome'],
            ':email'        => $data['email'],
            ':senha'        => $data['senhaHash'], // já vem com password_hash
            ':telefone'     => $data['telefone'],
            ':visibilidade' => $data['visibilidade_telefone'],
            ':foto'         => $data['foto_de_perfil'],
        ]);
        return $ok ? $this->lastId() : 0;
    }

    /**
     * Atualiza dados cadastrais (não altera senha).
     */
    public function atualizar(int $id, array $data): bool {
        $sql = "UPDATE usuario SET 
                    nome = :nome,
                    sobrenome = :sobrenome,
                    email = :email,
                    telefone = :telefone,
                    visibilidade_telefone = :visibilidade,
                    foto_de_perfil = :foto
                WHERE id_usuario = :id";
        return $this->exec($sql, [
            ':nome'         => $data['nome'],
            ':sobrenome'    => $data['sobrenome'],
            ':email'        => $data['email'],
            ':telefone'     => $data['telefone'],
            ':visibilidade' => $data['visibilidade_telefone'],
            ':foto'         => $data['foto_de_perfil'],
            ':id'           => $id,
        ]);
    }

    /**
     * Atualiza a senha (gera hash aqui).
     */
    public function atualizarSenha(int $id, string $senhaNovaPlain): bool {
        $hash = password_hash($senhaNovaPlain, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET senha = :senha WHERE id_usuario = :id";
        return $this->exec($sql, [':senha' => $hash, ':id' => $id]);
    }

    /**
     * Liga/Desliga visibilidade do telefone (0/1).
     */
    public function atualizarVisibilidadeTelefone(int $id, int $flag): bool {
        $sql = "UPDATE usuario SET visibilidade_telefone = :flag WHERE id_usuario = :id";
        return $this->exec($sql, [':flag' => $flag, ':id' => $id]);
    }

    /**
     * Exclui usuário se não houver dependências (FKs sem CASCADE).
     */
    public function deletar(int $id): bool {
        // Verifica dependências
        $dep = $this->one("
            SELECT 1 FROM (
               SELECT id_usuario_fk FROM aceite_opcional                  WHERE id_usuario_fk = :id
               UNION ALL
               SELECT id_usuario_fk FROM aceite_obrigatorio               WHERE id_usuario_fk = :id
               UNION ALL
               SELECT id_usuario_fk FROM perfil_discente_egresso          WHERE id_usuario_fk = :id
               UNION ALL
               SELECT id_usuario_fk FROM perfil_administrador_comunicador WHERE id_usuario_fk = :id
            ) t LIMIT 1
        ", [':id' => $id]);

        if ($dep) return false;

        $sql = "DELETE FROM usuario WHERE id_usuario = :id";
        return $this->exec($sql, [':id' => $id]);
    }
}
