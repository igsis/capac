<?php

include_once '../models/ConnectionModel.php';
include_once '../models/DbModel.php';

$manager = new DbModel();
$usuario  = new UsuarioModel();

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

if(isset($_POST['email']))
{
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuario->getUsuario($email);

    if($usuario != NULL){ // se o usuário é válido
        // compara as senhas
        if($usuario['senha'] == md5($_POST['senha'])){
            session_start();
            $_SESSION['idUserC'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            header("Location: inicio");
        }
        else{
            $mensagem = "<span style=\"color: #FF0000; \"><strong>A senha está incorreta!</strong></span>";
        }
    }
    else{
        $mensagem = "<span style=\"color: #FF0000; \"><strong>O usuário não existe.</strong></span>";
    }
    return $mensagem;
}