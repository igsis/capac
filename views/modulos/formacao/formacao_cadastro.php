<?php
$id = isset($_GET['idC']) ? $_GET['idC'] : null;
require_once "./controllers/FormacaoController.php";
$formObj = new FormacaoController();

$idPf = $_SESSION['origem_id_c'];
$form = $formObj->recuperaFormacao($idPf)->fetch();
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
                        <h3 class="card-title">Ano de execução so serviço:</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="ano" value="<?= "2000" ?>">
                        <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id_c'] ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col">
                                    <label for="regiao_preferencial_id">Região preferencial: *</label>
                                    <select class="form-control" id="regiao_preferencial_id" name="regiao_preferencial_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formObj->geraOpcao("form_regioes_preferenciais",$form['regiao_preferencial_id']);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="programa_id">Programa: *</label>
                                    <select class="form-control" id="programa_id" name="programa_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formObj->geraOpcao("form_programas",$form['programa_id']);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="linguagem_id">Linguagem: *</label>
                                    <select class="form-control" id="linguagem_id" name="linguagem_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formObj->geraOpcao("form_linguagens",$form['linguagem_id']);
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col">
                                    <label for="">Função (1ª opção): *</label>

                                </div>
                                <div class="form-group col">
                                    <label for="">Função (2ª opção): *</label>

                                </div>
                                <div class="form-group col">
                                    <label for="">Função (3ª opção): *</label>

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


<script src="../views/dist/js/cep_api.js"></script>

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#programa').addClass('active');
    })
</script>