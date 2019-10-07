<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/ArquivoController.php";
    $arquivoObj = new ArquivoController();

    if ($_POST['_method'] == "enviarArquivoComProd") {
        echo $arquivoObj->enviarArquivoComProd($_POST['origem_id']);
    } elseif ($_POST['_method'] == "enviarArquivo") {
        echo $arquivoObj->enviarArquivo($_POST['origem_id']);
    } elseif ($_POST['_method'] == "removerArquivo") {
        echo $arquivoObj->apagarArquivo($_POST['arquivo_id'], $_POST['pagina']);
    }
} else {
    session_start(['name' => 'cpc']);
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}