<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class PedidoController extends MainModel
{
    public function inserePedido($pessoa_tipo,$pessoa_id){
        session_start(['name' => 'cpc']);
        if (isset($_SESSION['evento_id_c'])){
            $origem_tipo = 1;
            $origem_id = MainModel::decryption($_SESSION['evento_id_c']);
        }
        if (isset($_SESSION['formacao_id_c'])){
            $origem_tipo = 2;
            $origem_id = MainModel::decryption($_SESSION['formacao_id_c']);
        }

        $dados = [
            'origem_tipo_id' => $origem_tipo,
            'origem_id' => $origem_id,
            'pessoa_tipo_id' => $pessoa_tipo
        ];

        if ($pessoa_tipo == 1){
            $dados['pessoa_fisica_id'] = $pessoa_id;
        }
        else{
            $dados['pessoa_juridica_id'] = $pessoa_id;
        }

        $consulta = DbModel::consultaSimples("SELECT id FROM pedidos WHERE origem_tipo_id = $origem_tipo AND origem_id = $origem_id AND publicado = 1");
        if ($consulta ->rowCount()<1){
            DbModel::insert("pedidos",$dados);
            $_SESSION['pedido_id_c'] = MainModel::encryption(DbModel::connection()->lastInsertId());
        }
        else{
            $idPedido = $consulta->fetch()['id'];
            DbModel::update("pedidos",$dados,$idPedido);
            $_SESSION['pedido_id_c'] = MainModel::encryption($idPedido);
        }
    }

    public function getPedido($id)
    {
        $id = MainModel::decryption($id);
        return $id;
    }
}