<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class IntegranteController extends MainModel
{
    private function cadastraIntegranteProjeto($integrante_id)
    {
        $projeto_id = MainModel::decryption($_SESSION['projeto_c']);
        $relacionamento = MainModel::atualizaRelacionamento('fom_projeto_nucleo_artistico', 'fom_projeto_id', $projeto_id, 'fom_nucleo_artistico_id', $integrante_id);
        if ($relacionamento) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Núcleo artístico',
                'texto' => 'Integrante cadastrado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'fomentos/nucleo_artistico_cadastro&id='.MainModel::encryption($integrante_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'/fomentos/nucleo_artistico_lista'
            ];
        }

        return $alerta;
    }

    public function recuperaIntegranteCpf($cpf)
    {
        return DbModel::getInfoEspecial('integrantes', 'cpf', $cpf)->fetch();
    }

    public function recuperaIntegrante($id)
    {
        $id = MainModel::decryption($id);
        return DbModel::getInfo('integrantes', $id)->fetch();
    }

    public function listaNucleo($projeto_id)
    {
        $projeto_id = MainModel::decryption($projeto_id);
        return DbModel::consultaSimples("SELECT fna.id, fna.nome, fna.rg, fna.cpf FROM fom_projeto_nucleo_artistico fpna INNER JOIN integrantes fna ON fpna.fom_nucleo_artistico_id = fna.id WHERE fpna.fom_projeto_id = '$projeto_id'")->fetchAll(PDO::FETCH_OBJ);
    }

    public function cadastraIntegrante($fomentos = false)
    {
        unset($_POST['_method']);
        $dados = [];

        foreach ($_POST as $campo => $dado) {
            $dados[$campo] = MainModel::limparString($dado);
        }

        $insere = DbModel::insert("integrantes", $dados);
        if ($insere->rowCount() >= 1) {
            $integrante_id = DbModel::connection()->lastInsertId();
            if($fomentos) {
                $alerta = $this->cadastraIntegranteProjeto($integrante_id);
            }
        } else {
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

    public function editaIntegrante($id, $fomentos = false)
    {
        $dados=[];
        $integrante_id = MainModel::decryption($id);
        unset($_POST['_method']);
        unset($_POST['id']);

        foreach ($_POST as $campo => $dado) {
            $dados[$campo] = MainModel::limparString($dado);
        }

        $edita = DbModel::update('integrantes', $dados, $integrante_id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            if($fomentos) {
                $alerta = $this->cadastraIntegranteProjeto($integrante_id);
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'fomentos/nucleo_artistico_cadastro&id='.MainModel::encryption($integrante_id)
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