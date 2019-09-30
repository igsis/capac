<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
    define('UPLOADDIR', "../uploads/");
} else {
    require_once "./models/MainModel.php";
    define('UPLOADDIR', "./uploads/");
}

class ArquivoController extends MainModel
{
    public function recuperaIdListaDocumento($tipo_documento_id) {
        $sql = "SELECT id FROM lista_documentos WHERE tipo_documento_id = '$tipo_documento_id'";
        $lista_documento_id = DbModel::consultaSimples($sql);

        return $lista_documento_id;
    }
    public function listarArquivos($origem_id, $lista_documento_id) {
        $origem_id = MainModel::decryption($origem_id);
        $sql = "SELECT * FROM arquivos WHERE `origem_id` = '$origem_id' AND lista_documento_id = '$lista_documento_id' AND publicado = '1'";
        $arquivos = DbModel::consultaSimples($sql);

        return $arquivos;
    }

    public function enviarArquivo($origem_id, $lista_documento_id, $validacoes = [false, null]) {
        $origem_id = MainModel::decryption($origem_id);
        foreach ($_FILES as $file) {
            $numArquivos = count($file['error']);
            foreach ($file as $key => $dados) {
                for ($i = 0; $i < $numArquivos; $i++) {
                    $arquivos[$i][$key] = $file[$key][$i];
                }
            }
        }

        foreach ($arquivos as $key => $arquivo) {
            $erros[$key]['bol'] = false;
            if ($arquivo['error'] != 4) {
                $nomeArquivo = $arquivo['name'];
                $tamanhoArquivo = $arquivo['size'];
                $arquivoTemp = $arquivo['tmp_name'];
                $explode = explode('.', $nomeArquivo);
                $extensao = strtolower(end($explode));

                $dataAtual = date("Y-m-d H:i:s");
                $novoNome = date('YmdHis')."_".MainModel::retiraAcentos($nomeArquivo);
                $tamanhoMaximo = (7*1000)*1000;

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

        $erro = MainModel::in_array_r(true, $erros, true);

        if ($erro) {
            foreach ($erros as $erro) {
                if ($erro['bol']){
                    $lis[] = "'<li>" . $erro['arquivo'] . ": " . $erro['motivo'] . "</li>'";
                }
            }
            $alerta = [
                'alerta' => 'arquivos',
                'titulo' => 'Oops! Tivemos alguns Erros!',
                'texto' => $lis,
                'tipo' => 'error',
                'location' => SERVERURL . 'eventos/arquivos_com_prod'
            ];
        } else {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Arquivos Enviados!',
                'texto' => 'Arquivos enviados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'eventos/arquivos_com_prod'
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function apagarArquivo ($arquivo_id){
        $arquivo_id = MainModel::decryption($arquivo_id);
        $remover = DbModel::apaga('arquivos', $arquivo_id);
        if ($remover->rowCount() > 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Arquivo Apagado!',
                'texto' => 'Arquivo apagado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'eventos/arquivos_com_prod'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao remover o arquivo do servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }

        return MainModel::sweetAlert($alerta);
    }
}