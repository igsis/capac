<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/PessoaJuridicaController.php";
    $insPessoaJuridica = new PessoaJuridicaController();

    if (isset($_POST['razao_social']) && (isset($_POST['cnpj']))) {
        if ($_POST['_method'] == "cadastrar") {
            echo $insPessoaJuridica->inserePessoaJuridica($_POST);
        } elseif ($_POST['_method'] == "editar") {
            echo $insPessoaJuridica->editaPessoaJuridica($_POST, $_POST['id']);
        }
    }
} else {
    session_start(['name' => 'cpc']);
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}