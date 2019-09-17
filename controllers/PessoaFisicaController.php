<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class PessoaFisicaController extends MainModel
{
    public function inserePessoaFisica(){

        unset($_POST['_method']);
        /* executa limpeza nos campos */
        $dados_pf = [];
        $dados_bc = [];
        $dados_en = [];
        $dados_te = [];
        $dados_ni = [];
        foreach ($_POST as $campo => $post) {
            $dig = explode("_",$campo)[0];
            switch ($dig) {
                case "pf":
                    $campo = substr($campo, 3);
                    $dados_pf[$campo] = MainModel::limparString($post);
                    break;
                case "bc":
                    $campo = substr($campo, 3);
                    $dados_bc[$campo] = MainModel::limparString($post);
                    break;
                case "en":
                    $campo = substr($campo,3);
                    $dados_en[$campo] = MainModel::limparString($post);
                    break;
                case "te":
                    $campo = substr($campo,3);
                    $dados_te[$campo] = MainModel::limparString($post);
                    break;
                case "ni":
                    $campo = substr($campo,3);
                    $dados_ni[$campo] = MainModel::limparString($post);
                    break;
            }
        }
        /* ./limpeza */

        /* cadastro */
        $insere = DbModel::insert('pessoa_fisicas', $dados_pf);
        if ($insere->rowCount()>0) {
            $id = DbModel::connection()->lastInsertId();
            if (count($dados_bc)>0){
                $dados_bc['pessoa_fisica_id'] = $id;
                $insere_banco = DbModel::insert('pf_bancos', $dados_bc);
            }

            if (count($dados_en)>0){
                $dados_en['pessoa_fisica_id'] = $id;
                $insere_endereco = DbModel::insert('pf_enderecos', $dados_en);
            }

            if (count($dados_ni)>0){
                $dados_ni['pessoa_fisica_id'] = $id;
                $insere_nit = DbModel::insert('nits', $dados_ni);
            }

            if (count($dados_te)>0){
                $dados_te['pessoa_fisica_id'] = $id;
                $insere_telefone = DbModel::insert('pf_telefones', $dados_te);
            }




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

        $edita = DbModel::update('pessoa_fisicas', $dados, $idDecryp);
        if ($edita) {

            if (count($dados_bc) > 0) {
                $banco_existe = DbModel::consultaSimples("SELECT * FROM pf_bancos WHERE pessoa_fisica_id = '$idDecryp'");
                if ($banco_existe->rowCount()>0){
                    $edita_banco = DbModel::update('pf_bancos', $dados_bc);
                }
                else{
                    $dados_bc['pessoa_fisica_id'] = $id;
                    $insere_banco = DbModel::insert('pf_bancos', $dados_bc);
                }
            }

            if (count($dados_en) > 0) {
                $dados_en['pessoa_fisica_id'] = $id;
                $insere_endereco = DbModel::insert('pf_enderecos', $dados_en);
            }

            if (count($dados_ni) > 0) {
                $dados_ni['pessoa_fisica_id'] = $id;
                $insere_nit = DbModel::insert('nits', $dados_ni);
            }

            if (count($dados_te) > 0) {
                $dados_te['pessoa_fisica_id'] = $id;
                $insere_telefone = DbModel::insert('pf_telefones', $dados_te);
            }
        }



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

    public function getCPF($cpf){
        $consulta_pf_cpf = DbModel::consultaSimples("SELECT * FROM pessoa_fisicas WHERE cpf = '$cpf'");
        return $consulta_pf_cpf;
    }

    public function getPassaporte($passaporte){
        $consulta_pf_pass = DbModel::consultaSimples("SELECT * FROM pessoa_fisicas WHERE passaporte = '$passaporte'");
        return $consulta_pf_pass;
    }
}