<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/RepresentanteController.php";
    $insRepresentante = new RepresentanteController();

    if (isset($_POST['nome']) && (isset($_POST['cpf']))) {
        if ($_POST['_method'] == "cadastrar") {
            echo $insRepresentante->insereRepresentante($_POST);
        } elseif ($_POST['_method'] == "editar") {
            echo $insRepresentante->editaRepresentante($_POST, $_POST['id']);
        }
    }
} else {
    session_start(['name' => 'cpc']);
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}