<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class RepresentanteController extends MainModel
{
    public function insereRepresentante($dados){
        /* executa limpeza nos campos */
        $dados = [];
        foreach ($_POST as $campo => $post) {
            if (($campo != "cadastrar") && ($campo != "_method")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }
        /* ./limpeza */

        /* cadastro */
        $insere = DbModel::insert('representante_legais', $dados);
        if ($insere) {
            $id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Representante Legal',
                'texto' => 'Representante Legal cadastrado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'oficina/representante_cadastro&id='.MainModel::encryption($id)
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaRepresentante($dados, $id){
        $idDecryp = MainModel::decryption($id);
        unset($dados['editar']);
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $edita = DbModel::update('representante_legais', $dados, $idDecryp);
        if ($edita) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Representante Legal',
                'texto' => 'Representante Legal editado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'oficina/representante_cadastro&id='.$id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'oficina/representante_cadastro&id='.$id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaRepresentante($id) {
        $id = MainModel::decryption($id);
        $representante = DbModel::getInfo('representante_legais',$id);
        return $representante;
    }
}