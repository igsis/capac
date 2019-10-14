<?php
require_once "./controllers/EventoController.php";
$eventoObj = new EventoController();
$evento = $eventoObj->recuperaEvento($_SESSION['origem_id_c']);

require_once "./controllers/AtracaoController.php";
$idAtracao = MainModel::encryption(DbModel::consultaSimples("SELECT id FROM atracoes WHERE evento_id = '$evento->id'"));
$atracaoObj = new AtracaoController();
$atracao = $atracaoObj->recuperaAtracao($idAtracao);

//$nome_evento = $sql['nome_evento'] ? $sql['nome_evento'] : "Prencha o campo";
//$espaco_publico = $sql['espaco_publico'] ? $sql['espaco_publico'] : "Preencha";
//$fomento = $sql['fomento'] ? $sql['fomento'] : "Preencha";
//$fomento_nome = $sql['nome_fomento'];

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Finalizar o Envio</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Dados do Evento</h5>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12"><b>Nome do evento:</b> <?= $evento->nome_evento ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><b>Espaço em que será realizado o evento é público?</b> <?php if ($evento->espaco_publico == 0): echo "Sim"; else: echo "Não"; endif;  ?></div>
                            <div class="col-md-6"><b>É fomento/programa?</b> <?= $evento->fomento ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Público (Representatividade e Visibilidade Sócio-cultural):</b> </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Sinopse:</b> <?= $evento->sinopse ?></div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12"><b>Nome da atração:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Ações (Expressões Artístico-culturais):</b> </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Ficha técnica completa:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Integrantes:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Classificação indicativa:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Release:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Links:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><b>Quantidade de Apresentação:</b> </div>
                            <div class="col-md-6"><b>Valor:</b> </div>
                        </div>

                        <hr>


                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#itens-proponente').addClass('menu-open');
        $('#finalizar').addClass('active');
    });
</script>