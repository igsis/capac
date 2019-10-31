<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class JovemMonitorController extends MainModel
{
    public function envioJovemMonitor($pagina,$idPf)
    {
        $idPf = MainModel::decryption($idPf);
        $dados = [
            'pessoa_fisica_id' => $idPf,
            'valido' => 0,
            'ativo' => 0,
            'data_cadastro' => date('Y-m-d'),
            'publicado' => 1
        ];

        $consulta = DbModel::consultaSimples("SELECT * FROM jm_cadastros WHERE pessoa_fisica_id ='$idPf'");
        if ($consulta ->rowCount()<1){
            DbModel::insert("jm_cadastros",$dados);
            if(DbModel::connection()->errorCode() == 0) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Jovem Monitor',
                    'texto' => 'Cadastro realizado com sucesso!<br><div class="row"><div class="offset-3 col-md-6"><a href="'.SERVERURL.'pdf/resumo_jm.php" class="btn btn-primary btn-block" target="_blank">Imprimir comprovante</a></div></div>',
                    'tipo' => 'success',
                    'location' => SERVERURL . '/inicio'
                ];
            } else{
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL . $pagina . '/finalizar'
                ];
            }
        }
        else{
            DbModel::updateEspecial("jm_cadastros", $dados,"pessoa_fisica_id",$idPf);
            if(DbModel::connection()->errorCode() == 0){
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Jovem Monitor',
                    'texto' => 'Cadastrado com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . $pagina . '/finalizar'
                ];
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL . $pagina . '/finalizar'
                ];
            }
        }
        return MainModel::sweetAlert($alerta);
    }
}