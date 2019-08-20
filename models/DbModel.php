<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
    require_once "../config/configAPP.php";
} else {
    require_once "./models/MainModel.php";
    require_once "./config/configAPP.php";
}

class DbModel
{
    public static $conn;

    protected function connection() {
        if(!isset(self::$conn)) {
            self::$conn = new PDO(SGDB, USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }

    /**
     * <p>Função para inserir um registro no banco de dados </p>
     * @param string $table
     * <p>Tabela do banco de dados</p>
     * @param array $data
     * <p>Dados a serem inseridos</p>
     * @return bool|PDOStatement
     */
    protected function insert($table, $data) {
        $pdo = self::connection();
        $fields = implode(", ", array_keys($data));
        $values = ":".implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $statement = $pdo->prepare($sql);
        foreach($data as $key => $value) {
            $statement->bindValue(":$key", $value, PDO::PARAM_STR);
        }
        $statement->execute();

        return $statement;
    }

    // Método para update
    protected function update($table, $data, $id){
        $pdo = self::connection();
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

        return $statement;
    }

    // Método para apagar (despublicar)
    protected function delete($table, $id){
        $pdo = self::connection();
        $sql = "UPDATE $table SET publicado = 0 WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement;
    }

    protected function consultaSimples($consulta) {
        $pdo = self::connection();
        $statement = $pdo->prepare($consulta);
        $statement->execute();

        return $statement;
    }

    // Método para pegar a informação
    protected function getInfo($table, $id){
        $pdo = self::connection();
        $sql = "SELECT * FROM $table WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement->fetchAll();
    }

    // Lista publicados
    protected function listaPublicado($table,$id) {
        if(!empty($id)){
            $filtro_id = "AND id = :id";
        }
        else{
            $filtro_id = "";
        }
        $pdo = self::connection();
        $sql = "SELECT * FROM $table WHERE publicado = 1 $filtro_id ORDER BY 2";
        $statement = $pdo->query($sql);
        $statement->execute();

        return $statement->fetchAll();
    }
}