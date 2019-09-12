<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/ProdutorController.php";
    $insProdutor = new ProdutorController();

    if ($_POST['_method'] == "cadastrarProdutor") {
        echo $insProdutor->insereProdutor($_POST, $_POST['tabela_referencia'], $_POST['atracao_referencia_id']);
    } elseif ($_POST['_method'] == "editarProdutor") {
        echo $insProdutor->editaProdutor($_POST, $_POST['produtor_id']);
    }
} else {
    session_start(['name' => 'cpc']);
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}