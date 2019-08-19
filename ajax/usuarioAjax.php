<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_REQUEST['insereUsuario'])) {
    require_once "../controllers/UsuarioController.php";
    $insUsuario = new UsuarioController();

    if (isset($_POST['nome']) && (isset($_POST['senha']))) {
        echo $insAdmin->adicionarAdminController();
    }
} else {
    session_start();
    session_destroy();
    echo '<script> window.location.href="'. SERVERURL .'login/" </script>';
}