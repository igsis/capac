<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
} else {
    require_once "./models/ValidacaoModel.php";
}

class PessoaJuridicaModel extends ValidacaoModel
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

        $validaBanco = ValidacaoModel::validaBanco(2, $pessoa_juridica_id);
        $validaEndereco = ValidacaoModel::validaEndereco(2, $pessoa_juridica_id);
        $validaTelefone = ValidacaoModel::validaTelefone(2, $pessoa_juridica_id);

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