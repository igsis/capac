<?php
$pedidoAjax = 1;
//require_once "../models/MainModel.php";

class EventoController extends MainModel
{
    public function listaEvento(){

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
}