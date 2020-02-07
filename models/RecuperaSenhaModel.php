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

    }

    protected function setToken($email)
    {

    }
    protected function getToken($email)
    {

    }

    protected function validaToken(){
        
    }

}