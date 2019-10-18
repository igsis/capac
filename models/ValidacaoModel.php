<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class ValidacaoModel extends MainModel
{
    protected function validaBanco($tipoProponente, $id) {
        if ($tipoProponente == 1) {
            $proponente = DbModel::consultaSimples("SELECT * FROM pf_bancos WHERE pessoa_fisica_id = '$id'");
        } else {
            $proponente = DbModel::consultaSimples("SELECT * FROM pj_bancos WHERE pessoa_juridica_id = '$id'");
        }
        if ($proponente->rowCount() == 0) {
            $erros['bancos']['bol'] = true;
            $erros['bancos']['motivo'] = "Proponente não possui conta bancária cadastrada";

            return $erros;
        } else {
            $proponente = $proponente->fetchObject();
            $erros = ValidacaoModel::retornaMensagem($proponente);
        }
        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaEndereco($tipoProponente, $id) {
        if ($tipoProponente == 1) {
            $proponente = DbModel::consultaSimples("SELECT * FROM pf_enderecos WHERE pessoa_fisica_id = '$id'");
        } else {
            $proponente = DbModel::consultaSimples("SELECT * FROM pj_enderecos WHERE pessoa_juridica_id = '$id'");
        }
        $naoObrigatorios = [
            'complemento'
        ];
        if ($proponente->rowCount() == 0) {
            $erros['enderecos']['bol'] = true;
            $erros['enderecos']['motivo'] = "Proponente não possui endereço cadastrado";

            return $erros;
        } else {
            $proponente = $proponente->fetchObject();
            $erros = ValidacaoModel::retornaMensagem($proponente, $naoObrigatorios);
        }
        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaTelefone($tipoProponente, $id) {
        if ($tipoProponente == 1) {
            $proponente = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$id'");
        } else {
            $proponente = DbModel::consultaSimples("SELECT * FROM pj_telefones WHERE pessoa_juridica_id = '$id'");
        }
        if ($proponente->rowCount() == 0) {
            $erros['telefones']['bol'] = true;
            $erros['telefones']['motivo'] = "Proponente não possui telefone cadastrado";

            return $erros;
        } else {
            $proponente = $proponente->fetchObject();
            $erros = ValidacaoModel::retornaMensagem($proponente);
        }
        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaRepresentante($id)
    {
        $representante = DbModel::getInfo('representante_legais', $id)->fetchObject();

        $erros = ValidacaoModel::retornaMensagem($representante);

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function retornaMensagem($dados, $camposNaoObrigatorios = false){
        $mensagens = [
            'nome_evento' => "Nome do evento não preenchido",
            'sinopse' => "Sinopse do evento não preenchida",
        ];

        if ($camposNaoObrigatorios) {
                foreach ($dados as $coluna => $valor) {
                    if (!in_array($coluna, $camposNaoObrigatorios)) {
                        if ($valor == "") {
                        $erros[$coluna]['bol'] = true;
                        $erros[$coluna]['motivo'] = $mensagens[$coluna];
                    }
                }
            }
        } else {
            foreach ($dados as $coluna => $valor) {
                if ($valor == "") {
                    $erros[$coluna]['bol'] = true;
                    $erros[$coluna]['motivo'] = $mensagens[$coluna];
                }
            }

        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }
}