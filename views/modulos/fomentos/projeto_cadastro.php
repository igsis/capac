<?php
if (isset($_GET['id'])) {
    $_SESSION['projeto_c'] = $id = $_GET['id'];
} elseif (isset($_SESSION['projeto_c'])) {
    $id = $_SESSION['projeto_c'];
} else {
    $id = null;
}

require_once "./controllers/ProjetoController.php";
require_once "./controllers/FomentoController.php";

$objProjeto = new ProjetoController();
$objFomento = new FomentoController();

if ($id) {
    $projeto = $objProjeto->recuperaProjeto($id);
}

$pessoa_tipos_id = $objFomento->recuperaEdital($_SESSION['edital_c'])->pessoa_tipos_id;

if ($pessoa_tipos_id == 2) {
    include_once "./views/modulos/fomentos/include/projeto_cadastro_pj.php";
} else {
    include_once "./views/modulos/fomentos/include/projeto_cadastro_pf.php";
}