<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class OficinaController extends MainModel
{
    public function insereOficina($dados){
        /* executa limpeza nos campos */
        $dados = [];
        foreach ($_POST as $campo => $post) {
            if (($campo != "cadastrar") && ($campo != "_method")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }
        /* ./limpeza */

        /* cadastro */
        $insere = DbModel::insert('oficinas', $dados);
        if ($insere) {
            $id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Oficina',
                'texto' => 'Oficina cadastrado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'oficina/complemento_oficina_cadastro&id='.MainModel::encryption($id)
            ];

        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaOficina($dados, $id){
        $idDecryp = MainModel::decryption($id);
        unset($dados['editar']);
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $edita = DbModel::update('oficinas', $dados, $idDecryp);
        if ($edita) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Oficina',
                'texto' => 'Informação editada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'oficina/complemento_oficina_cadastro&id='.$id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'oficina/complemento_oficina_cadastro&id='.$id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaOficina($id) {
        $id = MainModel::decryption($id);
        $produtor = DbModel::getInfo('oficinas',$id);
        return $produtor;
    }
}