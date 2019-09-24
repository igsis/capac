<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/PessoaJuridicaController.php";
    $insPessoaJuridica = new PessoaJuridicaController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insPessoaJuridica->inserePessoaJuridica();
    } elseif ($_POST['_method'] == "editar") {
        echo $insPessoaJuridica->editaPessoaJuridica($_POST['id'], $_POST['pagina']);
    }
} else {
    session_start(['name' => 'cpc']);
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}