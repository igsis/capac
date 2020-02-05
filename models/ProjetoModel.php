<?php

if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
} else {
    require_once "./models/ValidacaoModel.php";
}


class ProjetoModel extends ValidacaoModel
{
    protected function validaProjetoModal($idProjeto){
        $proj = DbModel::getInfo('fom_projetos',$idProjeto)->fetchObject();
        $naoObrigados = [
          'pessoa_fisica_id',
          'pessoa_juridica_id',
          'protocolo',
          'data_inscricao'
        ];

        $erros = ValidacaoModel::retornaMensagem($proj,$naoObrigados);

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

}