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

    public function eventoCompleto($idEvento)
    {
        $sql = DbModel::consultaSimples("
            SELECT ev.id,  ev.espaco_publico, ev.fomento, fo.fomento AS nome_fomento, ep.*, ev.sinopse
            FROM eventos as ev 
                LEFT JOIN evento_fomento AS ef ON ev.id = ef.evento_id 
                LEFT JOIN fomentos fo on ef.fomento_id = fo.id 
                INNER JOIN evento_publico ep on ev.id = ep.evento_id
                INNER JOIN publicos p on ep.publico_id = p.id
            WHERE ev.id = '$idEvento'");
        return $sql;
    }

    protected function validaEvento($idEvento)
    {
        $erros['bol'] = false;
        $evento = DbModel::getInfo('eventos', $idEvento)->fetch(PDO::FETCH_ASSOC);

        foreach ($evento as $coluna => $valor) {
            if ($valor == "") {
                $erros['evento']['bol'] = true;
                $erros['evento']['motivo'] = "Campo ".$coluna." não preechido";
            }
        }

        if ($evento['fomento'] == 1) {
            $fomento = DbModel::consultaSimples("SELECT * FROM evento_fomento WHERE evento_id = '$idEvento'");

        }

        return $erros;
    }
}