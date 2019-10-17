<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class PessoaJuridicaModel extends MainModel
{
    protected function limparStringPJ($dados) {
        unset($dados['_method']);
        unset($dados['pagina']);
        /* executa limpeza nos campos */

        foreach ($dados as $campo => $post) {
            $dig = explode("_",$campo)[0];
            if (!empty($dados[$campo])) {
                switch ($dig) {
                    case "pj":
                        $campo = substr($campo, 3);
                        $dadosLimpos['pj'][$campo] = MainModel::limparString($post);
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
                    case "of":
                        $campo = substr($campo, 3);
                        $dadosLimpos['of'][$campo] = MainModel::limparString($post);
                        break;
                }
            }
        }

        return $dadosLimpos;
    }

    protected function validaPjBanco($pessoa_juridica_id) {
        $pf = DbModel::consultaSimples("SELECT * FROM pj_bancos WHERE pessoa_juridica_id = '$pessoa_juridica_id'");
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

    protected function validaPjEndereco($pessoa_juridica_id) {
        $pf = DbModel::consultaSimples("SELECT * FROM pj_enderecos WHERE pessoa_juridica_id = '$pessoa_juridica_id'");
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

    protected function validaPjTelefone($pessoa_juridica_id) {
        $pf = DbModel::consultaSimples("SELECT * FROM pj_telefones WHERE pessoa_juridica_id = '$pessoa_juridica_id'");
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

    protected function validaRepresentante($id)
    {
        $representante = DbModel::getInfo('representante_legais', $id)->fetchObject();

        foreach ($representante as $coluna => $valor) {
            if ($valor == "") {
                $erros[$coluna]['bol'] = true;
                $erros[$coluna]['motivo'] = "Campo " . $coluna . " não preechido";
            }
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaPjModel($pessoa_juridica_id) {
        $pj = DbModel::getInfo('pessoa_juridicas', $pessoa_juridica_id)->fetchObject();
        $naoObrigatorios = [
            'ccm'
        ];

        foreach ($pj as $coluna => $valor) {
            if (!in_array($coluna, $naoObrigatorios)) {
                if ($valor == "") {
                    $erros[$coluna]['bol'] = true;
                    $erros[$coluna]['motivo'] = "Campo " . $coluna . " não preechido";
                }
            }
        }

        $validaBanco = $this->validaPjBanco($pessoa_juridica_id);
        $validaEndereco = $this->validaPjEndereco($pessoa_juridica_id);
        $validaTelefone = $this->validaPjTelefone($pessoa_juridica_id);

        if ($validaBanco) {
            if (!isset($erros)) { $erros = []; }
            $erros = array_merge($erros, $validaBanco);
        }
        if ($validaEndereco) {
            if (!isset($erros)) { $erros = []; }
            $erros = array_merge($erros, $validaEndereco);
        }
        if ($validaTelefone) {
            if (!isset($erros)) { $erros = []; }
            $erros = array_merge($erros, $validaTelefone);
        }


        if ($pj->representante_legal1_id != null){
            $representanteLegal1 = $this->validaRepresentante($pj->representante_legal1_id);
            if ($representanteLegal1) {
                if (!isset($erros)) { $erros = []; }
                $erros = array_merge($erros, $representanteLegal1);
            }
        }

        if ($pj->representante_legal2_id != null){
            $representanteLegal2 = $this->validaRepresentante($pj->representante_legal2_id);
            if ($representanteLegal2) {
                if (!isset($erros)) { $erros = []; }
                $erros = array_merge($erros, $representanteLegal2);
            }
        }


        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }
}