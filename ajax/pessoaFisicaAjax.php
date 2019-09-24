<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/PessoaFisicaController.php";
    $insPessoaFisica = new PessoaFisicaController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insPessoaFisica->inserePessoaFisica();
    } elseif ($_POST['_method'] == "editar") {
        echo $insPessoaFisica->editaPessoaFisica($_POST['id'], $_POST['pagina']);
    }
} else {
    session_start(['name' => 'cpc']);
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}