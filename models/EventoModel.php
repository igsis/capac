<?php
$pedidoAjax = 1;

class EventoModel extends MainModel
{
    protected function getOficinas($usuario_id){
        $pdo = parent::connection();
        $sql = "
            SELECT * FROM eventos AS e 
            INNER JOIN atracoes a on e.id = a.evento_id
            WHERE e.publicado = 1 AND a.publicado AND a.oficina = 1 AND usuario_id = :usuario_id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":usuario_id", $usuario_id);
        $statement->execute();
        return $statement;
    }
}