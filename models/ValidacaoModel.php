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

    protected function validaDetalhes($idPf)
    {
        $proponente = DbModel::consultaSimples("SELECT * FROM pf_detalhes WHERE pessoa_fisica_id = '$idPf'");

        $naoObrigatorios = [
            'curriculo'
        ];
        if ($proponente->rowCount() == 0) {
            $erros['detalhes']['bol'] = true;
            $erros['detalhes']['motivo'] = "Cadastro de pesssoa física incompleto";

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

    /**
     * @param array $dados
     * @param bool|array $camposNaoObrigatorios
     * @return bool|array
     */
    protected function retornaMensagem($dados, $camposNaoObrigatorios = false){
        $mensagens = [
            'nome_evento' => "Nome do evento não preenchido",
            'sinopse' => "Sinopse do evento não preenchida",
            'representante_legal1_id' => "Empresa não possui Representante Legal cadastrado",
            'produtor_id' => "Atração não possui Produtor cadastrado"
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

    protected function validaArquivos($tipoDocumento, $origem_id){
        $sql = "SELECT ld.id, ld.documento, a.arquivo
                FROM lista_documentos AS ld
                LEFT JOIN (SELECT * FROM arquivos WHERE publicado = 1 AND origem_id = '$origem_id') AS a on ld.id = a.lista_documento_id
                WHERE ld.tipo_documento_id = '$tipoDocumento'";
        $arquivos = DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);

        foreach ($arquivos as $arquivo) {
            if ($arquivo->arquivo == null) {
                $erros[$arquivo->documento]['bol'] = true;
                $erros[$arquivo->documento]['motivo'] = $arquivo->documento." não enviado";
            }
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }
}