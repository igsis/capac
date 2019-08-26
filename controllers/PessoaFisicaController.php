<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class PessoaFisicaController extends MainModel
{
    public function inserePessoaFisica($dados){
        /* executa limpeza nos campos */
        $dados = [];
        foreach ($_POST as $campo => $post) {
            if (($campo != "cadastrar") && ($campo != "_method")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }
        /* ./limpeza */

        /* cadastro */
        $insere = DbModel::insert('pessoa_fisicas', $dados);
        if ($insere) {
            $id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Pessoa Física cadastrada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'oficina/pf_cadastro&id='.MainModel::encryption($id)
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaPessoaFisica($dados, $id){
        $idDecryp = MainModel::decryption($id);
        unset($dados['editar']);
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $edita = DbModel::update('pessoa_fisicas', $dados, $idDecryp);
        if ($edita) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Pessoa Física editada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'oficina/pf_cadastro&id='.$id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'oficina/pf_cadastro&id='.$id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaPessoaFisica($id) {
        $id = MainModel::decryption($id);
        $pf = DbModel::consultaSimples(
            "SELECT * FROM pessoa_fisicas AS pf
            LEFT JOIN pf_telefones pt on pf.id = pt.pessoa_fisica_id
            LEFT JOIN pf_enderecos pe on pf.id = pe.pessoa_fisica_id
            LEFT JOIN pf_bancos pb on pf.id = pb.pessoa_fisica_id
            LEFT JOIN pf_oficinas po on pf.id = po.pessoa_fisica_id
            WHERE pf.id = '$id'");
        return $pf;
    }
}