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
        $sql = "SELECT aa.acao_id FROM acao_atracao AS aa
                INNER JOIN acoes AS a on aa.acao_id = a.id
                WHERE aa.atracao_id = :atracao_id";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':atracao_id', $id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    protected function getAtracao($id) {
        $atracao = DbModel::getInfo('atracoes', $id)->fetchObject();
        if ($atracao) {
            $atracao->acoes = (object) $this->recuperaAtracaoAcao($id);
        }
        return $atracao;
    }
}