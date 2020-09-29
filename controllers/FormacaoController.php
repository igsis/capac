<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/ValidacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoController extends ValidacaoModel
{
    public function listaAbertura()
    {
        return MainModel::consultaSimples("SELECT * FROM form_aberturas WHERE publicado = 1 ORDER BY data_publicacao DESC;")->fetchAll(PDO::FETCH_OBJ);
    }

    public function verificaCadastroNoAno($usuario_id, $ano)
    {
        return DbModel::consultaSimples("SELECT id FROM form_cadastros WHERE usuario_id = '$usuario_id' AND ano = '$ano' AND publicado = '1'")->rowCount();
    }

    public function recuperaFormacaoId($pessoa_fisica_id, $ano)
    {
        $idPf = MainModel::decryption($pessoa_fisica_id);
        $form_cadastro_id = DbModel::consultaSimples("SELECT id FROM form_cadastros WHERE pessoa_fisica_id = $idPf AND ano = $ano")->fetchColumn();

        if ($form_cadastro_id) {
            return MainModel::encryption($form_cadastro_id);
        } else {
            return false;
        }
    }

    public function inserePfCadastro($pagina)
    {
        $idPf = (new PessoaFisicaController)->inserePessoaFisica($pagina, true);
        if ($idPf) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pf_cadastro&id=' . MainModel::encryption($idPf)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/pf_busca'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaPfCadastro($id,$pagina)
    {
        $idPf = (new PessoaFisicaController)->editaPessoaFisica($id,$pagina,true);
        if ($idPf) {
            $_SESSION['origem_id_c'] = $id;
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Pessoa Física editada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.$pagina.'/pf_cadastro&id='.$id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/pf_cadastro&id='.$id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function insereFormacao()
    {
        /* executa limpeza nos campos */
        unset($_POST['_method']);
        $dados['pessoa_fisica_id'] = MainModel::decryption($_SESSION['origem_id_c']);
        $cargosAdicionais = ['form_cargo2_id', 'form_cargo3_id'];

        foreach ($_POST as $campo => $post) {
            if (!in_array($campo, $cargosAdicionais)) {
                $dados[$campo] = MainModel::limparString($post);
            } else {
                $dadosAdicionais[$campo] = MainModel::limparString($post);
            }
        }
        /* ./limpeza */
        DbModel::insert("form_cadastros",$dados);
        if (DbModel::connection()->errorCode() == 0) {
            $id = DbModel::connection()->lastInsertId();
            $_SESSION['formacao_id_c'] = MainModel::encryption($id);
            if (isset($dadosAdicionais)) {
                $dadosAdicionais['form_cadastro_id'] = $id;
                DbModel::insert("form_cargos_adicionais",$dadosAdicionais);
            }
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Detalhes do programa',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/formacao_cadastro&idC=' . $_SESSION['formacao_id_c']
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                //@todo: verificar se este location não gera erro
                'location' => SERVERURL . 'formacao/formacao_cadastro'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaFormacao($id)
    {
        /* executa limpeza nos campos */
        $idDecrypt = MainModel::decryption($id);
        $dados = [];
        unset($_POST['_method']);
        unset($_POST['id']);
        $dados['id'] = $idDecrypt;
        foreach ($_POST as $campo => $post) {
            $dados[$campo] = MainModel::limparString($post);
        }
        /* ./limpeza */
        DbModel::update("form_cadastros",$dados,$idDecrypt);
        if (DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Detalhes do programa',
                'texto' => 'Cadastro editado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/formacao_cadastro&idC=' . $id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'formacao/formacao_cadastro&idC=' . $id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaFormacao($idUsuario)
    {
        return MainModel::consultaSimples("SELECT fc.*, pf.nome,fp.programa, fl.linguagem FROM form_cadastros fc INNER JOIN pessoa_fisicas pf on fc.pessoa_fisica_id = pf.id INNER JOIN form_programas fp ON fc.programa_id = fp.id INNER JOIN form_linguagens fl on fc.linguagem_id = fl.id WHERE fc.usuario_id = '$idUsuario' AND fc.publicado = 1")->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperaFormacao($idPf, $ano)
    {
        $idPf = MainModel::decryption($idPf);
        $formacao = DbModel::consultaSimples("
            SELECT
                fcad.id,
                fcad.pessoa_fisica_id,
                fcad.ano,
                fcad.regiao_preferencial_id,
                frp.regiao,
                fcad.programa_id,
                fp.programa,
                fcad.linguagem_id,
                fl.linguagem,
                fcad.form_cargo_id,
                fc.cargo AS 'cargo1',
                fcad.usuario_id,
                fca.form_cargo2_id,
                fc2.cargo AS 'cargo2',
                fca.form_cargo3_id,
                fc3.cargo AS 'cargo3'
            FROM form_cadastros AS fcad
            LEFT JOIN form_regioes_preferenciais frp on fcad.regiao_preferencial_id = frp.id
            LEFT JOIN form_programas fp on fcad.programa_id = fp.id
            LEFT JOIN form_linguagens fl on fcad.linguagem_id = fl.id
            LEFT JOIN form_cargos fc on fcad.form_cargo_id = fc.id
            LEFT JOIN form_cargos_adicionais fca on fcad.id = fca.form_cadastro_id
            LEFT JOIN form_cargos fc2 on fca.form_cargo2_id = fc2.id
            LEFT JOIN form_cargos fc3 on fca.form_cargo3_id = fc3.id
            WHERE pessoa_fisica_id = '$idPf' AND ano = '$ano'
        ");
        return $formacao;
    }

    public function recuperaAnoReferenciaAtual($idEdital)
    {
        $idEdital = MainModel::decryption($idEdital);
        return MainModel::consultaSimples("SELECT ano_referencia FROM form_aberturas WHERE id='$idEdital'")->fetchColumn();
    }

    public function apagaFormacao($id){
        $apaga = DbModel::apaga("form_cadastros", $id);
        if ($apaga){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto',
                'texto' => 'Projeto apagado com sucesso!',
                'tipo' => 'danger',
                'location' => SERVERURL.'formacao'
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

    public function validaForm($form_cadastro_id, $pessoa_fisica_id) {
        $form_cadastro_id = MainModel::decryption($form_cadastro_id);

        $erros['Proponente'] = (new PessoaFisicaController)->validaPf($pessoa_fisica_id, 3);
        $erros['Formação'] = ValidacaoModel::validaFormacao($pessoa_fisica_id);
        $erros['Arquivos'] = ValidacaoModel::validaArquivosFormacao($form_cadastro_id);

        return MainModel::formataValidacaoErros($erros);
    }

    public function enviarCadastro($id)
    {
        $id = MainModel::decryption($id);
        $f = MainModel::encryption("F");
        $formacao['protocolo'] = MainModel::gerarProtocolo($id,$f);
        $formacao['data_envio'] = date("Y-m-d H:i:s");

        $update = DbModel::update('form_cadastros',$formacao,$id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
//            @todo: descomentar este alerta após PDF completo
//            $alerta = [
//                'alerta' => 'sucesso',
//                'titulo' => 'Cadastro Enviado',
//                'texto' => 'Cadastro enviado com sucesso!',
//                'tipo' => 'success',
//                'location' => SERVERURL.'fomentos/inicio',
//                'redirecionamento' => SERVERURL.'pdf/resumo_fomento.php?id='.$id
//            ];
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cadastro Enviado',
                'texto' => 'Cadastro enviado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'fomentos/inicio',
                'redirecionamento' => SERVERURL.'formacao/inicio'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao enviar o projeto!',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
}