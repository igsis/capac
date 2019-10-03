<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class LiderController extends MainModel
{
    public function insereLider()
    {
        PessoaFisicaController::inserePessoaFisica($_POST['pagina']);
       //$insere = DbModel::insert("lideres")

    }
}