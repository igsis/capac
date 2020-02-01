<?php
if ($pedidoAjax) {
    require_once "../models/DbModel.php";
} else {
    require_once "./models/DbModel.php";
}

class FomentoController extends DbModel
{
    public function listaFomentos()
    {
        $lista = DbModel::listaPublicado("fom_editais","");
        return $lista;
    }
}