<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class EventoController extends MainModel
{
    public function listaEvento($usuario_id){
        $consultaEvento = DbModel::consultaSimples("SELECT * FROM eventos AS e INNER JOIN atracoes a on e.id = a.evento_id WHERE e.publicado = 1 AND a.publicado AND a.oficina = 1 AND usuario_id = '$usuario_id'");
        return $consultaEvento->fetchAll();
    }

    public function insereEvento($post){
        /* executa limpeza nos campos */
        $dadosEvento = [];
        unset($post['_method']);
        foreach ($post as $campo => $valor) {
            if (($campo != "publicos") && ($campo != "fomento_id")) {
                $dadosEvento[$campo] = MainModel::limparString($valor);
                unset($post[$campo]);
            }
        }
        $dadosEvento['usuario_id'] = $_SESSION['idUsuario_c'];
        $dadosEvento['data_cadastro'] = date('Y-m-d H:i:s');
        /* /.limpeza */

        /* cadastro */
        $insere = DbModel::insert('eventos', $dadosEvento);
        if ($insere->rowCount() >= 1) {
            $evento_id = DbModel::connection()->lastInsertId();
            $dadosRelacionamento = [
                'tabela' => 'evento_publico',
                'entidadeForte' => 'evento_id',
                'idEntidadeForte' => $evento_id,
                'entidadeFraca' => 'fomento_id',
                'idsEntidadeFraca' => $post['publico']
            ];
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Oficina',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'eventos/evento_cadastro'
            ];
        }
        /* /.cadastro */
        return MainModel::sweetAlert($alerta);
    }

    public function editaEvento($dados,$id){
        /* executa limpeza nos campos */
        $dados = [];
        foreach ($_POST as $campo => $post) {
            if (($campo != "editar") && ($campo != "_method")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }
        /* /.limpeza */

        // edição
        $edita = DbModel::update("eventos",$dados,$id);
        if ($edita){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Oficina',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL
            ];
        }
    }

    public function apagaEvento($id){
        $apaga = DbModel::delete("eventos", $id);
        if ($apaga){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Oficina',
                'texto' => 'Oficina apagada com sucesso!',
                'tipo' => 'danger',
                'location' => SERVERURL
            ];
        }
    }

    public function exibeDescricaoPublico() {
        $publicos = DbModel::consultaSimples("SELECT publico, descricao FROM publicos WHERE publicado = '1' ORDER BY 1");
        foreach ($publicos->fetchAll() as $publico) {
            ?>
            <tr>
                <td><?= $publico['publico'] ?></td>
                <td><?= $publico['descricao'] ?></td>
            </tr>
            <?php
        }
    }
}