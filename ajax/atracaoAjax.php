<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/AtracaoController.php";
    $atracaoObj = new AtracaoController();

    if ($_POST['_method'] == "cadastrarAtracao") {
        echo $atracaoObj->insereAtracao($_POST);
    } elseif ($_POST['_method'] == "editarAtracao") {
        echo $atracaoObj->editaAtracao($_POST, $_POST['id']);
    }
} else {
    include_once "../config/destroySession.php";
}