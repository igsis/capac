<?php
require_once "./controllers/ProjetoController.php";
require_once "./controllers/FomentoController.php";

$fomentoObj = new FomentoController();
$projetoObj = new ProjetoController();

$nomeEdital = $fomentoObj->recuperaNomeEdital($_SESSION['edital_c']);
$projetos = $projetoObj->listaProjetos();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Núcleo artístico <a href="" class="btn btn-sm btn-primary"><i class="fas fa-info"></i></a></h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>fomentos/projeto_cadastro"><button class="btn btn-success btn-block">Adicionar</button></a>
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
                        <h3 class="card-title">Cadastrados</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>RG</th>
                                <th>CPF</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Lorelei Gabriele Castro Lourenço</td>
                                <td>00.000.000-0</td>
                                <td>000.0000.000-00</td>
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <a href="" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                        </div>
                                        <div class="col">
                                            <form class="form-horizontal formulario-ajax" method="POST" action="" role="form" data-form="delete">
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>
                                                    Apagar
                                                </button>
                                                <div class="resposta-ajax"></div>
                                            </form>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>Qwerty da Silva Rodrigues Siqueira</td>
                                <td>11.111.111-1</td>
                                <td>111.111.111-11</td>
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <a href="" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                        </div>
                                        <div class="col">
                                            <form class="form-horizontal formulario-ajax" method="POST" action="" role="form" data-form="delete">
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>
                                                    Apagar
                                                </button>
                                                <div class="resposta-ajax"></div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>RG</th>
                                <th>CPF</th>
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
        $('#nucleo_artistico').addClass('active');
    })
</script>