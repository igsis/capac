<?php
require_once "./controllers/PessoaFisicaController.php";

$pfObjeto =  new PessoaFisicaController();

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $pf = $pfObjeto->recuperaPessoaFisicaFom($id);
    $documento = $pf['cpf'];
}

if (isset($_POST['pf_cpf'])){
    $documento = $_POST['pf_cpf'];
    $pf = $pfObjeto->getCPF($documento)->fetch();
    if ($pf){
        $id = (new MainModel)->encryption($pf['id']);
        $pf = $pfObjeto->recuperaPessoaFisicaFom($id);
        $documento = $pf['cpf'];
    }
}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pessoa Física</h1>
            </div><!-- /.col -->
            <?php
            if ($id) {
                ?>
                <div class="col-sm-6">
                    <button type="submit" data-toggle="modal" data-target="#modal-troca" class="btn btn-secondary float-right">Trocar Pessoa Física</button>
                </div><!-- /.col -->
                <?php
            }
            ?>
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
                        <h3 class="card-title">Dados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="<?= SERVERURL ?>ajax/projetoAjax.php" role="form"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="cadastrarPf">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col form-group">
                                    <label for="nome">Nome Completo:</label>
                                    <input type="text" class="form-control" name="nome" id="nome" value="<?= $pf['nome'] ?? '' ?>">
                                </div>
                                <div class="col form-group">
                                    <label for="cpf">CPF:</label>
                                    <input type="text" class="form-control" name="cpf" readonly value="<?= isset($_POST['cpf']) ?? $_POST['cpf'] ?>">
                                </div>
                                <div class="col form-group">
                                    <label for="rg">RG:</label>
                                    <input type="text" class="form-control" name="rg" value="<?= isset($_POST['rg']) ?? '' ?>">
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax"></div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<script type="text/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#nucleo_artistico').addClass('active');
    });
</script>