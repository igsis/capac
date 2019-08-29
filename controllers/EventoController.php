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
        session_start(['name' => 'cpc']);
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
            $atualizaRelacionamento = MainModel::atualizaRelacionamento('evento_publico', 'evento_id', $evento_id, 'fomento_id', $post['publicos']);

            if ($atualizaRelacionamento) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Evento Cadastrado!',
                    'texto' => 'Dados cadastrados com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . 'eventos/evento_cadastro&key='.MainModel::encryption($evento_id)
                ];
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Oops! Algo deu Errado!',
                    'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                    'tipo' => 'error',
                ];
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
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

    public function recuperaEvento($id) {
        $id = MainModel::decryption($id);
        $evento = DbModel::getInfo('eventos', $id);
        return $evento;
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