<?php
require_once "./controllers/EventoController.php";

$eventos = new EventoController();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Eventos</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>eventos/evento_cadastro"><button class="btn btn-success btn-block">Adicionar</button></a>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Eventos Cadastrados</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código CAPAC</th>
                                    <th>Nome do Evento</th>
                                    <th>Data cadastro</th>
                                    <th>Enviado</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($eventos -> listaEvento("1") as $evento): ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><button class="btn">Abrir</button> </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Código CAPAC</th>
                                    <th>Nome do Evento</th>
                                    <th>Data cadastro</th>
                                    <th>Enviado</th>
                                    <th>Ação</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->