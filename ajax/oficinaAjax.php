<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'cpc']);
    require_once "../controllers/OficinaController.php";
    $oficinaObj = new OficinaController();

    switch ($_POST['_method']) {
        case "cadastrarPf":
            echo $oficinaObj->inserePfCadastro($_POST['pagina']);
            break;
        case "editarPf":
            echo $oficinaObj->editaPfCadastro($_POST['id'],$_POST['pagina']);
            break;
        /*
            case "cadastrarOficina":
            echo $oficinaObj->insereOficina($_POST);
            break;
        case "editarOficina";
            echo $oficinaObj->editaOficina($_POST, $_POST['evento_id'], $_POST['atracao_id']);
            break;
        case "apagaOficina":
            echo $oficinaObj->apagaOficina($_POST['id']);
            break;
        case "cadastraComplemento":
            echo $oficinaObj->insereComplementosOficina($_POST);
            break;
        case "editaComplemento":
            echo $oficinaObj->editaComplementosOficina($_POST, $_POST['id']);
            break;
        */
    }
} else {
    include_once "../config/destroySession.php";
}