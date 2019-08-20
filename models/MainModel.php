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
            'usuario_id' => $_SESSION['usuario_cpc'],
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