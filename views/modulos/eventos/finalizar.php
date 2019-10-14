<?php
require_once "./controllers/EventoController.php";
$eventoObj = new EventoController();
$idEvento = $_SESSION['origem_id_c'];
$evento = $eventoObj->recuperaEvento($idEvento);

require_once "./controllers/AtracaoController.php";
$atracaoObj = new AtracaoController();

$erro = "<span style=\"color: red; \"><b>Preenchimento obrigatório</b></span>";
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
                            <div class="col-md-6"><b>É fomento/programa?</b>
                                <?php
                                if($evento->fomento == 0){
                                    echo "Não";
                                } else{
                                    echo "Sim: ".$evento->fomento_nome;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Público (Representatividade e Visibilidade Sócio-cultural):</b>
                                <?php
                                foreach ($evento->publicos as $publico) {
                                    $sql = EventoController::listaPublicoEvento($publico);
                                    echo $sql['publico']."; ";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Sinopse:</b> <?= $evento->sinopse ?></div>
                        </div>

                        <hr>

                        <?php foreach ($atracaoObj->listaAtracoes($idEvento) as $atracao): ?>
                            <div class="row">
                                <div class="col-md-12"><b>Nome da atração:</b> <?= $atracao->nome_atracao ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"><b>Ações (Expressões Artístico-culturais):</b> </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"><b>Ficha técnica completa:</b> <?= $atracao->ficha_tecnica ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"><b>Integrantes:</b> <?= $atracao->integrantes ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"><b>Classificação indicativa:</b> </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"><b>Release:</b>  <?= $atracao->release_comunicacao ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"><b>Links:</b>  <?= $atracao->links ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><b>Quantidade de Apresentação:</b>  <?= $atracao->quantidade_apresentacao ?></div>
                                <div class="col-md-6"><b>Valor:</b> R$ <?= MainModel::dinheiroParaBr($atracao->valor_individual) ?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-4"><b>Produtor:</b>  <?= $atracao->produtor->nome ?? $erro ?></div>
                                <div class="col-md-4"><b>Telefone:</b>  <?= $atracao->produtor->telefone1 ?? $erro ?> / <?= $atracao->produtor->telefone2 ?? NULL ?></div>
                                <div class="col-md-4"><b>E-mail:</b>  <?= $atracao->produtor->email ?? $erro ?></div>
                            </div>
                            <hr>
                        <?php endforeach; ?>



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