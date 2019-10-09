<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/OficinaController.php";
    $insOficina = new OficinaController();

    if (isset($_POST['modalidade_id']) && (isset($_POST['data_inicio']))) {
        if ($_POST['_method'] == "cadastrar") {
            echo $insOficina->insereOficina($_POST);
        } elseif ($_POST['_method'] == "editar") {
            echo $insOficina->editaOficina($_POST, $_POST['id']);
        }
    }
} else {
    include_once "../config/destroySession.php";
}