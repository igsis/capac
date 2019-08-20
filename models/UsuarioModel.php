<?php
if ($pedidoAjax) {
    require_once "../models/DbModel.php";
} else {
    require_once "./models/DbModel.php";
}

class UsuarioModel extends MainModel
{
    protected function getUsuario($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":email", $dados['email']);
        $statement->bindParam(":senha", $dados['senha']);
        $statement->execute();
        return $statement;
    }

}