<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class RepresentanteController extends MainModel
{
    public function insereRepresentante($pagina){
        /* executa limpeza nos campos */
        $dados = [];
        unset($_POST['cadastrar']);
        unset($_POST['_method']);
        unset($_POST['pagina']);
        foreach ($_POST as $campo => $post) {
            if (($campo != "idPj") && ($campo != "representante")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }
        /* ./limpeza */

        /* cadastro */
        $insere = DbModel::insert('representante_legais', $dados);
        $idPj = MainModel::decryption($_POST['idPj']);
        if ($insere) {
            $id = DbModel::connection()->lastInsertId();
            $rep = $_POST['representante'];
            $pj_dados = [
                'representante_legal'.$rep.'_id' => $id
            ];
            $edita_pj = DbModel::update('pessoa_juridicas',$pj_dados,$idPj);
            if ($edita_pj){
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Representante Legal',
                    'texto' => 'Representante Legal cadastrado com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.$pagina.'/representante_cadastro&id='.MainModel::encryption($id).'&idPj='.MainModel::encryption($idPj)
                ];
            }
            else{
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL.$pagina.'/pj_cadastro&id='.MainModel::encryption($idPj)
                ];
            }
        }
        else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina.'/pj_cadastro&id='.MainModel::encryption($idPj)
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaRepresentante($id,$pagina){
        $idDecryp = MainModel::decryption($id);
        $idPj = MainModel::decryption($_POST['idPj']);

        unset($_POST['_method']);
        unset($_POST['pagina']);
        unset($_POST['id']);
        unset($_POST['idPj']);

        foreach ($_POST as $campo => $post) {
            if (($campo != "idPj") && ($campo != "representante")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }

        $edita = DbModel::update('representante_legais', $dados, $idDecryp);
        if ($edita) {
            $rep = $_POST['representante'];
            $pj_dados = [
                'representante_legal'.$rep.'_id' => MainModel::decryption($id)
            ];
            $edita_pj = DbModel::update('pessoa_juridicas',$pj_dados,$idPj);
            if ($edita_pj){
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Representante Legal',
                    'texto' => 'Representante Legal editado com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.$pagina.'/representante_cadastro&id='.$id.'&idPj='.MainModel::encryption($idPj)
                ];
            }
            else{
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL.$pagina.'/representante_cadastro&id='.$id.'&idPj='.MainModel::encryption($idPj)
                ];
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina.'/representante_cadastro&id='.$id.'&idPj='.MainModel::encryption($idPj)
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaRepresentante($id) {
        $id = MainModel::decryption($id);
        $representante = DbModel::getInfo('representante_legais',$id);
        return $representante;
    }

    public function getCPF($cpf){
        $consulta_pf_cpf = DbModel::consultaSimples("SELECT id, cpf FROM representante_legais WHERE cpf = '$cpf'");
        return $consulta_pf_cpf;
    }
}