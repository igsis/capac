<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/PedidoController.php";
    $insPedidoFisica = new PedidoController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insPedidoFisica->inserePedidoFisica($_POST['pagina']);
    }
} else {
    session_start(['name' => 'cpc']);
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}