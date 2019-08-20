<?php
$pedidoAjax = 1;
require_once "../models/MainModel.php";
define('SERVERURL', "http://{$_SERVER['HTTP_HOST']}/capac/");

class ProdutorController extends MainModel
{
    public function insereProdutor($dados){
        /* executa limpeza nos campos */
        $dados = [];
        foreach ($_POST as $campo => $post) {
            if (($campo != "cadastrar") && ($campo != "_method")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }
        /* ./limpeza */

        /* cadastro */
        $insere = DbModel::insert('produtores', $dados);
        if ($insere) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Produtor',
                'texto' => 'Produtor cadastrado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'oficina/produtor_cadastro'
            ];

        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaProdutor($dados, $id){
        $edita = DbModel::update('produtores', $dados, $id);
        if ($edita) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Produtor',
                'texto' => 'Produtor editado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'oficina/produtor_cadastro'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
}

if(isset($_POST['cadastrar'])){
    $dados = $_POST;
    $produtor = new ProdutorController();
    $produtor -> insereProdutor($dados);
}

if(isset($_POST['editar'])){
    $dados = $_POST;
    $id = $_POST['id'];
    $produtor = new ProdutorController();
    $produtor -> editaProdutor($dados, $id);
}