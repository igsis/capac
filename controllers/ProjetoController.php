<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class ProjetoController extends MainModel
{
    public function insereProjeto($post){
        session_start(['name' => 'cpc']);
        /* executa limpeza nos campos */
        unset($post['_method']);
        unset($post['modulo']);
        unset($post['pagina']);
        $dados['fom_edital_id'] = MainModel::decryption($_SESSION['edital_c']);
        $dados['pessoa_juridica_id'] = MainModel::decryption($_SESSION['origem_id_c']);
        $dados['fom_status_id'] = 1;
        foreach ($post as $campo => $valor) {
            if ($campo != "modulo") {
                $dados[$campo] = MainModel::limparString($valor);
            }
        }
        /* ./limpeza */

        /* cadastro */
        $insere = DbModel::insert('fom_projetos', $dados);
        if ($insere->rowCount() >= 1) {
            $projeto_id = DbModel::connection()->lastInsertId();
            $_SESSION['projeto_c'] = MainModel::encryption($projeto_id);
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto Cadastrado!',
                'texto' => 'Projeto cadastrado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'fomentos/projeto_cadastro&id=' . MainModel::encryption($projeto_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaProjeto($post, $id){
        $id = MainModel::decryption($id);
        unset($post['_method']);
        unset($post['modulo']);
        unset($post['id']);
        unset($post['pagina']);
        $dados = [];
        foreach ($post as $campo => $valor) {
            if ($campo != "pagina") {
                $dados[$campo] = MainModel::limparString($valor);
            }
        }

        $edita = DbModel::update('fom_projetos', $dados, $id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto Atualizado',
                'texto' => 'Projeto editado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'fomentos/projeto_cadastro&id='.MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'fomentos/projeto_cadastro&id='.MainModel::encryption($id)
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaProjeto($id) {
        $id = MainModel::decryption($id);
        return DbModel::getInfo('fom_projetos',$id)->fetch();
    }

    public function recuperaProjetoCompleto($id) {
        $id = MainModel::decryption($id);
        return DbModel::consultaSimples("SELECT * 
            FROM fom_projetos fp
            INNER JOIN fom_editais fe on fp.fom_edital_id = fe.id
            INNER JOIN fom_status fs on fp.fom_status_id = fs.id
            LEFT JOIN pessoa_juridicas pj on fp.pessoa_juridica_id = pj.id
            LEFT JOIN pessoa_fisicas pf on fp.pessoa_fisica_id = pf.id
            WHERE fp.id = '$id'
        ")->fetch();
    }
}