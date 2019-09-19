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
        $dados_dr = [];
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
                    $campo = substr($campo, 3);
                    $dados_en[$campo] = MainModel::limparString($post);
                    break;
                case "te":
                    $campo = substr($campo, 3);
                    $dados_te[$campo] = MainModel::limparString($post);
                    break;
                case "ni":
                    $campo = substr($campo, 3);
                    $dados_ni[$campo] = MainModel::limparString($post);
                    break;
                case "dr":
                    $campo = substr($campo, 3);
                    $dados_dr[$campo] = MainModel::limparString($post);
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

            if (count($dados_dr)>0){
                $dados_dr['pessoa_fisica_id'] = $id;
                $insere_drt = DbModel::insert('drts', $dados_dr);
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
                'location' => SERVERURL.'eventos/pf_cadastro&id='.MainModel::encryption($id)
            ];
        }
        else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'eventos/proponente'
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaPessoaFisica($id){
        $idDecryp = MainModel::decryption($_POST['id']);

        unset($_POST['_method']);
        /* executa limpeza nos campos */
        $dados_pf = [];
        $dados_bc = [];
        $dados_en = [];
        $dados_te = [];
        $dados_ni = [];
        $dados_dr = [];
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
                    $campo = substr($campo, 3);
                    $dados_en[$campo] = MainModel::limparString($post);
                    break;
                case "te":
                    $campo = substr($campo, 3);
                    $dados_te[$campo] = MainModel::limparString($post);
                    break;
                case "ni":
                    $campo = substr($campo, 3);
                    $dados_ni[$campo] = MainModel::limparString($post);
                    break;
                case "dr":
                    $campo = substr($campo, 3);
                    $dados_dr[$campo] = MainModel::limparString($post);
                    break;
            }
        }
        /* ./limpeza */

        $edita = DbModel::update('pessoa_fisicas', $dados_pf, $idDecryp);
        if ($edita) {

            if (count($dados_bc) > 0) {
                $banco_existe = DbModel::consultaSimples("SELECT * FROM pf_bancos WHERE pessoa_fisica_id = '$idDecryp'");
                if ($banco_existe->rowCount()>0){
                    $edita_banco = DbModel::updateEspecial('pf_bancos', $dados_bc, "pessoa_fisica_id",$idDecryp);
                }
                else{
                    $dados_bc['pessoa_fisica_id'] = $idDecryp;
                    $insere_banco = DbModel::insert('pf_bancos', $dados_bc);
                }
            }

            if (count($dados_en) > 0) {
                $endereco_existe = DbModel::consultaSimples("SELECT * FROM pf_enderecos WHERE pessoa_fisica_id = '$idDecryp'");
                if ($endereco_existe->rowCount()>0){
                    $edita_endereco = DbModel::updateEspecial('pf_enderecos', $dados_en, "pessoa_fisica_id",$idDecryp);
                }
                else{
                    $dados_en['pessoa_fisica_id'] = $idDecryp;
                    $insere_endereco = DbModel::insert('pf_enderecos', $dados_en);
                }
            }

            if (count($dados_te) > 0) {
                $telefone_existe = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$idDecryp'");
                if ($telefone_existe->rowCount()>0){
                    $edita_telefone = DbModel::updateEspecial('pf_telefones', $dados_te, "pessoa_fisica_id",$idDecryp);
                }
                else{
                    $dados_te['pessoa_fisica_id'] = $idDecryp;
                    $insere_telefone = DbModel::insert('pf_telefones', $dados_te);
                }
            }

            if (count($dados_ni) > 0) {
                $nit_existe = DbModel::consultaSimples("SELECT * FROM nits WHERE pessoa_fisica_id = '$idDecryp'");
                if ($nit_existe->rowCount()>0){
                    $edita_nit = DbModel::updateEspecial('nits', $dados_ni, "pessoa_fisica_id",$idDecryp);
                }
                else{
                    $dados_ni['pessoa_fisica_id'] = $idDecryp;
                    $insere_nit = DbModel::insert('nits', $dados_ni);
                }
            }

            if (count($dados_dr) > 0) {
                $drt_existe = DbModel::consultaSimples("SELECT * FROM drts WHERE pessoa_fisica_id = '$idDecryp'");
                if ($drt_existe->rowCount()>0){
                    $edita_drt = DbModel::updateEspecial('drts', $dados_dr, "pessoa_fisica_id",$idDecryp);
                }
                else{
                    $dados_dr['pessoa_fisica_id'] = $idDecryp;
                    $insere_drt = DbModel::insert('drts', $dados_dr);
                }
            }

            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Pessoa Física editada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.$pagina.'eventos/pf_cadastro&id='.$id
            ];

        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'eventos/proponente'
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
            LEFT JOIN drts d on pf.id = d.pessoa_fisica_id
            LEFT JOIN nits n on pf.id = n.pessoa_fisica_id
            WHERE pf.id = '$id'");
        return $pf;
    }

    public function getCPF($cpf){
        $consulta_pf_cpf = DbModel::consultaSimples("SELECT id, cpf FROM pessoa_fisicas WHERE cpf = '$cpf'");
        return $consulta_pf_cpf;
    }

    public function getPassaporte($passaporte){
        $consulta_pf_pass = DbModel::consultaSimples("SELECT id, passaporte FROM pessoa_fisicas WHERE passaporte = '$passaporte'");
        return $consulta_pf_pass;
    }
}