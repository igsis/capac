<?php
require_once "./controllers/LiderController.php";
$atracaoObj = new LiderController();

$evento_id = $_SESSION['evento_id_c'];
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Eventos</h1>
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
                        <h3 class="card-title">Atrações Cadastradas</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nome da Atração</th>
                                <th>Líder</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
<!--                            <tbody>-->
                            <?php foreach ($atracaoObj->listaAtracaoProponente() as $atracao): ?>
                                <tr>
                                    <td><?=$atracao->nome_atracao?></td>
                                    <td>
                                        <?php if (!$atracao->pessoa_fisica_id): ?>

                                                <button id="btn-atracao" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-default" data-atracao="<?=$atracao->atracao_id?>"><i class="fas fa-plus"></i> Adicionar</button>

                                        <?php else: ?>
                                            <a href="<?=SERVERURL."eventos/lider_cadastro&key=".$atracaoObj->encryption($atracao->lider_id)?>">
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> <?=$atracao->lider->nome?></button>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?=SERVERURL."eventos/atracao_cadastro&key=".$atracaoObj->encryption($atracao->atracao_id)?>">
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</button>
                                        </a>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Apagar</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nome da Atração</th>
                                    <th>Líder</th>
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

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pessoa Física</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-tabs" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="vert-tabs-cpf-tab" data-toggle="pill" href="#vert-tabs-cpf" role="tab" aria-controls="vert-tabs-cpf" aria-selected="true">CPF</a>
                        <a class="nav-link" id="vert-tabs-passaporte-tab" data-toggle="pill" href="#vert-tabs-passaporte" role="tab" aria-controls="vert-tabs-passaporte" aria-selected="false">Passaporte</a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane fade show active" id="vert-tabs-cpf" role="tabpanel" aria-labelledby="vert-tabs-cpf-tab">
                            <div class="modal-body">
                                <label for="cpf">CPF:</label>
                                <form class="form-horizontal" method="POST" action="<?= SERVERURL ?>eventos/lider_cadastro" role="form">
                                    <div class="row">
                                        <input type="hidden" name="atracao_id" id="atracao_id">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="pf_cpf">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-passaporte" role="tabpanel" aria-labelledby="vert-tabs-passaporte-tab">
                            Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    $('#modal-default').on('show.bs.modal', function (e)
    {
        let atracao_id = $(e.relatedTarget).attr('data-atracao');
        $("#atracao_id").attr("value", atracao_id);
    });
</script>

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#lider').addClass('active');
    })
</script>