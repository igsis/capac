<?php
if ($pedidoAjax) {
    require_once "../models/PedidoModel.php";
    require_once "../controllers/PessoaJuridicaController.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/PedidoModel.php";
    require_once "./controllers/PessoaJuridicaController.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class PedidoController extends PedidoModel
{
    public function inserePedidoJuridica($pagina)
    {
        $idPj= PessoaJuridicaController::inserePessoaJuridica($pagina,true);

        $pedido = PedidoModel::inserePedido(2,$idPj);
        if($pedido){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Jurídica',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.$pagina.'/pj_cadastro&id='.MainModel::encryption($idPj)
            ];
        }
        else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina.'/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function inserePedidoFisica($pagina)
    {
        $idPf = PessoaFisicaController::inserePessoaFisica($pagina, true);
        $pedido = PedidoModel::inserePedido(1,$idPf);
        if($pedido){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.$pagina.'/pf_cadastro&id='.MainModel::encryption($idPf)
            ];
        }
        else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina.'/proponente'
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