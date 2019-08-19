<?php
if ($pedidoAjax) {
    require_once "../models/DbModel.php";
} else {
    require_once "./models/DbModel.php";
}

class UsuarioModel extends DbModel
{
    protected function getUsuario($email) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM usuarios AS usr WHERE usr.email = :email LIMIT 0,1";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":email", $email);
        $statement->execute();

        return $statement->fetchAll();
    }

}