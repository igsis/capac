<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class PessoaFisicaModel extends MainModel
{
    protected function getCPF($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM pessoa_fisicas WHERE cpf = :cpf ";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":cpf", $dados['cpf']);
        $statement->execute();
        return $statement;
    }

    protected function getPassaporte($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM pessoa_fisicas WHERE passaporte = :passaporte";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":passaporte", $dados['passaporte']);
        $statement->execute();
        return $statement;
    }
}