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
    public function recuperaEventoOficina($idEvento)
    {
        $idEvento = MainModel::decryption($idEvento);
        return DbModel::consultaSimples("
            SELECT e.id, e.protocolo, e.nome_evento, e.sinopse, e.data_cadastro, e.data_envio, m.modalidade, ofn.nivel, os.sublinguagem, oc.ofic_linguagem_id, oc.ofic_sublinguagem_id, oc.execucao_dia1_id, oc.execucao_dia2_id, oc.data_inicio, oc.data_fim, oc.id as idOficina 
            FROM eventos e
                LEFT JOIN ofic_cadastros oc on e.id = oc.evento_id
                LEFT JOIN modalidades m on oc.modalidade_id = m.id
                LEFT JOIN ofic_niveis ofn on oc.ofic_nivel_id = ofn.id
                LEFT JOIN ofic_linguagens ol on oc.ofic_linguagem_id = ol.id
                LEFT JOIN ofic_sublinguagens os on ol.id = os.oficina_linguagem_id
            WHERE e.id = '$idEvento'
        ")->fetchObject();
    }

    public function listaOficina(): array
    {
        return DbModel::consultaSimples("SELECT e.id, e.protocolo, e.nome_evento, e.data_cadastro, e.data_envio FROM eventos e WHERE e.usuario_id = {$_SESSION['usuario_id_c']} AND e.publicado = 1 AND tipo_contratacao_id = 5 ORDER BY e.data_cadastro DESC")->fetchAll(PDO::FETCH_OBJ);
    }

    public function insereEvento($post): string
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

    public function editaEvento($post,$evento_id): string
    {
        $eventoObj = new EventoController();
        $idEveDecr = MainModel::decryption($evento_id);
        $evento = $eventoObj->editaEvento($post,$idEveDecr,true);
        if ($evento){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Evento',
                'texto' => 'Dados editados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'oficina/evento_cadastro&key=' . $evento_id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
                'location' => SERVERURL . 'oficina/evento_cadastro&key=' . $evento_id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function exibeDescricaoPublico() {
        return (new EventoController)->exibeDescricaoPublico();
    }

    public function insereOficina($post): string
    {
        /* executa limpeza nos campos */
        $dadosOficina = [];
        unset($post['_method']);
        foreach ($post as $campo => $valor) {
            $dadosOficina[$campo] = MainModel::limparString($valor);
            unset($post[$campo]);
        }
        $dadosOficina['evento_id'] = MainModel::decryption($_SESSION['origem_id_c']);
        /* /.limpeza */

        /* cadastro */
        $insere = DbModel::insert('ofic_cadastros', $dadosOficina);
        if ($insere->rowCount() >= 1) {
            $oficina_id = DbModel::connection()->lastInsertId();
            $_SESSION['oficina_id_c'] = MainModel::encryption($oficina_id);
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Oficina',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'oficina/oficina_cadastro&id=' . MainModel::encryption($oficina_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        /* /.cadastro */
        return MainModel::sweetAlert($alerta);
    }

    public function editaOficina($post,$id): string
    {
        /* executa limpeza nos campos */
        $dadosOficina = [];
        unset($post['_method']);
        unset($post['id']);
        foreach ($post as $campo => $valor) {
            $dadosOficina[$campo] = MainModel::limparString($valor);
            unset($post[$campo]);
        }
        /* /.limpeza */

        // edição
        $idDecr = MainModel::decryption($id);
        $edita = DbModel::update("ofic_cadastros",$dadosOficina,$idDecr);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Oficina',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'oficina/oficina_cadastro&id=' . MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        /* /.cadastro */
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaOficina($idOficina)
    {
        $idOficina = MainModel::decryption($idOficina);
        return $this->consultaSimples("
            SELECT oc.*, ofn.nivel, ol.linguagem, os.sublinguagem FROM ofic_cadastros oc 
            LEFT JOIN modalidades m on oc.modalidade_id = m.id
                LEFT JOIN ofic_niveis ofn on oc.ofic_nivel_id = ofn.id
                LEFT JOIN ofic_linguagens ol on oc.ofic_linguagem_id = ol.id
                LEFT JOIN ofic_sublinguagens os on ol.id = os.oficina_linguagem_id
            WHERE oc.id = '$idOficina' AND publicado = 1
            ")->fetchObject();
    }

    /*
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