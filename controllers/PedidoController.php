<?php
if ($pedidoAjax) {
    require_once "../models/PedidoModel.php";
    require_once "../controllers/PessoaJuridicaController.php";
} else {
    require_once "./models/PedidoModel.php";
    require_once "./controllers/PessoaJuridicaController.php";
}

class PedidoController extends PedidoModel
{
    public function inserePedidoJuridica()
    {
        $idPj= PessoaJuridicaController::inserePessoaJuridica(true);

        $pedido = PedidoModel::inserePedido(2,$idPj);
        if($pedido){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cadastro',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'eventos/pj_cadastro&id='.MainModel::encryption($idPj)
            ];
        }
        else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'eventos/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
        
    }

    public function getPedido($id)
    {
        $id = MainModel::decryption($id);
        return $id;
    }

    public function startPedido()
    {
       $idEvento = MainModel::decryption($_SESSION['evento_id_c']);
       $consulta =  DbModel::consultaSimples("SELECT id FROM pedidos WHERE origem_tipo_id = 2 AND origem_id =$idEvento AND publicado = 1");
       $_SESSION['pedido_id_c'] = MainModel::encryption($consulta);
    }
}