<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/LiderController.php";
    $insLider = new LiderController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insLider->insereLider($_POST['pagina']);
    }elseif ($_POST['_method'] == "editar") {
        echo $insLider->editaLider($_POST['id'],$_POST['pagina']);
    }
} else {
    session_start(['name' => 'cpc']);
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}