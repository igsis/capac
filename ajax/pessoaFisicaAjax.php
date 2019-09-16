<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/PessoaFisicaController.php";
    $insPessoaFisica = new PessoaFisicaController();

    if (isset($_POST['nome'])) {
        if ($_POST['_method'] == "cadastrar") {
            echo $insPessoaFisica->inserePessoaFisica($_POST);
        } elseif ($_POST['_method'] == "editar") {
            echo $insPessoaFisica->editaPessoaFisica($_POST, $_POST['id']);
        }
    }
    elseif (isset($_POST['cpf'])){
        if ($_POST['_method'] == "pesquisar") {
            //echo $insPessoaFisica->inserePessoaFisica($_POST);
        }
    }
} else {
    session_start(['name' => 'cpc']);
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}