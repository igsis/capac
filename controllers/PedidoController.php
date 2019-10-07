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
        $idPj = PessoaJuridicaController::inserePessoaJuridica($pagina, true);
        $pedido = PedidoModel::inserePedido(2, $idPj);
        if ($pedido) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Jurídica',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pj_cadastro&id=' . MainModel::encryption($idPj)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaPedidoJuridica($idPj, $pagina)
    {
        $pj = PessoaJuridicaController::editaPessoaJuridica($idPj, $pagina, true);
        $pedido = PedidoModel::inserePedido(2, $pj);
        if ($pedido) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Jurídica',
                'texto' => 'Cadastro alterado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pj_cadastro&id=' . $idPj
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function inserePedidoFisica($pagina)
    {
        $idPf = PessoaFisicaController::inserePessoaFisica($pagina, true);
        $pedido = PedidoModel::inserePedido(1, $idPf);
        if ($pedido) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pf_cadastro&id=' . MainModel::encryption($idPf)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaPedidoFisica($idPf, $pagina)
    {
        $pf = PessoaFisicaController::editaPessoaFisica($idPf, $pagina, true);
        $pedido = PedidoModel::inserePedido(2, $pf);
        if ($pedido) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Cadastro alterado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pf_cadastro&id=' . $idPf
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaPedido($origem_tipo)
    {
        $origem_id = MainModel::decryption($_SESSION['evento_id_c']);
        if ($origem_tipo == 2) {
            $pedido = DbModel::consultaSimples("SELECT pj.id, pj.razao_social, pj.cnpj, pj.ccm, pj.email 
                                                    FROM pessoa_juridicas AS pj JOIN pedidos AS p ON pj.id = p.pessoa_juridica_id 
                                                    WHERE origem_tipo_id = $origem_tipo AND origem_id = $origem_id AND publicado = 1")
                ->fetch(PDO::FETCH_OBJ);
        }else {
            $pedido = DbModel::consultaSimples("SELECT pf.nome, pf.cpf, pf.ccm, pf.email 
                                                    FROM pessoa_fisica AS pf JOIN pedidos AS p ON pf.id = p.pessoa_fisica_id 
                                                    WHERE origem_tipo_id = $origem_tipo AND origem_id = $origem_id AND publicado = 1")
                ->fetch(PDO::FETCH_OBJ);
        }

        return $pedido;
    }

    public function getPedido($id)
    {
        $id = MainModel::decryption($id);
        return $id;
    }

    public function startPedido()
    {
        $idEvento = $_SESSION['evento_id_c'];
        $idEvento = MainModel::decryption($idEvento);
        $consulta = DbModel::consultaSimples("SELECT id FROM pedidos WHERE origem_tipo_id = 2 AND origem_id = $idEvento AND publicado = 1")->fetch(PDO::FETCH_ASSOC);
        $resultado = $consulta['id'];
        if ($resultado != null) {
            $_SESSION['pedido_id_c'] = MainModel::encryption($resultado);
        } else {
            return false;
        }
    }
}