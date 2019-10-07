<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class LiderController extends MainModel
{
    public function insereLider()
    {
        PessoaFisicaController::inserePessoaFisica($_POST['pagina']);
       //$insere = DbModel::insert("lideres")

    }

    public function listaAtracaoProponente()
    {
        $idEvento = MainModel::decryption($_SESSION['evento_id_c']);
        $atracao = DbModel::consultaSimples("
            SELECT atr.id as atracao_id, atr.evento_id, atr.nome_atracao, pf.nome FROM atracoes AS atr
            LEFT JOIN lideres lid on atr.id = lid.atracao_id
            LEFT JOIN pessoa_fisicas AS pf ON lid.pessoa_fisica_id = pf.id
            WHERE atr.publicado = 1 AND atr.evento_id = $idEvento
        ")->fetchAll(PDO::FETCH_ASSOC);
        return $atracao;
    }
}