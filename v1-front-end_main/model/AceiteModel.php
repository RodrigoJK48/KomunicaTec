<?php
// model/AceiteModel.php
require_once __DIR__ . "/BaseModel.php";

/**
 * Registra aceite obrigatório (termos/política) e opcional (newsletter).
 */
class AceiteModel extends BaseModel {

    public function inserirObrigatorio(int $idUsuario, int $termos, int $politica, string $data): bool {
        $sql = "INSERT INTO aceite_obrigatorio
                (aceite_termo_de_uso, data_do_aceite, aceite_politica_de_privacidade, id_usuario_fk)
                VALUES (:termos, :data, :politica, :id)";
        return $this->exec($sql, [
            ':termos'   => $termos,
            ':data'     => $data,
            ':politica' => $politica,
            ':id'       => $idUsuario,
        ]);
    }

    public function inserirOpcional(int $idUsuario, int $newsletter, string $data): bool {
        $sql = "INSERT INTO aceite_opcional
                (aceite_newsletter, data_do_aceite, id_usuario_fk)
                VALUES (:news, :data, :id)";
        return $this->exec($sql, [
            ':news' => $newsletter,
            ':data' => $data,
            ':id'   => $idUsuario,
        ]);
    }
}
