<?php


class ManagerModel extends ConnectionModel
{
    // Método para inserir
    public function insert($table, $data) {
        $pdo = parent::connection();
        $fields = implode(", ", array_keys($data));
        $values = ":".implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $statement = $pdo->prepare($sql);
        foreach($data as $key => $value) {
            $statement->bindValue(":$key", $value, PDO::PARAM_STR);
        }
        $statement->execute();
    }

    // Método para update
    public function update($table, $data, $id){
        $pdo = parent::connection();
        $new_values = "";
        foreach($data as $key => $value) {
            $new_values .= "$key=:$key, ";
        }
        $new_values = substr($new_values, 0, -2);
        $sql = "UPDATE $table SET $new_values WHERE id = :id";
        $statement = $pdo->prepare($sql);
        foreach($data as $key => $value) {
            $statement->bindValue(":$key", $value, PDO::PARAM_STR);
        }
        $statement->execute();
    }

    // Método para apagar (despublicar)
    public function delete($table, $id){
        $pdo = parent::connection();
        $sql = "UPDATE $table SET publicado = 0 WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
    }

    // Método para pegar a informação
    public function getInfo($table, $id){
        $pdo = parent::connection();
        $sql = "SELECT * FROM $table WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement->fetchAll();
    }

    // Lista publicados
    public function listaPublicado($table,$id) {
        if(!empty($id)){
            $filtro_id = "AND id = :id";
        }
        else{
            $filtro_id = "";
        }
        $pdo = parent::connection();
        $sql = "SELECT * FROM $table WHERE publicado = 1 $filtro_id ORDER BY 2";
        $statement = $pdo->query($sql);
        $statement->execute();

        return $statement->fetchAll();
    }
}