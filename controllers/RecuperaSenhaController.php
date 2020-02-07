<?php

if ($pedidoAjax) {
    require_once "../models/RecuperaSenhaModel.php";
    require_once "../controllers/RecuperaSenhaController.php";
    require_once "../controllers/UsuarioController.php";
} else {
    require_once "../models/RecuperaSenhaModel.php";
    require_once "../controllers/RecuperaSenhaController.php";
    require_once "../controllers/UsuarioController.php";
}


class RecuperaSenhaController extends RecuperaSenhaModel
{
    public function verificaEmail($email){
        $usuario =  new UsuarioController();
        $emailBD = $usuario->recuperaEmail($email);

        if ($emailBD->rowCount() == 1){



            $alert = [
                'alerta' => 'sucesso',
                'titulo' => 'Usuário',
                'texto' => "Achou email",
                'tipo' => 'success',
                'location' => SERVERURL.'recupera_senha'
            ];
        }else{
            $alert = [
                'alerta' => 'simples',
                'titulo' => 'Não tem email',
                'texto' => "Não tem email",
                'tipo' => 'error',
                'location' => SERVERURL.'recupera_senha'
            ];
        }

        return MainModel::sweetAlert($alert);
    }
}