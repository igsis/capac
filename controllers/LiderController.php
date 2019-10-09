<?php
if ($pedidoAjax) {
    require_once "../models/LiderModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/LiderModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class LiderController extends LiderModel
{
    public function insereLider($pagina)
    {
        $idPf = PessoaFisicaController::inserePessoaFisica($pagina, true);
        $idAtracao = $_POST['atracao_id'];
        $insere = LiderModel::insere($idAtracao,$idPf);
        if ($insere){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Líder',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/lider'
            ];
        } else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/lider'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaLider($idPf, $pagina)
    {
        $idPf = MainModel::decryption($idPf);
        $idPedido = $_SESSION['pedido_id_c'];
        PessoaFisicaController::editaPessoaFisica($idPf, $pagina, true);
        $idAtracao = $_POST['atracao_id'];
        $insere = LiderModel::insere($idPedido,$idAtracao,$idPf);
        if ($insere){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Líder',
                'texto' => 'Cadastro atualizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/lider'
            ];
        } else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/lider'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaAtracaoProponente()
    {
        $idEvento = MainModel::decryption($_SESSION['evento_id_c']);
        $atracao = DbModel::consultaSimples("
            SELECT atr.id as atracao_id, atr.evento_id, atr.nome_atracao, pf.nome, lid.pessoa_fisica_id 
            FROM atracoes AS atr
            LEFT JOIN lideres lid on atr.id = lid.atracao_id
            LEFT JOIN pessoa_fisicas AS pf ON lid.pessoa_fisica_id = pf.id
            WHERE atr.publicado = 1 AND atr.evento_id = $idEvento
        ")->fetchAll(PDO::FETCH_OBJ);
        return $atracao;
    }

    public function getLider($idAtracao,$idPf)
    {
        $idPedido = MainModel::decryption($_SESSION['pedido_id_c']);
        $consulta = DbModel::consultaSimples("SELECT id FROM lideres WHERE pedido_id = '$idPedido' AND atracao_id = '$idAtracao' AND pessoa_fisica_id = '$idPf'")->fetch();
        return $consulta;
    }
}