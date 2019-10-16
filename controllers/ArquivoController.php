<?php
if ($pedidoAjax) {
    require_once "../models/ArquivoModel.php";
    define('UPLOADDIR', "../uploads/");
} else {
    require_once "./models/ArquivoModel.php";
    define('UPLOADDIR', "./uploads/");
}

class ArquivoController extends ArquivoModel
{
    public function recuperaIdListaDocumento($tipo_documento_id) {
        $sql = "SELECT id FROM lista_documentos WHERE tipo_documento_id = '$tipo_documento_id'";
        $lista_documento_id = DbModel::consultaSimples($sql);

        return $lista_documento_id;
    }

    public function listarArquivos($tipo_documento_id) {
        $sql = "SELECT * FROM lista_documentos WHERE tipo_documento_id = '$tipo_documento_id' AND publicado = '1'";
        $arquivos = DbModel::consultaSimples($sql);

        return $arquivos;
    }

    public function listarArquivosEnviadosComProd($origem_id) {
        $origem_id = MainModel::decryption($origem_id);
        $sql = "SELECT * FROM arquivos WHERE `origem_id` = '$origem_id' AND lista_documento_id = '1' AND publicado = '1'";
        $arquivos = DbModel::consultaSimples($sql);

        return $arquivos;
    }

    public function enviarArquivoComProd($origem_id) {
        $origem_id = MainModel::decryption($origem_id);
        $arquivos = ArquivoModel::separaArquivosComProd();
        $erros = ArquivoModel::enviaArquivos($arquivos, $origem_id, 15);
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

    public function listarArquivosEnviados($origem_id, $lista_documentos_ids) {
        $origem_id = MainModel::decryption($origem_id);
        $documentos = implode(", ", $lista_documentos_ids);
        $sql = "SELECT a.id, a.arquivo, a.data, ld.documento FROM arquivos AS a INNER JOIN lista_documentos AS ld on a.lista_documento_id = ld.id WHERE `origem_id` = '$origem_id' AND lista_documento_id IN ($documentos) AND a.publicado = '1'";
        $arquivos = DbModel::consultaSimples($sql);

        return $arquivos;
    }

    public function enviarArquivo($origem_id, $pagina) {
        unset($_POST['pagina']);
        $origem_id = MainModel::decryption($origem_id);
        foreach ($_FILES as $key => $arquivo){
            $_FILES[$key]['lista_documento_id'] = $_POST[$key];
        }
        $erros = ArquivoModel::enviaArquivos($_FILES, $origem_id,8, true);
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
                'location' => SERVERURL . 'eventos/'.$pagina
            ];
        } else {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Arquivos Enviados!',
                'texto' => 'Arquivos enviados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'eventos/'.$pagina
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function apagarArquivo ($arquivo_id, $pagina){
        $arquivo_id = MainModel::decryption($arquivo_id);
        $remover = DbModel::apaga('arquivos', $arquivo_id);
        if ($remover->rowCount() > 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Arquivo Apagado!',
                'texto' => 'Arquivo apagado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'eventos/'.$pagina
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

    public function consultaArquivoEnviado($lista_documento_id, $origem_id)
    {
        $origem_id = MainModel::decryption($origem_id);
        $sql = "SELECT * FROM arquivos WHERE lista_documento_id = '$lista_documento_id' AND origem_id = '$origem_id' AND publicado = '1'";
        $arquivo = DbModel::consultaSimples($sql)->rowCount();
        return $arquivo > 0 ? true : false;
    }
}