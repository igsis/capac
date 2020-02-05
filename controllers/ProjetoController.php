<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
    require_once "../models/ProjetoModel.php";
} else {
    require_once "./models/MainModel.php";
    require_once "./models/ProjetoModel.php";
}

class ProjetoController extends ProjetoModel
{
    public function listaProjetos($usuario_id, $edital_id){
        $usuario_id = MainModel::decryption($usuario_id);
        $edital_id = MainModel::decryption($edital_id);
        $sql = "SELECT fe.titulo, fp.* FROM fom_projetos AS fp
                INNER JOIN  fom_editais AS fe ON fp.fom_edital_id = fe.id
                WHERE fom_edital_id = '$edital_id' AND usuario_id = '$usuario_id' AND fp.publicado = 1";
        $consultaEvento = DbModel::consultaSimples($sql);
        return $consultaEvento->fetchAll(PDO::FETCH_OBJ);
    }

    public function insereProjeto($post){
        session_start(['name' => 'cpc']);
        /* executa limpeza nos campos */
        unset($post['_method']);
        unset($post['modulo']);
        unset($post['pagina']);
        $dados['fom_edital_id'] = MainModel::decryption($_SESSION['edital_c']);
        $dados['pessoa_juridica_id'] = MainModel::decryption($_SESSION['origem_id_c']);
        $dados['fom_status_id'] = 1;
        foreach ($post as $campo => $valor) {
            if ($campo != "modulo") {
                if ($campo == 'valor_projeto'){
                    $valor = MainModel::dinheiroDeBr($valor);
                }
                $dados[$campo] = MainModel::limparString($valor);
            }
        }
        /* ./limpeza */

        /* cadastro */
        $insere = DbModel::insert('fom_projetos', $dados);
        if ($insere->rowCount() >= 1) {
            $projeto_id = DbModel::connection()->lastInsertId();
            $_SESSION['projeto_c'] = MainModel::encryption($projeto_id);
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto Cadastrado!',
                'texto' => 'Projeto cadastrado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'fomentos/projeto_cadastro&id=' . MainModel::encryption($projeto_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaProjeto($post, $id){
        $id = MainModel::decryption($id);
        unset($post['_method']);
        unset($post['modulo']);
        unset($post['id']);
        unset($post['pagina']);
        $dados = [];
        foreach ($post as $campo => $valor) {
            if ($campo != "pagina") {
                if ($campo == 'valor_projeto'){
                    $valor = MainModel::dinheiroDeBr($valor);
                }
                $dados[$campo] = MainModel::limparString($valor);
            }
        }

        $edita = DbModel::update('fom_projetos', $dados, $id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto Atualizado',
                'texto' => 'Projeto editado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'fomentos/projeto_cadastro&id='.MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'fomentos/projeto_cadastro&id='.MainModel::encryption($id)
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
    public function recuperaProjeto($id) {
        $id = MainModel::decryption($id);
        return DbModel::getInfo('fom_projetos',$id)->fetch(PDO::FETCH_ASSOC);
    }

    public function recuperaProjetoCompleto($id) {
        $id = MainModel::decryption($id);
        return DbModel::consultaSimples("SELECT * 
            FROM fom_projetos fp
            INNER JOIN fom_editais fe on fp.fom_edital_id = fe.id
            INNER JOIN fom_status fs on fp.fom_status_id = fs.id
            LEFT JOIN pessoa_juridicas pj on fp.pessoa_juridica_id = pj.id
            LEFT JOIN pessoa_fisicas pf on fp.pessoa_fisica_id = pf.id
            INNER JOIN usuarios u on fp.usuario_id = u.id
            WHERE fp.id = '$id'
        ")->fetch(PDO::FETCH_ASSOC);
    }

    public function recuperaStatusProjeto($id){
        return DbModel::consultaSimples("SELECT status
        FROM fom_status
        WHERE id = '$id'")->fetchColumn();
    }

    public function finalizarProjeto($id){
        session_start(['name' => 'cpc']);

        $projetoId = MainModel::encryption($id);
        $projeto = $this->recuperaProjeto($projetoId);
        $projeto['protocolo'] = MainModel::gerarProtocolo($id,$_SESSION['edital_c']);
        $projeto['data_inscricao'] = date("Y-m-d h:i:sa");
        $projeto['fom_status_id'] = 2;

        $update = DbModel::update('fom_projetos',$projeto,$id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto Enviado',
                'texto' => 'Projeto enviado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'fomentos/finalizar',
                'redirecionamento' => SERVERURL.'pdf/resumo_fomento.php?id='.$projetoId
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao enviar o projeto!',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function apagaProjeto($id){
        $apaga = DbModel::apaga("fom_projetos", $id);
        if ($apaga){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto',
                'texto' => 'Projeto apagado com sucesso!',
                'tipo' => 'danger',
                'location' => SERVERURL.'fomentos/projeto_lista'
            ];
        }else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
    public function validaProjeto($projeto_id, $edital_id){
        $edital_id = MainModel::decryption($edital_id);
        $projeto_id = MainModel::decryption($projeto_id);

       $erros['arquivos'] = ProjetoModel::validaArquivosProjeto($projeto_id, $edital_id);

       return MainModel::formataValidacaoErros($erros);
    }



}