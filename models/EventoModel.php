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
            $evento->fomento_nome = $this->recuperaEventoFomento($id)['fomento'];
            $evento->publicos = (object) $this->recuperaEventoPublico($id);
        }
        return $evento;
    }

    protected function validaEvento($evento_id)
    {
        $evento = DbModel::getInfo('eventos', $evento_id)->fetch(PDO::FETCH_ASSOC);

        foreach ($evento as $coluna => $valor) {
        if ($valor == "") {
            $erros[$coluna]['bol'] = true;
            $erros[$coluna]['motivo'] = "Campo ".$coluna." não preechido";
        }
    }

        if ($evento['fomento'] == 1) {
            $fomento = DbModel::consultaSimples("SELECT * FROM evento_fomento WHERE evento_id = '$evento_id'");
            if ($fomento->rowCount() == 0) {
                $erros['fomento']['bol'] = true;
                $erros['fomento']['motivo'] = "O evento será fomentado, porém nenhum fomento foi selecionado";
            }
        }

        $publicos = DbModel::consultaSimples("SELECT * FROM evento_publico WHERE evento_id = '$evento_id'");
        if ($publicos->rowCount() == 0) {
            $erros['publicos']['bol'] = true;
            $erros['publicos']['motivo'] = "Nenhuma Representatividade e Visibilidade Sócio-cultural selecionada para este evento";
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }
}