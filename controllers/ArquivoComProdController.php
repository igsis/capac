<?php


class ArquivoComProdController extends MainModel
{
    public function enviarArquivo($dados) {

        foreach ($_FILES as $key => $arquivo) {

            foreach ($arquivo as $key => $dados) {

                for ($i = 0; $i < sizeof($dados); $i++) {
                $arquivos[$i][$key] = $arquivo[$key][$i];
                }
            }
        }
        $i = 1;

        foreach ($arquivos as $file) {
            if ($file['name'] != "") {
                $y = 107;
                $x = $key;
                $nome_arquivo = isset($file['name']) ? $file['name'] : null;
                $f_size = isset($file['size']) ? $file['size'] : null;

                if ($f_size > 600000) {
                    $mensagem = mensagem("danger", "<strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 0,6 MB.</strong>");
                } else {
                    if ($nome_arquivo != "") {
                        $nome_temporario = $file['tmp_name'];
                        $new_name = date("YmdHis") . "_" . semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
                        $hoje = date("Y-m-d H:i:s");
                        $dir = '../uploadsdocs/'; //Diretório para uploads
                        $ext = strtolower(substr($nome_arquivo, -4));

                        if (move_uploaded_file($nome_temporario, $dir . $new_name)) {
                            $sql_insere_arquivo = "INSERT INTO `arquivos` (`origem_id`, `lista_documento_id`, `arquivo`, `data`, `publicado`) VALUES ('$idEvento', '$y', '$new_name', '$hoje', '1')";

                            if (mysqli_query($con, $sql_insere_arquivo)) {
                                $mensagem = mensagem("success", "Arquivo recebido com sucesso");
                                echo "<script>
                                        swal('Clique nos arquivos após efetuar o upload e confira a exibição do documento!', '', 'warning');                             
                                    </script>";
                                gravarLog($sql_insere_arquivo);
                            } else {
                                $mensagem = mensagem("danger", "Erro ao gravar no banco");
                            }
                        } else {
                            $mensagem = mensagem("danger", "Erro no upload");
                        }
                    }
                }
            }
        }
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