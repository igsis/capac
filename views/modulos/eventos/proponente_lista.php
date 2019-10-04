<?php
require_once "./controllers/PedidoController.php";

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Proponente</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>eventos/proponente"><button class="btn btn-success btn-block">Adicionar</button></a>
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
                        <h3 class="card-title">Proponentes Cadastrados</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Razão social</th>
                                    <th>CNPJ</th>
                                    <th>CCM</th>
                                    <th>E-mail</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>xxxxxxxx</td>
                                    <td>xxxxxxxxxxxxx</td>
                                    <td>xxxxxxxxxxxxxxx</td>
                                    <td>xxxxxxxxxxxxx</td>
                                    <td>
                                            <a href="#">
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</button>
                                            </a>
                                            <a href="#">
                                                <button class="btn btn-sm bg-purple"><i class="fas fa-retweet"></i> Trocar Proponente</button>
                                            </a>
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Apagar</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Razão social</th>
                                    <th>CNPJ</th>
                                    <th>CCM</th>
                                    <th>E-mail</th>
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
        $('#itens-proponente').addClass('menu-open');
        $('#proponentes-cadastrados').addClass('active');
    })
</script>