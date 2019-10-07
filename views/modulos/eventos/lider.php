<?php
require_once "./controllers/LiderController.php";
$evento_id = $_SESSION['evento_id_c'];
$atracaoObj = new LiderController();
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
                                <th>Produtor</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
<!--                            <tbody>-->
                            <?php foreach ($atracaoObj->listaAtracaoProponente as $atracao): ?>
                                <tr>
                                    <td><?=$atracao->nome_atracao?></td>
                                    <td>
                                        <?php if (!$atracao->produtor_id): ?>
                                            <form action="<?=SERVERURL."eventos/produtor_cadastro"?>" method="post">
                                                <input type="hidden" name="atracao_id" value="<?=$atracaoObj->encryption($atracao->id)?>">
                                                <button type="submit" class="btn btn-app"><i class="fas fa-plus"></i>Adicionar Produtor</button>
                                            </form>
                                        <?php else: ?>
                                            <a href="<?=SERVERURL."eventos/lider_cadastro&key=".$atracaoObj->encryption($atracao->lider_id)?>">
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> <?=$atracao->lider->nome?></button>
                                            </a>
                                        <?php endif; ?>

                                    </td>
                                    <td>
                                        <a href="<?=SERVERURL."eventos/atracao_cadastro&key=".$atracaoObj->encryption($atracao->id)?>">
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
                                <th>Produtor</th>
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

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#atracao_lista').addClass('active');
    })
</script>