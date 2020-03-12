<?php
//CONFIGS
require_once "./config/configAPP.php";

//CONTROLLERS
require_once "./controllers/ProjetoController.php";
require_once "./controllers/FomentoController.php";
require_once "./controllers/UsuarioController.php";

$projetoObj = new ProjetoController();
$fomentoObj = new FomentoController();

$pessoa_tipos_id = $fomentoObj->recuperaEdital($_SESSION['edital_c'])->pessoa_tipos_id;

if ($pessoa_tipos_id == 2) {
    include_once "./views/modulos/fomentos/include/finalizar_pj.php";
} else {
    include_once "./views/modulos/fomentos/include/finalizar_pf.php";
}