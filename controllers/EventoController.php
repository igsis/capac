<?php
$pedidoAjax = 1;
//require_once "../models/MainModel.php";

class EventoController extends MainModel
{
    public function listaEvento($usuario_id){
        $consultaEvento = DbModel::consultaSimples("SELECT * FROM eventos AS e INNER JOIN atracoes a on e.id = a.evento_id WHERE e.publicado = 1 AND a.publicado AND a.oficina = 1 AND usuario_id = '{$usuario_id}'");
        return $consultaEvento->fetchAll();
    }

    public function insereEvento($dados){
        /* executa limpeza nos campos */
        $dados = [];
        foreach ($_POST as $campo => $post) {
            if (($campo != "cadastrar") && ($campo != "_method")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }
        /* /.limpeza */

        /* cadastro */
        $insere = DbModel::insert('eventos', $dados);
        if ($insere) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Oficina',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL
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
}