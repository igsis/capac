<?php
require_once "./controllers/EventoController.php";
$eventoObj = new EventoController();
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
                        <h5 class="m-0">Resumo dos Dados do Evento</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 border"><b>Nome do Evento:</b> Nome do Evento</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 border"><b>Espaço em que será realizado o evento é público?</b></div>
                            <div class="col-md-3 border"><b>Espaço em que será realizado o evento é público?</b></div>
                            <div class="col-md-5 border"><b>É fomento/programa?</b></div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 border"><b>Público (Representatividade e Visibilidade Sócio-cultural):</b></div>
                            <div class="col-md-7 border">Publico 1; Publico 2; Publico 3</b></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 border"><b>Sinopse:</b></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Resumo dos Dados do Proponente</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 border"><b>Nome do Evento:</b> Nome do Evento</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 border"><b>Espaço em que será realizado o evento é público?</b></div>
                            <div class="col-md-3 border"><b>Espaço em que será realizado o evento é público?</b></div>
                            <div class="col-md-5 border"><b>É fomento/programa?</b></div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 border"><b>Público (Representatividade e Visibilidade Sócio-cultural):</b></div>
                            <div class="col-md-7 border">Publico 1; Publico 2; Publico 3</b></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 border"><b>Sinopse:</b></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
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