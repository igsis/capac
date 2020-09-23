<?php
require_once "../config/configGeral.php";
require_once "../config/configAPP.php";
$pedidoAjax = true;
require_once "../models/MainModel.php";
$db = new MainModel();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');



if(isset($_GET['cargo_id'])){
    $id = $_GET['cargo_id'];

    $sql = "SELECT cp.form_cargo_id AS 'id', fc.cargo AS 'cargo' FROM cargo_programa AS cp
            INNER JOIN form_cargos AS fc ON cp.form_cargo_id = fc.id
            WHERE cp.form_programa_id = '$id' ORDER BY fc.cargo";
    $res = $db->consultaSimples($sql)->fetchAll();

    $cargos =  json_encode($res);

    print_r($cargos);

} elseif (isset($_GET['cargo1_id'])){
    $id = $_GET['cargo1_id'];

    $sql = "SELECT DISTINCT cp.form_cargo_id AS 'id', fc.cargo AS 'cargo' FROM cargo_programa AS cp
            INNER JOIN form_cargos AS fc ON cp.form_cargo_id = fc.id
            WHERE cp.form_cargo_id IN (1, 2, 3) ORDER BY fc.cargo";
    $res = $db->consultaSimples($sql)->fetchAll();

    $cargos =  json_encode($res);

    print_r($cargos);

}