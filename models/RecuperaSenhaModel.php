<?php

if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class RecuperaSenhaModel extends MainModel
{
    protected function tokenExiste($email)
    {
        $query = "SELECT * FROM resete_senhas WHERE email = '$email'";
        return DbModel::consultaSimples($query);
    }

    protected function setToken($email, $token)
    {
        $dados = array(
            'email' => $email,
            'token' => $token
        );
        $verifica = $this->tokenExiste($email);
        if ($verifica->rowCount() == 0) {
            $insert = DbModel::insert('resete_senhas', $dados);
            return $insert;
        } else {
            $resultado = $verifica->fetchAll();
            $update = DbModel::update('resete_senhas', $dados, $resultado['id']);
            return $update;
        }

        return false;
    }

    protected function getToken($email)
    {



    }

    protected function validaToken()
    {

    }

}