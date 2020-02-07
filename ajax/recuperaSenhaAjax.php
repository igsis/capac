<?php

$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])){
    require_once "../controllers/RecuperaSenhaController.php";
    $recupera =  new RecuperaSenhaController();

    switch ($_POST['_method']){
        case 'check':
            echo $recupera->verificaEmail($_POST['email']);
            break;
        default:
            $message = 'Não foi nada';
            break;
    }

} else {
    include_once "../config/destroySession.php";
}