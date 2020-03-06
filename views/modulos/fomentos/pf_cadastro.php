<?php
require_once "./controllers/PessoaFisicaController.php";
require_once "./controllers/PessoaFisicaController.php";

if (isset($_GET['id'])) {
    $_SESSION['origem_id_c'] = $id = $_GET['id'];
} elseif (isset($_SESSION['origem_id_c'])){
    $id = $_SESSION['origem_id_c'];
} else {
    $id = null;
}

$pessoaFisicaObj = new PessoaFisicaController();

if ($id) {
    $pf = $pessoaFisicaObj->recuperaPessoaFisica($id);
    $cpf = $pf['cpf'];
}

if (isset($_POjST['pf_cpf'])){
    $pf = $pessoaFisicaObj->getCNPJ($_POST['pf_cpf'])->fetch(PDO::FETCH_ASSOC);
    if ($pf){
        $id = $pessoaFisicaObj->encryption($pf['id']);
        $pf = $pessoaFisicaObj->recuperaPessoaJuridica($id);
        $cpf = $pf['cpf'];
    }
    else{
        $cpf = $_POST['pf_cpf'];
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
                    <button type="submit" data-toggle="modal" data-target="#modal-troca" class="btn btn-secondary float-right">Trocar a empresa</button>
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
                        <input type="hidden" name="_method" value="cadastrarPj">
                        <input type="hidden" name="ultima_atualizacao" value="<?= date('Y-m-d H-i-s') ?>">
                        <input type="hidden" name="pagina" value="fomentos">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button class="btn swalDefaultWarning">
                            </button>
                        <?php endif; ?>
                        <div class="card-body">


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


        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->



<script>

</script>

<script src="../views/dist/js/cep_api.js"></script>

<script type="text/javascript">
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        $('.swalDefaultWarning').show(function() {
            Toast.fire({
                type: 'warning',
                title: 'Em caso de alteração, pressione o botão Gravar para confirmar os dados'
            })
        });
    });

    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#proponente').addClass('active');
    });
</script>