<?php
if ($pedidoAjax) {
    require_once "../models/OficinaModel.php";
    require_once "../controllers/EventoController.php";
} else {
    require_once "./models/OficinaModel.php";
    require_once "./controllers/EventoController.php";
}

class OficinaController extends OficinaModel
{
    public function recuperaOficina($id) {
        $id = MainModel::decryption($id);
        $oficina = OficinaModel::getOficina($id);
        return $oficina;
    }

    public function insereOficina($dados){
        $dadosOficina = OficinaModel::limparStringOficina($dados);
        $evento_id = $dadosOficina['at']['evento_id'] = (new EventoController)->insereEvento($dadosOficina['ev'], true);
        $atracaoOficina = DbModel::insert('atracoes', $dadosOficina['at']);

        if ($atracaoOficina->rowCount() > 0) {
            $_SESSION['origem_id_c'] = $evento_id;
            $_SESSION['atracao_id_c'] = $atracao_id = DbModel::connection()->lastInsertId();

            $acaoAtracao = [
                'acao_id' => 8,
                'atracao_id' => $atracao_id
            ];
            DbModel::insert('acao_atracao', $acaoAtracao);

            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Oficina Cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'oficina/evento_cadastro&key=' . MainModel::encryption($evento_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaOficina($dados, $evento_id, $atracao_id){
        unset($dados['evento_id']);
        unset($dados['atracao_id']);
        $evento_id = MainModel::decryption($evento_id);
        $atracao_id = MainModel::decryption($atracao_id);

        $dadosOficina = OficinaModel::limparStringOficina($dados);

        $editaEvento = (new EventoController)->editaEvento($dadosOficina['ev'], $evento_id);

        if (DbModel::connection()->errorCode() == 0) {
            $editaAtracao = DbModel::update('atracoes', $dadosOficina['at'], $atracao_id);
            if (DbModel::connection()->errorCode() == 0) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Oficina Atualizada!',
                    'texto' => 'Dados atualizados com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . 'oficina/evento_cadastro&key=' . MainModel::encryption($evento_id)
                ];
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL . 'oficina/evento_cadastro&key=' . MainModel::encryption($evento_id)
                ];
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'oficina/evento_cadastro&key=' . MainModel::encryption($evento_id)
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function apagaOficina($id){
        $apaga = DbModel::apaga("eventos", $id);
        if ($apaga){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Oficina',
                'texto' => 'Oficina apagado com sucesso!',
                'tipo' => 'danger',
                'location' => SERVERURL.'oficina/evento_lista'
            ];
        }else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function exibeDescricaoPublico()
    {
        return (new EventoController)->exibeDescricaoPublico();
    }
}