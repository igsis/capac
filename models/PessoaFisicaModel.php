<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
} else {
    require_once "./models/ValidacaoModel.php";
}

class PessoaFisicaModel extends ValidacaoModel
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

                $validaBanco = ValidacaoModel::validaBanco(1, $pessoa_fisica_id);
                $validaEndereco = ValidacaoModel::validaEndereco(1, $pessoa_fisica_id);
                $validaTelefone = ValidacaoModel::validaTelefone(1, $pessoa_fisica_id);
                break;

            case 2:
                $naoObrigatorios = [
                    'nome_artistico',
                    'ccm',
                    'cpf',
                    'passaporte',
                ];

                $validaBanco = ValidacaoModel::validaBanco(1, $pessoa_fisica_id);
                $validaEndereco = ValidacaoModel::validaEndereco(1, $pessoa_fisica_id);
                $validaTelefone = ValidacaoModel::validaTelefone(1, $pessoa_fisica_id);
                break;
                break;
            default:
                $naoObrigatorios = [];
                break;
        }

        $erros = ValidacaoModel::retornaMensagem($pf, $naoObrigatorios);

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

        if ($validaTelefone) {
            if (!isset($erros)) { $erros = []; }
            $erros = array_merge($erros, $validaTelefone);
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }
}