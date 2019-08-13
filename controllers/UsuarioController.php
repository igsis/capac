<?php

include_once '../models/ConnectionModel.php';
include_once '../models/ManagerModel.php';

$manager = new ManagerModel();

$data = $_POST;

if(isset($_POST['cadastra'])){
    if(isset($data) && !empty($data)) {
        $manager->insert("usuarios", $data);

        header("Location: ../index.php?usuario_add");
    }
}

if(isset($_POST['edita'])){
    $id = $_POST['id'];
    if(isset($id) && !empty($id)) {
        $manager->update("usuarios", $data, $id);

        header("Location: ../index.php?usuario_update");
    }
}