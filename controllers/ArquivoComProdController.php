<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class ArquivoComProdController extends MainModel
{
    public function enviarArquivo($dados, $origem_id, $lista_documento_id) {
        foreach ($_FILES as $file) {
            $numArquivos = count($file['errors']);
            foreach ($file as $key => $dados) {
                for ($i = 0; $i < $numArquivos; $i++) {
                $arquivos[$i][$key] = $file[$key][$i];
                }
            }
        }

        foreach ($arquivos as $arquivo) {
            if ($arquivo['error'] != 4) {
                $nomeArquivo = $arquivo['name'];
                $tamanhoArquivo = $arquivo['size'];
                $arquivoTemp = $arquivo['tmp_name'];
                $extensao = strtolower(end(explode('.', $arquivo['name'])));

                $dataAtual = date("Y-m-d H:i:s");
                $novoNome = date('YmaHis') . MainModel::retiraAcentos($nomeArquivo);

                if (move_uploaded_file($arquivoTemp, UPLOADDIR.$novoNome)) {
                    $dadosInsertArquivo = [
                        'origem_id' => $origem_id,
                        'lista_documento_id' => $lista_documento_id,
                        'arquivo' => $novoNome,
                        'data' => $dataAtual
                    ];

                    $insertArquivo = DbModel::insert('arquivos', $dadosInsertArquivo);
                    if ($insertArquivo->rowCount() > 0) {
                        $alerta = [
                            'alerta' => 'sucesso',
                            'titulo' => 'Atração Cadastrada!',
                            'texto' => 'Dados cadastrados com sucesso!',
                            'tipo' => 'success',
                            'location' => SERVERURL . 'eventos/atracao_cadastro&key=' . MainModel::encryption($atracao_id)
                        ];
                    }
                }
            }
        }

        return $alerta;
    }

    public function apagarArquivo ($dados){
        if (isset($_POST['apagar'])) {
            $idArquivo = $_POST['idArquivo'];
            $sql_apagar_arquivo = "UPDATE arquivos SET publicado = 0 WHERE id = '$idArquivo'";
            if (mysqli_query($con, $sql_apagar_arquivo)) {
                $arq = recuperaDados("arquivos", $idArquivo, "id");
                $mensagem = mensagem("success", "Arquivo " . $arq['arquivo'] . "apagado com sucesso!");
                gravarLog($sql_apagar_arquivo);
            } else {
                $mensagem = mensagem("danger", "Erro ao apagar o arquivo. Tente novamente!");
            }
        }
    }
}