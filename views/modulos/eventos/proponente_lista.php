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
                            <?php
                            if (isset($proponente)) {
                                $proponente = $pedidoObj->recuperaPedido(2)
                                ?>
                                <tr>
                                    <td><?= $proponente->razao_social ?></td>
                                    <td><?= $proponente->cnpj ?></td>
                                    <td><?= $proponente->ccm ?></td>
                                    <td><?= $proponente->email ?></td>
                                    <td>
                                        <div class="row">
                                            <form class="mr-md-3" method="post"
                                                  action="<?= SERVERURL ?>eventos/pj_cadastro">
                                                <input type="hidden" name="pj_cnpj" value="<?= $proponente->cnpj ?>">
                                                <button type="submit" class="btn btn-sm btn-primary"><i
                                                            class="fas fa-edit"></i> Editar
                                                </button>
                                            </form>
                                            <a href="<?= SERVERURL ?>eventos/proponente">
                                                <button class="btn btn-sm bg-purple"><i class="fas fa-retweet"></i>
                                                    Trocar
                                                    Proponente
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5" style="">
                                        <div class="row">
                                            <a class="mx-auto btn btn-success btn-sm"
                                               href="<?= SERVERURL ?>eventos/proponente">Adicionar proponente</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
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