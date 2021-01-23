<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'cpc']);
    require_once "../controllers/OficinaController.php";
    require_once "../controllers/PedidoController.php";
    $oficinaObj = new OficinaController();
    $pedidoObj = new PedidoController();

    switch ($_POST['_method']) {
        case "cadastrarEvento":
            echo $oficinaObj->insereEvento($_POST);
            break;
        case "editarEvento":
            echo $oficinaObj->editaEvento($_POST,$_POST['id']);
            break;
        case "cadastrarOficina":
            echo $oficinaObj->insereOficina($_POST);
            break;
        case "editarOficina":
            echo $oficinaObj->editaOficina($_POST,$_POST['id']);
            break;
        case "cadastrarPf":
            echo $pedidoObj->inserePedidoFisica("oficina",1);
            break;
        case "editarPf":
            echo $pedidoObj->editaPedidoFisica($_POST['id'],"oficina",1);
            break;
        case "cadastrarPj":
            echo $pedidoObj->inserePedidoJuridica("oficina",1);
            break;
        case "editarPj":
            echo $pedidoObj->editaPedidoJuridica($_POST['id'],"oficina",1);
            break;

        /*
    case "cadastrarPf":
        echo $oficinaObj->inserePfCadastro($_POST['pagina']);
        break;
    case "editarPf":
        echo $oficinaObj->editaPfCadastro($_POST['id'],$_POST['pagina']);
        break;

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