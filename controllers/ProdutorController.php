<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

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
            $id = DbModel::connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Produtor',
                'texto' => 'Produtor cadastrado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'oficina/produtor_cadastro&id='.MainModel::encryption($id)
            ];

        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaProdutor($dados, $id){
        $idDecryp = MainModel::decryption($id);
        unset($dados['editar']);
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $edita = DbModel::update('produtores', $dados, $idDecryp);
        if ($edita) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Produtor',
                'texto' => 'Produtor editado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'oficina/produtor_cadastro&id='.$id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'oficina/produtor_cadastro&id='.$id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaProdutor($id) {
        $id = MainModel::decryption($id);
        $produtor = DbModel::getInfo('produtores',$id);
        return $produtor;
    }
}

//if(isset($_POST['cadastrar'])){
//    $dados = $_POST;
//    $produtor = new ProdutorController();
//    $produtor -> insereProdutor($dados);
//}
//
//if(isset($_POST['editar'])){
//    $dados = $_POST;
//    $id = $_POST['id'];
//    $produtor = new ProdutorController();
//    $produtor -> editaProdutor($dados, $id);
//}