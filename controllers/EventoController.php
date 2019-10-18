<?php
if ($pedidoAjax) {
    require_once "../models/EventoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
    require_once "../controllers/PessoaJuridicaController.php";
} else {
    require_once "./models/EventoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
    require_once "./controllers/PessoaJuridicaController.php";
}

class EventoController extends EventoModel
{
    public function listaEvento($usuario_id){
        $consultaEvento = DbModel::consultaSimples("
            SELECT e.id, e.nome_evento, e.data_cadastro, tc.tipo_contratacao, e.publicado
            FROM eventos AS e 
                INNER JOIN tipos_contratacoes tc on e.tipo_contratacao_id = tc.id 
            WHERE e.publicado != 0 AND usuario_id = '$usuario_id'");
        $eventos = $consultaEvento->fetchAll(PDO::FETCH_OBJ);
        return $eventos;
    }

    public function recuperaEvento($id) {
        $id = MainModel::decryption($id);
        $evento = EventoModel::getEvento($id);
        return $evento;
    }

    public function insereEvento($post){
        /* executa limpeza nos campos */
        $dadosEvento = [];
        unset($post['_method']);
        foreach ($post as $campo => $valor) {
            if (($campo != "publicos") && ($campo != "fomento_id")) {
                $dadosEvento[$campo] = MainModel::limparString($valor);
                unset($post[$campo]);
            }
        }
        $dadosEvento['usuario_id'] = $_SESSION['usuario_id_c'];
        $dadosEvento['data_cadastro'] = date('Y-m-d H:i:s');
        /* /.limpeza */

        /* cadastro */
        $insere = DbModel::insert('eventos', $dadosEvento);
        if ($insere->rowCount() >= 1) {
            $evento_id = DbModel::connection()->lastInsertId();
            $_SESSION['origem_id_c'] = MainModel::encryption($evento_id);
            $atualizaRelacionamentoPublicos = MainModel::atualizaRelacionamento('evento_publico', 'evento_id', $evento_id, 'publico_id', $post['publicos']);

            if ($atualizaRelacionamentoPublicos) {
                if ($dadosEvento['fomento'] == 1) {
                    $atualizaRelacionamentoFomento = MainModel::atualizaRelacionamento('evento_fomento', 'evento_id', $evento_id, 'fomento_id', $post['fomento_id']);
                    if ($atualizaRelacionamentoFomento) {
                        $alerta = [
                            'alerta' => 'sucesso',
                            'titulo' => 'Evento Cadastrado!',
                            'texto' => 'Dados cadastrados com sucesso!',
                            'tipo' => 'success',
                            'location' => SERVERURL . 'eventos/evento_cadastro&key=' . MainModel::encryption($evento_id)
                        ];
                    } else {
                        $alerta = [
                            'alerta' => 'simples',
                            'titulo' => 'Oops! Algo deu Errado!',
                            'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                            'tipo' => 'error',
                        ];
                    }
                } else {
                    $alerta = [
                        'alerta' => 'sucesso',
                        'titulo' => 'Evento Cadastrado!',
                        'texto' => 'Dados cadastrados com sucesso!',
                        'tipo' => 'success',
                        'location' => SERVERURL . 'eventos/evento_cadastro&key=' . MainModel::encryption($evento_id)
                    ];
                }
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Oops! Algo deu Errado!',
                    'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                    'tipo' => 'error',
                ];
            }
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

    public function editaEvento($post,$evento_id){
        /* executa limpeza nos campos */
        $dadosEvento = [];
        unset($post['_method']);
        unset($post['id']);
        foreach ($post as $campo => $valor) {
            if (($campo != "publicos") && ($campo != "fomento_id")) {
                $dadosEvento[$campo] = MainModel::limparString($valor);
                unset($post[$campo]);
            }
        }
        /* /.limpeza */

        // edição
        $edita = DbModel::update("eventos",$dadosEvento,$evento_id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $atualizaRelacionamentoPublicos = MainModel::atualizaRelacionamento('evento_publico', 'evento_id', $evento_id, 'publico_id', $post['publicos']);
            if ($atualizaRelacionamentoPublicos) {
                if ($dadosEvento['fomento'] == 1) {
                    $atualizaRelacionamentoFomento = MainModel::atualizaRelacionamento('evento_fomento', 'evento_id', $evento_id, 'fomento_id', $post['fomento_id']);
                    if ($atualizaRelacionamentoFomento) {
                        $alerta = [
                            'alerta' => 'sucesso',
                            'titulo' => 'Evento Atualizado!',
                            'texto' => 'Dados atualizados com sucesso!',
                            'tipo' => 'success',
                            'location' => SERVERURL . 'eventos/evento_cadastro&key=' . MainModel::encryption($evento_id)
                        ];
                    } else {
                        $alerta = [
                            'alerta' => 'simples',
                            'titulo' => 'Oops! Algo deu Errado!',
                            'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                            'tipo' => 'error',
                        ];
                    }
                } else {
                    DbModel::consultaSimples("DELETE FROM evento_fomento WHERE evento_id = '$evento_id'");
                    $alerta = [
                        'alerta' => 'sucesso',
                        'titulo' => 'Evento Atualizado!',
                        'texto' => 'Dados atualizados com sucesso!',
                        'tipo' => 'success',
                        'location' => SERVERURL . 'eventos/evento_cadastro&key=' . MainModel::encryption($evento_id)
                    ];
                }
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Oops! Algo deu Errado!',
                    'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                    'tipo' => 'error',
                ];
            }

        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        /* /.edicao */
        return MainModel::sweetAlert($alerta);
    }

    public function apagaEvento($id){
        $apaga = DbModel::apaga("eventos", $id);
        if ($apaga){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Evento',
                'texto' => 'Evento apagado com sucesso!',
                'tipo' => 'danger',
                'location' => SERVERURL.'eventos/evento_lista'
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

    public function exibeDescricaoPublico() {
        $publicos = DbModel::consultaSimples("SELECT publico, descricao FROM publicos WHERE publicado = '1' ORDER BY 1");
        foreach ($publicos->fetchAll() as $publico) {
            ?>
            <tr>
                <td><?= $publico['publico'] ?></td>
                <td><?= $publico['descricao'] ?></td>
            </tr>
            <?php
        }
    }

    public function validaEvento($evento_id) {
        $evento_id = MainModel::decryption($evento_id);
        $erros['Evento'] = EventoModel::validaEventoModel($evento_id);

        $pedido = DbModel::consultaSimples("SELECT * FROM pedidos WHERE origem_id = '$evento_id' AND origem_tipo_id = '1'");
        if ($pedido->rowCount() > 0) {
                $pedido = $pedido->fetchObject();
            if ($pedido->pessoa_tipo_id == 1) {
                $erros['Proponente'] = (new PessoaFisicaController)->validaPf($pedido->pessoa_fisica_id, 1);
            } else {
                $erros['Proponente'] = (new PessoaJuridicaController)->validaPj($pedido->pessoa_juridica_id);
            }
        }

        $erro = MainModel::in_array_r(true, $erros, true);
        if ($erro) {
            foreach ($erros as $key => $erro) {
                if ($erro != false) {
                    foreach ($erro as $item) {
                        if ($item['bol']) {
                            $validacao[$key][] = $item['motivo'];
                        }
                    }
                }
            }
            return $validacao;
        } else {
            return false;
        }
    }

    public function listaPublicoEvento($id)
    {
        $publico = DbModel::getInfo("publicos",$id)->fetch();
        return $publico;
    }

    public function envioEvento($id)
    {
        $id = MainModel::decryption($id);
        $dados = [
            'publicado' => 2,
            'data_cadastro' => date('Y-m-d H-i-s')
        ];
        $edita = DbModel::update("eventos",$dados,$id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Evento enviado com sucesso!',
                'texto' => 'Seu código do CAPAC é: '. $id,
                'tipo' => 'success',
                'location' => SERVERURL . 'eventos/evento_lista'
            ];
        }
        else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function descriptografia($id)
    {
        $id = MainModel::decryption($id);
        return $id;
    }
}