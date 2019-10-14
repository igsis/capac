<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class AtracaoModel extends MainModel
{
    protected function recuperaAtracaoAcao($id) {
        $pdo = DbModel::connection();
        $sql = "SELECT aa.acao_id, a.acao FROM acao_atracao AS aa
                INNER JOIN acoes AS a on aa.acao_id = a.id
                WHERE aa.atracao_id = :atracao_id";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':atracao_id', $id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    protected function getAtracao($id) {
        $atracao = DbModel::getInfo('atracoes', $id)->fetchObject();
        if ($atracao) {
            $atracao->acoes = (object) $this->recuperaAtracaoAcao($id);
        }
        return $atracao;
    }

    protected function validaProdutor($produtor_id) {
        $naoObrigatorios = [
            'telefone2',
            'observacao'
        ];

        $produtor = DbModel::consultaSimples("SELECT * FROM produtores WHERE id = '$produtor_id'")->fetchObject();

        foreach ($produtor as $coluna => $valor) {
            if (!in_array($coluna, $naoObrigatorios)) {
                if ($valor == "") {
                    $erros[$coluna]['bol'] = true;
                    $erros[$coluna]['motivo'] = true;
                }
            }
        }

        if (isset($erros)) {
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaAtracao($evento_id) {
        $naoObrigatorios = [
            'links'
        ];

        $atracoes = DbModel::consultaSimples("SELECT * FROM atracoes WHERE evento_id = '$evento_id'")->fetchAll(PDO::FETCH_OBJ);

        foreach ($atracoes as $atracao) {
            foreach ($atracao as $coluna => $valor) {
                if (!in_array($coluna, $naoObrigatorios)) {
                    if ($valor == "") {
                        $erros[$coluna]['bol'] = true;
                        $erros[$coluna]['motivo'] = "Campo " . $coluna . " não preechido";
                    }
                }
            }

            if ($atracao->produtor_id != null) {
                $produtor = $this->validaProdutor($atracao->produtor_id);
                if ($produtor) {
                    array_push($erros, $produtor);
                }
            }


        }
    }
}