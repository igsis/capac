<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/PedidoController.php";
    $insPedidoJuridica = new PedidoController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insPedidoJuridica->inserePedidoJuridica($_POST['pagina']);
    } elseif ($_POST['_method'] == "editar") {
        echo $insPedidoJuridica->editaPedidoJuridica($id,$_POST['pagina']);
    }
} else {
    session_start(['name' => 'cpc']);
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}