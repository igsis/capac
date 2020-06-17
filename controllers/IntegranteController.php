<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class IntegranteController extends MainModel
{
    public function listaNucleo($projeto_id)
    {
        $projeto_id = MainModel::decryption($projeto_id);
        return DbModel::consultaSimples("SELECT fna.id, fna.nome, fna.rg, fna.cpf FROM fom_projeto_nucleo_artistico fpna INNER JOIN integrantes fna ON fpna.fom_nucleo_artistico_id = fna.id WHERE fpna.fom_projeto_id = '$projeto_id'")->fetchAll(PDO::FETCH_OBJ);
    }

    public function validaCpfNucleo()
    {
        $cpf = $_POST['cpf'];
        /* valida cpf */
        $consulta = DbModel::consultaSimples("SELECT * FROM integrantes WHERE cpf = '$cpf'");
    }

    public function cadastraNucleo()
    {
        $dados=[];
        unset($_POST['_method']);
        $projeto_id = $_POST['projeto_id'];
        unset($_POST['projeto_id']);
        foreach ($_POST as $campo => $post) {
            $dados[$campo] = MainModel::limparString($post);
        }
        $insere = DbModel::insert("integrantes",$dados);
        if ($insere->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $id = DbModel::connection()->lastInsertId();
            $nucleo['projeto'] = $projeto_id;
            $nucleo['pf'] = $id;
            $insereProjeto = DbModel::insert("fom_projeto_nucleo_artistico",$nucleo);
            if ($insere->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Núcleo artístico',
                    'texto' => 'Integrante cadastrado com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.'fomentos/nucleo_artistico_cadastro&id='.MainModel::encryption($id)
                ];
            }
            else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL.'/fomentos/nucleo_artistico_lista'
                ];
            }
        }
        else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'/fomentos/nucleo_artistico_lista'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaNucleo($id)
    {
        $dados=[];
        $idDecryp = MainModel::decryption($id);
        unset($_POST['_method']);
        unset($_POST['id']);

        foreach ($_POST as $campo => $post) {
            $dados[$campo] = MainModel::limparString($post);
        }

        $edita = DbModel::update('integrantes', $dados, $idDecryp);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Núcleo artístico',
                'texto' => 'Integrante cadastrado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'fomentos/nucleo_artistico_cadastro&id='.MainModel::encryption($idDecryp)
            ];
        }
        else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'fomentos/nucleo_artistico_cadastro&id='.MainModel::encryption($idDecryp)
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function apagaNucleo($id)
    {
        $idDecryp = MainModel::decryption($id);
        $delete = DbModel::deleteEspecial("integrantes","id",$idDecryp);
        if ($delete->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $deleteNucleo = DbModel::deleteEspecial("fom_projeto_nucleo_artistico","fom_nucleo_artistico_id",$idDecryp);
            if ($deleteNucleo->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Núcleo artístico',
                    'texto' => 'Integrante excluído com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.'fomentos/nucleo_artistico_lista'
                ];
            }
            else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL.'fomentos/nucleo_artistico_cadastro&id='.MainModel::encryption($idDecryp)
                ];
            }
        }
        else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'fomentos/nucleo_artistico_cadastro&id='.MainModel::encryption($idDecryp)
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
}