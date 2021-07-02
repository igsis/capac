<?php
$id = isset($_GET['idC']) ? $_GET['idC'] : null;
require_once "./controllers/FormacaoController.php";
$formObj = new FormacaoController();

$ano = $_SESSION['ano_c'];

if ($id) {
    $form = $formObj->recuperaFormacao($ano, false, $id);
    $idPf = $_SESSION['origem_id_c'];
    $form = $formObj->recuperaFormacao($ano, $idPf);
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dados complementares</h1>
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
                        <h3 class="card-title">Ano de execução do serviço:</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="ano" value="<?= $_SESSION['ano_c'] ?>">
                        <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id_c'] ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col">
                                    <label for="programa_id">Programa: *</label>
                                    <select class="form-control" id="programa" name="programa_id" required readonly>
                                        <?php
                                        $formObj->geraOpcaoProgramas($form->programa_id ?? "", true);
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col">
                                    <label for="">Função: *</label>
                                    <select class="form-control" name="form_cargo_id" required>
                                        <option value="">Selecione...</option>
                                        <?php
                                        $formObj->geraOpcaoCargosPiapi($form->form_cargo_id ?? "");
                                        ?>
                                    </select>
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

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#programa').addClass('active');
    })
</script>