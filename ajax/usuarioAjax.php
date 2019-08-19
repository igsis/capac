<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method']) && ($_POST['_method'] == "insereNovoUsuario")) {
    require_once "../controllers/UsuarioController.php";
    $insUsuario = new UsuarioController();

    if (isset($_POST['nome']) && (isset($_POST['senha']))) {
        echo $insUsuario->insereUsuario($_POST);
    }
} else {
    session_start();
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}