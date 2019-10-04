<?php
require_once "./controllers/PedidoController.php";

$pedidoObj = new PedidoController()

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Proponente</h1>
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
                        <table class="table table-bordered table-striped">
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
                            <?php $proponente = $pedidoObj->recuperaPedido(2)  ?>
                                <tr>
                                    <td><?= $proponente->razao_social ?></td>
                                    <td><?= $proponente->cnpj ?></td>
                                    <td><?= $proponente->ccm ?></td>
                                    <td><?= $proponente->email ?></td>
                                    <td>
                                            <a href="<?=SERVERURL."eventos/evento_cadastro&key=".$_SESSION['evento_id_c'] ?>">
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</button>
                                            </a>
                                            <a href="#">
                                                <button class="btn btn-sm bg-purple"><i class="fas fa-retweet"></i> Trocar Proponente</button>
                                            </a>
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