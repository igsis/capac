<?php
if (isset($_SESSION['atracao_id_c'])) {
    $dados['atracao_referencia_id'] = $_SESSION['atracao_id_c'];
} elseif (isset($_POST['atracao_id'])) {
    $dados['atracao_referencia_id'] = $_SESSION['atracao_id_c'] = $_POST['atracao_id'];
} else {
    $dados['atracao_referencia_id'] = null;
}

$dados['tabela_referencia'] = "atracoes";
include "./views/template/produtor_cadastro_template.php";