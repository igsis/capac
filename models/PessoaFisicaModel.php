<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class PessoaFisicaModel extends MainModel
{
    protected function getCPF($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM pessoa_fisicas WHERE cpf = :cpf ";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":cpf", $dados['cpf']);
        $statement->execute();
        return $statement;
    }

    protected function getPassaporte($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM pessoa_fisicas WHERE passaporte = :passaporte";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":passaporte", $dados['passaporte']);
        $statement->execute();
        return $statement;
    }

    protected function limparStringPF($dados) {
        unset($dados['_method']);
        unset($dados['pagina']);
        /* executa limpeza nos campos */

        foreach ($dados as $campo => $post) {
            $dig = explode("_",$campo)[0];
            switch ($dig) {
                case "pf":
                    $campo = substr($campo, 3);
                    $dadosLimpos['pf'][$campo] = MainModel::limparString($post);
                    break;
                case "bc":
                    $campo = substr($campo, 3);
                    $dadosLimpos['bc'][$campo] = MainModel::limparString($post);
                    break;
                case "en":
                    $campo = substr($campo, 3);
                    $dadosLimpos['en'][$campo] = MainModel::limparString($post);
                    break;
                case "te":
                    if($dados[$campo] != ''){
                        $dadosLimpos['telefones'][$campo]['telefone'] = MainModel::limparString($post);
                    }
                    break;
                case "ni":
                    $campo = substr($campo, 3);
                    $dadosLimpos['ni'][$campo] = MainModel::limparString($post);
                    break;
                case "dr":
                    $campo = substr($campo, 3);
                    $dadosLimpos['dr'][$campo] = MainModel::limparString($post);
                    break;
            }
        }

        return $dadosLimpos;
    }
}