<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {

    require_once "../controllers/ProjetoController.php";
    $insProjeto = new ProjetoController();

    if ($_POST['_method'] == "cadastrarProjeto") {
        echo $insProjeto->insereProjeto($_POST);
    } elseif ($_POST['_method'] == "editarProjeto") {
        echo $insProjeto->editaProjeto($_POST, $_POST['projeto_id']);
    }
} else {
    include_once "../config/destroySession.php";
}