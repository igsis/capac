<?php
if ($pedidoAjax) {
    require_once "../models/DbModel.php";
} else {
    require_once "./models/DbModel.php";
}

class MainModel extends DbModel
{
    /** <p> Verifica se o valor existe dentro de uma matriz</p>
     * @param mixed $needle
     * <p>Valor a ser procurado</p>
     * @param array $haystack
     * <p>Matriz onde sera procurado o valor</p>
     * @param bool $strict [opcional]
     * <p><strong>FALSE</strong> por padrão. Quando <strong>TRUE</strong>, verifica também se o tipo é igual</p>
     * @return bool
     * <p>Retorna <strong>TRUE</strong> se o valor é encontrado. Se não, retorna <strong>FALSE</strong></p>
     */
    protected function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }

    /**
     * <p>Encripta a mensagem usando o "openssl_encrypt"</p>
     * @param string $string
     * <p>Mensagem a ser encriptada</p>
     * @return string
     * <p>Retorna o valor já encriptado</p>
     */
    public function encryption($string) {
        $output = false;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    /**
     * <p>Decripta uma mensagem encriptada com a função "encryption"</p>
     * @param string $string
     * <p>Mensagem a ser decriptada</p>
     * @return string
     * <p>Retorna a mensagem decriptada</p>
     */
    protected function decryption($string) {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    /**
     * Insere registro na tabela "log" do banco de dados
     * @param string $descricao
     * <p>Registramos o comando SQL de <strong>UPDATE</strong> ou <strong>INSERT</strong>,
     * se o usuário <strong>FEZ LOGIN</strong>, ou <strong>FEZ LOGOUT</strong></p>
     */
    protected function gravarLog($descricao) {
        $dadosLog = [
            'usuario_id' => $_SESSION['idUsuario_c'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'data' => date('Y-m-d H:i:s'),
            'descricao' => $descricao
        ];

        DbModel::insert('log', $dadosLog);
    }

    /**
     * <p>Executa uma série de comandos de tratamento da string para inserção no banco de dados</p>
     * @param string $string
     * <p>Mensagem que será tratada</p>
     * @return mixed|string
     * <p>Retorna a mensagem já tratada</p>
     */
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
     * <p>Executa a função "limparString" em um array</p>
     * @param array $post
     * <p>Array de dados que deve ser tratado</p>
     * @return array
     * <p>Retorna os dados já tratados</p>
     */
    protected function limpaPost($post) {
        $dados = [];
        foreach ($post as $campo => $value) {
            $dados[$campo] = self::limparString($value);
        }
        return $dados;
    }

    /**
     * <p>Gera options para a tag <i>select</i> a partir dos registros de uma tabela</p>
     * @param string $tabela
     * <p>Nome da tabela que deve ser consultada</p>
     * @param string $selected [opcional]
     * <p>Valor a qual deve vir selecionado</p>
     * @param bool $publicado [opcional]
     * <p><strong>FALSE</strong> por padrão. Quando <strong>TRUE</strong>, busca valores onde a coluna <i>publicado</i> seja 1</p>
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

    /**
     *
     * @param string $tabela
     * @param string $tabelaRelacionamento
     * @param null|int $idEvento [opcional]
     * @param bool $publicado [opcional]
     */
    public function geraCheckbox($tabela, $tabelaRelacionamento, $idEvento = null, $publicado = false) {
        $publicado = $publicado ? "WHERE publicado = '1'" : "";
        $sql = "SELECT * FROM $tabela $publicado ORDER BY 2";
        $consulta = DbModel::consultaSimples($sql);

        // Parte do relacionamento
        $sqlConsultaRelacionamento = "SELECT * FROM $tabelaRelacionamento WHERE evento_id = '$idEvento'";
        $relacionamentos = DbModel::consultaSimples($sqlConsultaRelacionamento)->fetchAll();

        foreach ($consulta->fetchAll() as $checkbox) {
            ?>
                <div class='checkbox-grid-2'>
                    <div class='form-check'>
                        <input class='form-check-input <?=$tabela?>' type='checkbox' name='<?=$tabela?>[]' value='<?=$checkbox[0]?>' <?=self::in_array_r($checkbox[0], $relacionamentos) ? "checked" : ""?>>
                        <label class='form-check-label'><?=$checkbox[1]?></label>
                    </div>
                </div>
            <?php
        }
    }

    /**
     * <p>Exibe um alerta da Tanair</p>
     * @param array $dados
     * <p>Um array que deve conter os seguintes índices:</p>
     *  <li>alerta - deve conter os valores: <strong>simples</strong>, <strong>sucesso</strong> ou
     * <strong>limpar</strong></li>
     *  <li>titulo - Texto que será usado como título do alerta</li>
     *  <li>texto - Texto que será usado no corpo do alerta</li>
     *  <li>tipo - Tipo do alerta. Deve conter os valores: <strong>success</strong>, <strong>error</strong>,
     * <strong>warning</strong>, <strong>info</strong> ou <strong>question</strong></li>
     * <li>location - Caso o alerta seja <strong>sucesso</strong>, este índice deve conter a página para qual o usuário
     * será retornado</li>
     * @return string
     * <p>Retorna o alerta</p>
     */
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

    /**
     * Verifica a tabela de relacionamento passada e atualiza conforme os dados informados
     * @param string $tabela <p>Nome da tabela de relacionamento</p>
     * @param string $entidadeForte <p>Nome da coluna que representa a entidade forte <i>(tabela principal)</i></p>
     * @param int $idEntidadeForte <p>ID da entidade forte</p>
     * @param string $entidadeFraca <p>Nome da coluna que representa a entidade fraca <i>(tabela auxiliar)</i></p>
     * @param int|array $idsEntidadeFraca <p>Array com os IDs da entidade fraca</p>
     * @return bool
     */
    protected function atualizaRelacionamento($tabela, $entidadeForte, $idEntidadeForte, $entidadeFraca, $idsEntidadeFraca) {
        /* Consulta a tabela de relacionamento
        para verificar se existe algum registro
        para a entidade forte informada */
        $sqlConsultaRelacionamento = "SELECT $entidadeFraca FROM $tabela WHERE $entidadeForte = '$idEntidadeForte'";
        $relacionamento = DbModel::consultaSimples($sqlConsultaRelacionamento);

        /* Se não existe nenhum registro,apenas insere um para cada id de entidade fraca */
        if ($relacionamento->rowCount() == 0) {
            if (is_array($idsEntidadeFraca)) {
                foreach ($idsEntidadeFraca as $checkbox) {
                    $dadosInsert = [
                        $entidadeForte => $idEntidadeForte,
                        $entidadeFraca => $checkbox
                    ];
                    $insert = DbModel::insert($tabela, $dadosInsert);
                    if ($insert->rowCount() == 0) {
                        return false;
                    }
                }
            } else {
                $dadosInsert = [
                    $entidadeForte => $idEntidadeForte,
                    $entidadeFraca => $idsEntidadeFraca
                ];
                $insert = DbModel::insert($tabela, $dadosInsert);
                if ($insert->rowCount() == 0) {
                    return false;
                }
            }
            return true;
        } else {
            /* Se existe registros, primeiro, verifica se
            na tabela existe algum que não tenha sido
            passado nos IDs da entidade fraca.
            Cada registro que não possui ID passado é excluído */
            foreach ($relacionamento->fetchAll() as $item) {
                if (!in_array($item, $idsEntidadeFraca)) {
                    $delete = DbModel::consultaSimples("DELETE FROM $tabela WHERE $entidadeForte = '$idEntidadeForte' AND $entidadeFraca = $item");
                    if ($delete->rowCount() == 0) {
                        return false;
                    }
                }
            }

            /* Após excluir os registros que não possuem ID passado,
            verifica se dos IDs informados, existe algum que não
            tenha registro. Caso sim, insere um novo */
            foreach ($idsEntidadeFraca as $checkbox) {
                if (!in_array($checkbox, $relacionamento->fetchAll())) {
                    $dadosInsert = [
                        $entidadeForte => $idEntidadeForte,
                        $entidadeFraca => $checkbox
                    ];
                    $insertNovo = DbModel::insert($tabela, $dadosInsert);
                    if ($insertNovo->rowCount() == 0) {
                        return false;
                    }
                }
            }

            return true;
        }
    }
}