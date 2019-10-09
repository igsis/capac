<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'cpc']);
    require_once "../controllers/PedidoController.php";
    $insPedidoJuridica = new PedidoController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insPedidoJuridica->inserePedidoJuridica($_POST['pagina']);
    } elseif ($_POST['_method'] == "editar") {
        echo $insPedidoJuridica->editaPedidoJuridica($_POST['id'],$_POST['pagina']);
    }
} else {
    include_once "../config/destroySession.php";
}