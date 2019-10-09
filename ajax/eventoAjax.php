<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/EventoController.php";
    $insEvento = new EventoController();

    if ($_POST['_method'] == "cadastrarEvento") {
        echo $insEvento->insereEvento($_POST);
    } elseif ($_POST['_method'] == "editarEvento") {
        echo $insEvento->editaEvento($_POST, $_POST['id']);
    }
} else {
    include_once "../config/destroySession.php";
}