<?php

include_once '../models/DbModel.php';

$manager = new DbModel();

$data = $_POST;

if(isset($_POST['cadastra'])){
    if(isset($data) && !empty($data)) {
        $manager->insert("eventos", $data);

        header("Location: ../index.php?evento_add");
    }
}

if(isset($_POST['edita'])){
    $id = $_POST['id'];
    if(isset($id) && !empty($id)) {
        $manager->update("eventos", $data, $id);

        header("Location: ../index.php?evento_update");
    }
}

if(isset($_POST['apaga'])){
    $id = $_POST['id'];
    if(isset($id) && !empty($id)) {
        $manager->update("eventos", $data, $id);

        header("Location: ../index.php?evento_delete");
    }
}