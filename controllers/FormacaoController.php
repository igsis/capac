<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/MainModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoController extends MainModel
{
    public function insereFormacao()
    {
        
    }
}