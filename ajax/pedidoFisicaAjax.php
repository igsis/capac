<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/PedidoController.php";
    $insPedidoFisica = new PedidoController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insPedidoFisica->inserePedidoFisica($_POST['pagina']);
    }elseif ($_POST['_method'] == "editar") {
        echo $insPedidoFisica->editaPedidoFisica($_POST['id'],$_POST['pagina']);
    }
} else {
    include_once "../config/destroySession.php";
}