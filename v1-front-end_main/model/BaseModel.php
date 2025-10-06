<?php
// model/BaseModel.php
require_once __DIR__ . "/conexao.php"; // precisa conter a classe Conexao com método Conectar() que retorna PDO

/**
 * Classe base para Models com PDO.
 * Centraliza conexão, transações e helpers para SELECT/INSERT/UPDATE/DELETE.
 */
abstract class BaseModel {
    /** @var PDO */
    protected PDO $db;

    public function __construct(?PDO $db = null) {
        if ($db instanceof PDO) {
            $this->db = $db;
        } else {
            // Usa sua classe Conexao fornecida
            if (!class_exists('Conexao')) {
                throw new RuntimeException("Classe Conexao não encontrada. Verifique model/conexao.php");
            }
            $this->db = (new Conexao())->Conectar();

            // (Opcional) Garante erros como exceção e charset adequado
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
    }

    /** Transações */
    protected function begin(): void    { $this->db->beginTransaction(); }
    protected function commit(): void   { $this->db->commit(); }
    protected function rollback(): void { $this->db->rollBack(); }

    /**
     * Retorna UMA linha (ou null) a partir de um SELECT.
     * @param string $sql    SELECT com placeholders nomeados (ex.: :id, :email)
     * @param array  $params Array associativo para bind ([':id'=>1])
     */
    protected function one(string $sql, array $params = []): ?array {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row !== false ? $row : null;
    }

    /**
     * Retorna TODAS as linhas (array vazio se não houver dados).
     */
    protected function all(string $sql, array $params = []): array {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Executa INSERT/UPDATE/DELETE. Retorna true/false.
     */
    protected function exec(string $sql, array $params = []): bool {
        $stmt = $this->db->prepare($sql);
        /*teste commit*/
        return $stmt->execute($params);
    }

    /**
     * Último ID autoincrement inserido.
     */
    protected function lastId(): int {
        return (int)$this->db->lastInsertId();
    }
}
