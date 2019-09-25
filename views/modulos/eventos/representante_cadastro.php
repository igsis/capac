<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
require_once "./controllers/RepresentanteController.php";
$insRepresentante = new RepresentanteController();
$representante = $insRepresentante->recuperaRepresentante($id)->fetch();

if ($id) {
    $representante = $insRepresentante->recuperaRepresentante($id);
    if ($representante['cpf'] != "") {
        $documento = $representante['cpf'];
    } else {
        $documento = $representante['passaporte'];
    }
}

if (isset($_POST['cpf'])){
    $documento = $_POST['cpf'];
    $representante = $insRepresentante->getCPF($documento)->fetch();
    if ($representante['cpf'] != ''){
        $id = MainModel::encryption($representante['id']);
        $representante = $insRepresentante->recuperaRepresentante($id)->fetch();
        $documento = $representante['cpf'];
    }
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de representante legal</h1>
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
                        <h3 class="card-title">Dados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/representanteAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome: *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome completo" maxlength="70" value="<?= $representante['nome'] ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="rg">RG: </label>
                                    <input type="text" class="form-control" id="rg" name="rg" maxlength="20" value="<?= $representante['rg'] ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cpf">CPF: </label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $documento ?>" required readonly>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
