<?php
require_once "../config/configGeral.php";
require_once "../config/configAPP.php";
$pedidoAjax = true;
require_once "../models/MainModel.php";
$db = new MainModel();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');



if(isset($_GET['busca'])){
    $articuladores = [3, 6, 7];

    if ($_GET['busca'] == 1) {
        $programa_id = $_GET['programa_id'];
        $sql = "SELECT cp.form_cargo_id AS 'id', fc.cargo AS 'cargo' FROM capac_new.cargo_programa AS cp
                INNER JOIN siscontrat.formacao_cargos AS fc ON cp.form_cargo_id = fc.id
                WHERE cp.form_programa_id = '$programa_id' ORDER BY fc.cargo";
        $res = $db->consultaSimples($sql)->fetchAll();
        $cargos = json_encode($res);
        print_r($cargos);
    }
    elseif ($_GET['busca'] == 2) {
        $programa_id = $_GET['programa_id'];
        $cargo1_id = $_GET['cargo1_id'];
        $cargo1 = in_array($cargo1_id, $articuladores) ? implode(", ", $articuladores) : $cargo1_id;

        $sql = "SELECT DISTINCT cp.form_cargo_id AS 'id', fc.cargo AS 'cargo' FROM capac_new.cargo_programa AS cp
                INNER JOIN siscontrat.formacao_cargos AS fc ON cp.form_cargo_id = fc.id
                WHERE cp.form_programa_id = '$programa_id' AND cp.form_cargo_id NOT IN ($cargo1, 4, 5) ORDER BY fc.cargo";
        $res = $db->consultaSimples($sql)->fetchAll();

        $cargos = json_encode($res);

        print_r($cargos);
    }elseif ($_GET['busca'] == 3) {
        $programa_id = $_GET['programa_id'];
        $cargo1 = $_GET['cargo1_id'];
        $cargo2 = $_GET['cargo2_id'];

        if (in_array($cargo1, $articuladores)) {
            $cargo1 = implode(", ", $articuladores);
        } elseif (in_array($cargo2, $articuladores)) {
            $cargo2 = implode(", ", $articuladores);
        }

        $sql = "SELECT DISTINCT cp.form_cargo_id AS 'id', fc.cargo AS 'cargo' FROM capac_new.cargo_programa AS cp
                INNER JOIN siscontrat.formacao_cargos AS fc ON cp.form_cargo_id = fc.id
                WHERE cp.form_programa_id = '$programa_id' AND cp.form_cargo_id NOT IN ($cargo1, $cargo2, 4, 5) ORDER BY fc.cargo";
        $res = $db->consultaSimples($sql)->fetchAll();

        $cargos = json_encode($res);

        print_r($cargos);
    }
}