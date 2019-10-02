<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}


class ArquivoModel extends MainModel
{
    protected function separaArquivos() {
        foreach ($_FILES as $file) {
            $numArquivos = count($file['error']);
            foreach ($file as $key => $dados) {
                for ($i = 0; $i < $numArquivos; $i++) {
                    $arquivos[$i][$key] = $file[$key][$i];
                }
            }
        }
        return $arquivos;
    }

    /**
     * @param $arquivos
     * @param $origem_id
     * @param $lista_documento_id
     * @param $tamanhoMaximo
     * @param $validaExtensao
     * @return mixed
     */
    protected function enviaArquivos($arquivos, $origem_id, $lista_documento_id, $tamanhoMaximo, $validaExtensao) {
        foreach ($arquivos as $key => $arquivo) {
            $erros[$key]['bol'] = false;
            if ($arquivo['error'] != 4) {
                $nomeArquivo = $arquivo['name'];
                $tamanhoArquivo = $arquivo['size'];
                $arquivoTemp = $arquivo['tmp_name'];
                $explode = explode('.', $nomeArquivo);
                $extensao = strtolower(end($explode));

                if ($validaExtensao[0] && $extensao != $validaExtensao[1]) {
                    $erros[$key]['bol'] = true;
                    $erros[$key]['motivo'] = "Arquivo em formato não aceito";
                    $erros[$key]['arquivo'] = $nomeArquivo;
                    continue;
                }

                $dataAtual = date("Y-m-d H:i:s");
                $novoNome = date('YmdHis')."_".MainModel::retiraAcentos($nomeArquivo);
                $tamanhoMaximo = ($tamanhoMaximo*1000)*1000;

                if ($tamanhoArquivo < $tamanhoMaximo) {
                    if (move_uploaded_file($arquivoTemp, UPLOADDIR . $novoNome)) {
                        $dadosInsertArquivo = [
                            'origem_id' => $origem_id,
                            'lista_documento_id' => $lista_documento_id,
                            'arquivo' => $novoNome,
                            'data' => $dataAtual
                        ];

                        $insertArquivo = DbModel::insert('arquivos', $dadosInsertArquivo);
                        if ($insertArquivo->rowCount() == 0) {
                            $erros[$key]['bol'] = true;
                            $erros[$key]['motivo'] = "Falha ao salvar na base de dados";
                            $erros[$key]['arquivo'] = $nomeArquivo;
                        }
                    } else {
                        $erros[$key]['bol'] = true;
                        $erros[$key]['motivo'] = "Falha ao enviar o arquivo ao servidor";
                        $erros[$key]['arquivo'] = $nomeArquivo;
                    }
                } else {
                    $erros[$key]['bol'] = true;
                    $erros[$key]['motivo'] = "Arquivo maior que o tamanho máximo permitido";
                    $erros[$key]['arquivo'] = $nomeArquivo;
                }
            }
        }
        return $erros;
    }
}