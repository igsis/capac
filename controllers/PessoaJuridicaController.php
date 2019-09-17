<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class PessoaJuridicaController extends MainModel
{
    public function inserePessoaJuridica($dados){
        /* executa limpeza nos campos */
        $dados = [];
        foreach ($_POST as $campo => $post) {
            if (($campo != "cadastrar") && ($campo != "_method")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }
        /* ./limpeza */

        /* cadastro */
        $insere = DbModel::insert('pessoa_juridicas', $dados);
        if ($insere) {
            $id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Jurídica',
                'texto' => 'Pessoa Jurídica cadastrada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'oficina/pj_cadastro&id='.MainModel::encryption($id)
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaPessoaJuridica($dados, $id){
        $idDecryp = MainModel::decryption($id);
        unset($dados['editar']);
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $edita = DbModel::update('pessoa_juridicas', $dados, $idDecryp);
        if ($edita) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Jurídica',
                'texto' => 'Pessoa Jurídica editada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'oficina/pj_cadastro&id='.$id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'oficina/pj_cadastro&id='.$id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaPessoaJuridica($id) {
        $id = MainModel::decryption($id);
        $pj = DbModel::consultaSimples(
            "SELECT * FROM pessoa_juridicas AS pj
            LEFT JOIN pj_telefones pt on pj.id = pt.pessoa_juridica_id
            LEFT JOIN pj_enderecos pe on pj.id = pe.pessoa_juridica_id
            LEFT JOIN pj_bancos pb on pj.id = pb.pessoa_juridica_id
            LEFT JOIN pj_oficinas po on pj.id = po.pessoa_juridica_id
            WHERE pj.id = '$id'");
        return $pj;
    }
/*
    public function getCNPJ($cnpj){
        $consulta_pj_cnpj = DbModel::consultaSimples("SELECT * FROM pessoa_juridicas WHERE cnpj = '$cnpj'");
        return $consulta_pj_cnpj;
    }*/
}