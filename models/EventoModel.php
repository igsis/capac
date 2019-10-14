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
        $sql = "SELECT ef.fomento_id, f.fomento FROM evento_fomento AS ef
                INNER JOIN fomentos AS f on ef.fomento_id = f.id
                WHERE ef.evento_id = :eventoId";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':eventoId', $id);
        $statement->execute();
        $fomento = $statement->fetch();
        return $fomento;
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
            $evento->fomento_id = $this->recuperaEventoFomento($id)['fomento_id'];
            $evento->fomento = $this->recuperaEventoFomento($id)['fomento'];
            $evento->publicos = (object) $this->recuperaEventoPublico($id);
        }
        return $evento;
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
            if ($fomento->rowCount() == 0) {
                $erros['fomento']['bol'] = true;
                $erros['fomento']['motivo'] = "O evento será fomentado, porém nenhum fomento foi selecionado";
            }
        }

        return $erros;
    }
}