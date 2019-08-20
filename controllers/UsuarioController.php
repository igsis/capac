<?php


if ($pedidoAjax) {
    require_once "../models/UsuarioModel.php";
} else {
    require_once "./models/UsuarioModel.php";
}

class UsuarioController extends UsuarioModel
{

    public function iniciaSessao() {
        $email = MainModel::limparString($_POST['email']);
        $senha = MainModel::limparString($_POST['senha']);
        $senha = MainModel::encryption($senha);

        $dadosLogin = [
            'email' => $email,
            'senha' => $senha
        ];

        $consultaUsuario = UsuarioModel::getUsuario($dadosLogin);

        if ($consultaUsuario->rowCount() == 1) {
            $usuario = $consultaUsuario->fetch();

            session_start(['name' => 'cpc']);
            $_SESSION['idUser_c'] = $usuario['id'];
            $_SESSION['nome_c'] = $usuario['nome'];

            MainModel::gravarLog('Fez Login');

            return $urlLocation = '<script> window.location="inicio/inicio" </script>';
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Usuário / Senha incorreto',
                'tipo' => 'error'
            ];

            return MainModel::sweetAlert($alerta);
        }
    }

    public function insereUsuario($dados) {
        $erro = false;
        $dados = [];
        foreach ($_POST as $campo => $post) {
            if (($campo != "senha2") && ($campo != "_method")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }

        // Valida Senha
        if ($_POST['senha'] != $_POST['senha2']) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "As senhas inseridas não conferem. Tente novamente",
                'tipo' => "error"
            ];
        }

        // Valida email unique
        $consultaEmail = DbModel::consultaSimples("SELECT email FROM usuarios WHERE email = '{$dados['email']}'");
        if ($consultaEmail->rowCount() >= 1) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "Email inserido já cadastrado. Tente novamente.",
                'tipo' => "error"
            ];
        }

        if (!$erro) {
            $dados['senha'] = MainModel::encryption($dados['senha']);
            $insere = DbModel::insert('usuarios', $dados);
            if ($insere) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Usuário Cadastrado!',
                    'texto' => 'Usuário cadastrado com Sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL
                ];
            }
        }

        return MainModel::sweetAlert($alerta);
    }

//    if (isset($_POST['edita'])) {
//        $id = $_POST['id'];
//        if (isset($id) && !empty($id)) {
//            $manager->update("usuarios", $data, $id);
//
//            header("Location: ../index.php?usuario_update");
//        }
//    }
//    if (isset($_POST['email'])) {
//        $email = $_POST['email'];
//        $senha = $_POST['senha'];
//
//        $usuario->getUsuario($email);
//
//        if ($usuario != NULL) { // se o usuário é válido
//            // compara as senhas
//            if ($usuario['senha'] == md5($_POST['senha'])) {
//                session_start();
//                $_SESSION['idUserC'] = $usuario['id'];
//                $_SESSION['nome'] = $usuario['nome'];
//                header("Location: inicio");
//            } else {
//                $mensagem = "<span style=\"color: #FF0000; \"><strong>A senha está incorreta!</strong></span>";
//            }
//        } else {
//            $mensagem = "<span style=\"color: #FF0000; \"><strong>O usuário não existe.</strong></span>";
//        }
//        return $mensagem;
//    }
}