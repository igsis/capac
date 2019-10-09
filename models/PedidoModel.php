<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}


class PedidoModel extends MainModel
{
    public function inserePedido($pessoa_tipo,$pessoa_id){
        if (isset($_SESSION['origem_id_c'])){
            $origem_tipo = 1;
            $origem_id = MainModel::decryption($_SESSION['origem_id_c']);
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
            $pedido = DbModel::insert("pedidos",$dados);
            if($pedido->rowCount()>0){
                $_SESSION['pedido_id_c'] = MainModel::encryption(DbModel::connection()->lastInsertId());
                return true;
            } else{
                return false;
            }
        }
        else{
            $idPedido = $consulta->fetch()['id'];
            $pedido = DbModel::update("pedidos",$dados,$idPedido);
            if($pedido->rowCount() >= 1 || DbModel::connection()->errorCode() == 0){
                $_SESSION['pedido_id_c'] = MainModel::encryption($idPedido);
                return true;
            } else{
                return false;
            }
        }
    }

    protected function buscaProponente($pessoa_tipo, $id) {
        if ($pessoa_tipo == 1) {
            $dadosProponente = DbModel::consultaSimples(
                "SELECT id, nome, cpf AS 'documento', email FROM pessoa_fisicas WHERE id = '$id'"
            )->fetchObject();
        } else {
            $dadosProponente = DbModel::consultaSimples(
                "SELECT id, razao_social AS 'nome', cnpj AS 'documento', email FROM pessoa_juridicas WHERE id = '$id'"
            )->fetchObject();
        }

        return $dadosProponente;
    }
}