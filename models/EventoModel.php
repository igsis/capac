<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class EventoModel extends MainModel
{
    protected function recuperaEventoFomento($id) {
        $pdo = DbModel::connection();
        $sql = "SELECT ef.fomento_id FROM evento_fomento AS ef
                INNER JOIN fomentos AS f on ef.fomento_id = f.id
                WHERE ef.evento_id = :eventoId";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':eventoId', $id);
        $statement->execute();
        $fomento = $statement->fetch();
        return $fomento['fomento_id'];
    }

    protected function recuperaEventoPublico($id) {
        $pdo = DbModel::connection();
        $sql = "SELECT ep.publico_id FROM evento_publico AS ep
                INNER JOIN publicos AS p on ep.publico_id = p.id
                WHERE ep.evento_id = :eventoId";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':eventoId', $id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    protected function getEvento($id) {
        $evento = DbModel::getInfo('eventos', $id)->fetchObject();
        if ($evento) {
            $evento->fomento_id = $this->recuperaEventoFomento($id);
            $evento->publicos = (object) $this->recuperaEventoPublico($id);
        }
        return $evento;
    }
}