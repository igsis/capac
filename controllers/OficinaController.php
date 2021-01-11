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
    public function recuperaOficina($idEvento)
    {
        $idEvento = MainModel::decryption($idEvento);
        return DbModel::consultaSimples("
            SELECT * FROM eventos e
            WHERE e.id = '$idEvento'
        ")->fetchObject();
    }

    public function listaOficina(): array
    {
        return DbModel::consultaSimples("SELECT e.id, e.protocolo, e.nome_evento, e.data_cadastro FROM eventos e WHERE e.usuario_id = {$_SESSION['usuario_id_c']} AND e.publicado = 1 AND tipo_contratacao_id = 5 ORDER BY e.data_cadastro DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastraEvento($post)
    {
        $eventoObj = new EventoController();
        $evento_id = $eventoObj->insereEvento($post, true);
        if ($evento_id){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Evento Cadastrado!',
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

    public function editaEvento($post,$evento_id)
    {
        $eventoObj = new EventoController();
        $evento_id = $eventoObj->editaEvento($post,$evento_id,true);
        if ($evento_id){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Evento',
                'texto' => 'Dados editados com sucesso!',
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

    public function inserePfCadastro($pagina)
    {
        $idPf = (new PessoaFisicaController)->inserePessoaFisica($pagina, true);
        if ($idPf) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '&idPf=' . MainModel::encryption($idPf)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaPfCadastro($id,$pagina)
    {
        $idPf = (new PessoaFisicaController)->editaPessoaFisica($id,$pagina,true);
        if ($idPf) {
            $_SESSION['pf_id_c'] = $id;
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Pessoa Física editada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.$pagina.'&idPf='.$id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/pf_cadastro&idPf='.$id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function insereOficina()
    {
        //1º insere o evento
        //2º recupera a pessoa física e insere o produtor
        //3º insere a atração
        //4º insere o pedido
    }

    public function exibeDescricaoPublico() {
        return (new EventoController)->exibeDescricaoPublico();
    }
/*
    public function recuperaComplementosOficina($atracao_id)
    {
        $atracao_id = MainModel::decryption($atracao_id);
        $complemento = DbModel::consultaSimples("SELECT * FROM oficinas WHERE atracao_id = '$atracao_id'")->fetchObject();
        return $complemento;
    }

    public function insereOficina($dados){
        $dadosOficina = OficinaModel::limparStringOficina($dados);
        $dadosOficina['at']['oficina'] = 1;
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

    public function editaOficina($dados, $evento_id, $atracao_id){
        unset($dados['evento_id']);
        unset($dados['atracao_id']);
        $evento_id = MainModel::decryption($evento_id);
        $atracao_id = MainModel::decryption($atracao_id);

        $dadosOficina = OficinaModel::limparStringOficina($dados);
        $dadosOficina['at']['oficina'] = 1;

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

    public function insereComplementosOficina($dados) {
        unset($dados['_method']);

        foreach ($dados as $campo => $valor) {
            if ($campo != "dataInicioFim") {
                $dadosComplemento[$campo] = MainModel::limparString($valor);
                unset($dados[$campo]);
            }
        }

        $datas = explode(" - ", $dados['dataInicioFim']);
        $dadosComplemento['data_inicio'] = MainModel::dataParaSQL($datas[0]);
        $dadosComplemento['data_fim'] = MainModel::dataParaSQL($datas[1]);

        $dadosComplemento['atracao_id'] = MainModel::decryption($_SESSION['atracao_id_c']);

        $complemento = DbModel::insert('oficinas', $dadosComplemento);
        if ($complemento->rowCount() > 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Dados Complementares Cadastrados!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'oficina/complemento_oficina_cadastro'
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

    public function editaComplementosOficina($dados, $id) {
        $id = MainModel::decryption($id);
        unset($dados['_method']);
        unset($dados['id']);

        foreach ($dados as $campo => $valor) {
            if ($campo != "dataInicioFim") {
                $dadosComplemento[$campo] = MainModel::limparString($valor);
                unset($dados[$campo]);
            }
        }

        $datas = explode(" - ", $dados['dataInicioFim']);
        $dadosComplemento['data_inicio'] = MainModel::dataParaSQL($datas[0]);
        $dadosComplemento['data_fim'] = MainModel::dataParaSQL($datas[1]);

        $editaComplemento = DbModel::update('oficinas', $dadosComplemento, $id);
        if (DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Dados Complementares Atualizados!',
                'texto' => 'Dados atualizados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'oficina/complemento_oficina_cadastro'
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
*/

}