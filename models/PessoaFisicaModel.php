<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class PessoaFisicaModel extends MainModel
{
    protected function limparStringPF($dados) {
        unset($dados['_method']);
        unset($dados['pagina']);

        if(isset($dados['atracao_id'])){
            unset($dados['atracao_id']);
        }

        if (isset($dados['pedido_id_c'])){
            unset($dados['pedido_id_c']);
        }

        /* executa limpeza nos campos */

        foreach ($dados as $campo => $post) {
            $dig = explode("_",$campo)[0];
            if (!empty($dados[$campo])) {
                switch ($dig) {
                    case "pf":
                        $campo = substr($campo, 3);
                        $dadosLimpos['pf'][$campo] = MainModel::limparString($post);
                        break;
                    case "bc":
                        $campo = substr($campo, 3);
                        $dadosLimpos['bc'][$campo] = MainModel::limparString($post);
                        break;
                    case "en":
                        $campo = substr($campo, 3);
                        $dadosLimpos['en'][$campo] = MainModel::limparString($post);
                        break;
                    case "te":
                        if ($dados[$campo] != '') {
                            $dadosLimpos['telefones'][$campo]['telefone'] = MainModel::limparString($post);
                        }
                        break;
                    case "ni":
                        $campo = substr($campo, 3);
                        $dadosLimpos['ni'][$campo] = MainModel::limparString($post);
                        break;
                    case "dr":
                        $campo = substr($campo, 3);
                        $dadosLimpos['dr'][$campo] = MainModel::limparString($post);
                        break;
                    case "of":
                        $campo = substr($campo, 3);
                        $dadosLimpos['of'][$campo] = MainModel::limparString($post);
                        break;
                }
            }
        }

        return $dadosLimpos;
    }

    protected function validaPfBanco($pessoa_fisica_id) {
        $pf = DbModel::consultaSimples("SELECT * FROM pf_bancos WHERE pessoa_fisica_id = '$pessoa_fisica_id'");
        if ($pf->rowCount() == 0) {
            $erros['bancos']['bol'] = true;
            $erros['bancos']['motivo'] = "Proponente não possui conta bancária cadastrada";

            return $erros;
        } else {
            foreach ($pf->fetchObject() as $coluna => $valor) {
                if ($valor == "") {
                    $erros[$coluna]['bol'] = true;
                    $erros[$coluna]['motivo'] = "Campo " . $coluna . " não preechido";
                }
            }
        }
        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaPfEndereco($pessoa_fisica_id) {
        $pf = DbModel::consultaSimples("SELECT * FROM pf_enderecos WHERE pessoa_fisica_id = '$pessoa_fisica_id'");
        $naoObrigatorios = [
            'complemento'
        ];
        if ($pf->rowCount() == 0) {
            $erros['enderecos']['bol'] = true;
            $erros['enderecos']['motivo'] = "Proponente não possui endereço cadastrado";

            return $erros;
        } else {
            foreach ($pf->fetchObject() as $coluna => $valor) {
                if (!in_array($coluna, $naoObrigatorios)) {
                    if ($valor == "") {
                        $erros[$coluna]['bol'] = true;
                        $erros[$coluna]['motivo'] = "Campo " . $coluna . " não preechido";
                    }
                }
            }
        }
        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaPfTelefone($pessoa_fisica_id) {
        $pf = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$pessoa_fisica_id'");
        if ($pf->rowCount() == 0) {
            $erros['telefones']['bol'] = true;
            $erros['telefones']['motivo'] = "Proponente não possui telefone cadastrado";

            return $erros;
        } else {
            foreach ($pf->fetchAll(PDO::FETCH_OBJ) as $coluna => $valor) {
                if ($valor == "") {
                    $erros[$coluna]['bol'] = true;
                    $erros[$coluna]['motivo'] = "Campo " . $coluna . " não preechido";
                }
            }
        }
        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }
    
    /**
     * @param int $pessoa_fisica_id
     * @param int $validacaoTipo
     * <p>1 - Proponente<br>
     * 2 - Líder</p>
     * @return array|bool
     */
    protected function validaPfModel($pessoa_fisica_id, $validacaoTipo) {
        $pf = DbModel::getInfo("pessoa_fisicas",$pessoa_fisica_id)->fetchObject();

        switch ($validacaoTipo) {
            case 1:
                $naoObrigatorios = [
                    'nome_artistico',
                    'ccm',
                    'cpf',
                    'passaporte',
                ];

                $validaBanco = $this->validaPfBanco($pessoa_fisica_id);
                $validaEndereco = $this->validaPfEndereco($pessoa_fisica_id);
                $validaTelefone = $this->validaPfTelefone($pessoa_fisica_id);
                break;

            default:
                $naoObrigatorios = [];
                break;
        }


        foreach ($pf as $coluna => $valor) {
            if (!in_array($coluna, $naoObrigatorios)) {
                if ($valor == "") {
                    $erros[$coluna]['bol'] = true;
                    $erros[$coluna]['motivo'] = "Campo " . $coluna . " não preechido";
                }
            }
        }

        if ($validacaoTipo == 1) {
            if ($validaBanco) {
                if (!isset($erros)) { $erros = []; }
                $erros = array_merge($erros, $validaBanco);
            }
            if ($validaEndereco) {
                if (!isset($erros)) { $erros = []; }
                $erros = array_merge($erros, $validaEndereco);
            }
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }
}