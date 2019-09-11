<?php
require_once "./controllers/AtracaoController.php";
if (isset($_SESSION['idAtracao_c'])) {
    unset($_SESSION['idAtracao_c']);
}

$evento_id = $_SESSION['idEvento_c'];

$atracaoObj = new AtracaoController();
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
                        <h3 class="card-title">Atrações Cadastrados</h3>
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
                            <tbody>
                                <?php foreach ($atracaoObj->listaAtracoes($evento_id) as $atracao): ?>
                                <tr>
                                    <td><?=$atracao->nome_atracao?></td>
                                    <td></td>
                                    <td>
                                        <a href="<?=SERVERURL."eventos/atracao_cadastro&key=".$atracaoObj->encryption($atracao->id)?>">
                                            <button class="btn btn-app"><i class="fas fa-edit"></i>Editar</button>
                                        </a>
                                        <button class="btn btn-app"><i class="fas fa-trash"></i>Apagar</button>
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