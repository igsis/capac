<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
    require_once "../controllers/FomentoController.php";
} else {
    require_once "./models/ValidacaoModel.php";
    require_once "./controllers/FomentoController.php";
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

    protected function validaArquivosProjeto($projeto_id, $edital_id) {
        $tipo_contratacao_id = (new FomentoController)->recuperaTipoContratacao((int) $edital_id);
        $validaArquivos = ValidacaoModel::validaArquivosFomentos($projeto_id, $tipo_contratacao_id);
        if ($validaArquivos) {
            if (!isset($erros) || $erros == false) { $erros = []; }
            $erros = array_merge($erros, $validaArquivos);
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }
}