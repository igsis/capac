<?php
if ($pedidoAjax) {
    require_once "../models/AtracaoModel.php";
} else {
    require_once "./models/AtracaoModel.php";
}

class AtracaoController extends AtracaoModel
{
    public function listaEvento($usuario_id){
        $consultaEvento = DbModel::consultaSimples("SELECT * FROM eventos AS e INNER JOIN tipos_contratacoes tc on e.tipo_contratacao_id = tc.id WHERE e.publicado != 0 AND usuario_id = '$usuario_id'");
        $eventos = $consultaEvento->fetchAll(PDO::FETCH_OBJ);
        return $eventos;
    }

    public function recuperaAtracao($id) {
        $id = MainModel::decryption($id);
        $atracao = AtracaoModel::getAtracao($id);
        return $atracao;
    }

    public function insereAtracao($post){
        /* executa limpeza nos campos */
        session_start(['name' => 'cpc']);
        $dadosAtracao = [];
        unset($post['_method']);
        foreach ($post as $campo => $valor) {
            if ($campo != "acoes") {
                $dadosAtracao[$campo] = MainModel::limparString($valor);
                unset($post[$campo]);
            }
        }
        $dadosAtracao['evento_id'] = MainModel::decryption($_SESSION['idEvento_c']);
        /* /.limpeza */

        /* cadastro */
        $insere = DbModel::insert('atracoes', $dadosAtracao);
        if ($insere->rowCount() >= 1) {
            $atracao_id = DbModel::connection()->lastInsertId();
            $atualizaRelacionamentoAcoes = MainModel::atualizaRelacionamento('acao_atracao', 'atracao_id', $atracao_id, 'acao_id', $post['acoes']);

            if ($atualizaRelacionamentoAcoes) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Atração Cadastrada!',
                    'texto' => 'Dados cadastrados com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . 'eventos/atracao_cadastro&key=' . MainModel::encryption($atracao_id)
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
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        /* /.cadastro */
        return MainModel::sweetAlert($alerta);
    }

    public function editaAtracao($post,$evento_id){
        /* executa limpeza nos campos */
        session_start(['name' => 'cpc']);
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

    public function apagaAtracao($id){
//        $apaga = DbModel::delete("eventos", $id);
//        if ($apaga) {
//            $alerta = [
//                'alerta' => 'sucesso',
//                'titulo' => 'Oficina',
//                'texto' => 'Oficina apagada com sucesso!',
//                'tipo' => 'danger',
//                'location' => SERVERURL
//            ];
//        }
    }

    public function exibeDescricaoAcao() {
        $acoes = DbModel::consultaSimples("SELECT acao, descricao FROM acoes WHERE publicado = '1' ORDER BY 1");
        foreach ($acoes->fetchAll() as $acao) {
            ?>
            <tr>
                <td><?= $acao['acao'] ?></td>
                <td><?= $acao['descricao'] ?></td>
            </tr>
            <?php
        }
    }

}