<?php
if ($pedidoAjax) {
    require_once "../models/DbModel.php";
} else {
    require_once "./models/DbModel.php";
}

class MainModel extends DbModel
{
    public function encryption($string) {
        $output = false;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    protected function decryption($string) {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    protected function gravarLog($descricao) {
        $dadosLog = [
            'usuario_id' => $_SESSION['idUsuario_c'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'data' => date('Y-m-d H:i:s'),
            'descricao' => $descricao
        ];

        DbModel::insert('log', $dadosLog);
    }

    protected function limparString($string) {
        $string = trim($string);
        $string = stripslashes($string);
        $string = str_ireplace("<script>", "", $string);
        $string = str_ireplace("</script>", "", $string);
        $string = str_ireplace("<script src", "", $string);
        $string = str_ireplace("<script type=", "", $string);
        $string = str_ireplace("SELECT * FROM", "", $string);
        $string = str_ireplace("DELETE FROM", "", $string);
        $string = str_ireplace("INSERT INTO", "", $string);
        $string = str_ireplace("--", "", $string);
        $string = str_ireplace("^", "", $string);
        $string = str_ireplace("[", "", $string);
        $string = str_ireplace("]", "", $string);
        $string = str_ireplace("==", "", $string);

        return $string;
    }

    /**
     * @param array $post
     * @return array
     */
    protected function limpaPost($post) {
        $dados = [];
        foreach ($post as $campo => $value) {
            $dados[$campo] = self::limparString($value);
        }
        return $dados;
    }

    /**
     * <p>Função criada para gerar automáticamente options para a tag 'select'</p>
     * @param string $tabela
     * <p>Nome da tabela que deve ser consultada</p>
     * @param string $selected [opcional]
     * <p>Valor a qual deve vir selecionado</p>
     * @param bool $publicado [opcional]
     * <p>Caso a tabela utilize a coluna "publicado", o valor deve ser true</p>
     */
    public function geraOpcao($tabela, $selected = "", $publicado = false) {
        $publicado = $publicado ? 'WHERE publicado = 1' : '';
        $sql = "SELECT * FROM $tabela $publicado ORDER BY 2";
        $consulta = DbModel::consultaSimples($sql);
        if ($consulta->rowCount() >= 1) {
            foreach ($consulta->fetchAll() as $option) {
                if ($option[0] == $selected) {
                    echo "<option value='" . $option[0] . "' selected >" . $option[1] . "</option>";
                } else {
                    echo "<option value='" . $option[0] . "'>" . $option[1] . "</option>";
                }
            }
        }
    }

    public function geraCheckbox() {
        //
    }

    protected function sweetAlert($dados) {
        if ($dados['alerta'] == "simples") {
            $alerta = "
                    <script>
                        Swal.fire(
                            '{$dados['titulo']}',
                            '{$dados['texto']}',
                            '{$dados['tipo']}'
                        );
                    </script>
                ";
        } elseif ($dados['alerta'] == "sucesso") {
            $alerta = "
                    <script>
                        Swal.fire({
                          title: '{$dados['titulo']}',
                          text: '{$dados['texto']}',
                          type: '{$dados['tipo']}',
                          allowOutsideClick: false,
                            allowEscapeKey: false,
                            showCancelButton: false,
                          confirmButtonText: 'Confirmar'
                        }).then(function() {
                          window.location.href = '{$dados['location']}';
                        });
                    </script>
                ";
        } elseif ($dados['alerta'] == "limpar") {
            $alerta = "
                    <script>
                        Swal.fire({
                          title: '{$dados['titulo']}',
                          text: '{$dados['texto']}',
                          type: '{$dados['tipo']}',
                          confirmButtonText: 'Confirmar'
                        }).then(function() {
                          $('.FormularioAjax')[0].reset;
                        });
                    </script>
                ";
        }

        return $alerta;
    }
}