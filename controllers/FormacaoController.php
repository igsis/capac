<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/MainModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoController extends MainModel
{
    public function listaAbertura()
    {
        return MainModel::consultaSimples("SELECT * FROM form_aberturas WHERE publicado = 1 ORDER BY data_publicacao DESC;")->fetchAll(PDO::FETCH_OBJ);
    }

    public function inserePfCadastro($pagina)
    {
        $idPf = PessoaFisicaController::inserePessoaFisica($pagina, true);
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
        foreach ($_POST as $campo => $post) {
            $dados[$campo] = MainModel::limparString($post);
        }
        /* ./limpeza */
        DbModel::insert("form_cadastros",$dados);
        if (DbModel::connection()->errorCode() == 0) {
            $id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Detalhes do programa',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '&idC=' . MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaFormacao($id)
    {
        /* executa limpeza nos campos */
        $idDecrypt = MainModel::decryption($id);
        $dados = [];
        $pagina = $_POST['pagina'];
        unset($_POST['_method']);
        unset($_POST['pagina']);
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
                'location' => SERVERURL . $pagina . '&idC=' . $id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '&idC=' . $id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaFormacao($idUsuario)
    {
        return MainModel::consultaSimples("SELECT fc.*, pf.nome,fp.programa, fl.linguagem FROM form_cadastros fc INNER JOIN pessoa_fisicas pf on fc.pessoa_fisica_id = pf.id INNER JOIN form_programas fp ON fc.programa_id = fp.id INNER JOIN form_linguagens fl on fc.linguagem_id = fl.id WHERE fc.usuario_id = '$idUsuario'")->fetchAll(PDO::FETCH_OBJ);
    }

    public function recuperaFormacao($idPf)
    {
        $idPf = MainModel::decryption($idPf);
        $formacao = DbModel::consultaSimples("
            SELECT * 
            FROM form_cadastros 
            LEFT JOIN form_regioes_preferenciais frp on form_cadastros.regiao_preferencial_id = frp.id
            LEFT JOIN form_programas fp on form_cadastros.programa_id = fp.id
            LEFT JOIN form_linguagens fl on form_cadastros.linguagem_id = fl.id
            LEFT JOIN form_projetos f on form_cadastros.projeto_id = f.id
            LEFT JOIN form_cargos fc on form_cadastros.form_cargo_id = fc.id
            WHERE pessoa_fisica_id = '$idPf'
        ");
        return $formacao;
    }
}