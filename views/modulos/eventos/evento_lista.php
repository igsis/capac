<?php
require_once "./controllers/EventoController.php";
if (isset($_SESSION['idEvento_c'])) {
    unset($_SESSION['idEvento_c']);
}

$eventoObj = new EventoController();
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
                                    <th>Tipo do Evento</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($eventoObj->listaEvento($_SESSION['idUsuario_c']) as $evento): ?>
                                <tr>
                                    <td><?=$evento->id?></td>
                                    <td><?=$evento->nome_evento?></td>
                                    <td><?=$eventoObj->dataParaBR($evento->data_cadastro)?></td>
                                    <td><?=$evento->publicado == 1 ? "Não" : "Sim"?></td>
                                    <td><?=$evento->tipo_contratacao?></td>
                                    <td>
                                        <?php if ($evento->publicado == 1): ?>
                                            <a href="<?=SERVERURL."eventos/evento_cadastro&key=".$eventoObj->encryption($evento->id)?>">
                                                <button class="btn btn-app"><i class="fas fa-edit"></i>Editar</button>
                                            </a>
                                            <button class="btn btn-app"><i class="fas fa-trash"></i>Apagar</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Código CAPAC</th>
                                    <th>Nome do Evento</th>
                                    <th>Data cadastro</th>
                                    <th>Enviado</th>
                                    <th>Tipo do Evento</th>
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