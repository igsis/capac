<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/ProdutorController.php";
    $insProdutor = new ProdutorController();

    if (isset($_POST['nome']) && (isset($_POST['email']))) {
        if ($_POST['_method'] == "cadastrar") {
            echo $insProdutor->insereProdutor($_POST);
        } elseif ($_POST['_method'] == "editar") {
            echo $insProdutor->editaProdutor($_POST, $_POST['id']);
        }
    }
} else {
    session_start(['name' => 'cpc']);
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}