<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class FomentoController extends MainModel
{
    public function listaFomentos()
    {
        return DbModel::listaPublicado("fom_editais");
    }

    public function recuperaTipoContratacao($edital_id) {
        $sql = "SELECT tipo_contratacao_id FROM fom_editais WHERE id = '$edital_id'";
        return DbModel::consultaSimples($sql)->fetchColumn();
    }
}