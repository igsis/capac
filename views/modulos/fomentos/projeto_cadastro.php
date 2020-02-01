<?php
/*
$id = isset($_GET['id']) ? $_GET['id'] : null;
require_once "./controllers/PessoaFisicaController.php";
$insPessoaFisica = new PessoaFisicaController();
require_once "./controllers/AtracaoController.php";
$insAtracao = new AtracaoController();

if ($id) {
    $pf = $insPessoaFisica->recuperaPessoaFisica($id);
    $cenica = $insAtracao->verificaCenica($_SESSION['origem_id_c']);
    if ($pf['cpf'] != "") {
        $documento = $pf['cpf'];
    } else {
        $documento = $pf['passaporte'];
    }
}

if (isset($_POST['pf_cpf'])){
    $documento = $_POST['pf_cpf'];
    $pf = $insPessoaFisica->getCPF($documento)->fetch();
    if ($pf['cpf'] != ''){
        $id = MainModel::encryption($pf['id']);
        $pf = $insPessoaFisica->recuperaPessoaFisica($id);
        $documento = $pf['cpf'];
    }
    $cenica = $insAtracao->verificaCenica($_SESSION['origem_id_c']);
}
if (isset($_POST['pf_passaporte'])){
    $documento = $_POST['pf_passaporte'];
    $pf = $insPessoaFisica->getPassaporte($documento)->fetch();
    if ($pf['passaporte'] != ''){
        $id = MainModel::encryption($pf['id']);
        $pf = $insPessoaFisica->recuperaPessoaFisica($id);
        $documento = $pf['passaporte'];
    }
    $cenica = $insAtracao->verificaCenica($_SESSION['origem_id_c']);
}
*/
$id = 1;
$fomento = [
    "id" => '1',
    "instituicao" => 'inst',
    "site" => 'site',
    "valor_projeto" => 'valor',
    "duracao" => 2,
    "nucleo_artistico" => 'aeooo',
    "representante_nucleo" => 'ghjkl'
];
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro do projeto</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/projetoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="pagina" value="eventos">
                        <input type="hidden" name="pf_ultima_atualizacao" value="<?= date('Y-m-d H-i-s') ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="instituicao">Instituição responsável: *</label>
                                    <input type="text" class="form-control" id="instituicao" name="instituicao" placeholder="Digite a instituição responsável" maxlength="80" value="<?= $fomento['instituicao'] ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="usuario_id">Responsável pela inscrição: *</label>
                                    <input type="text" class="form-control" id="usuario_id" name="usuario_id" value="<?= $_SESSION['nome_c'] ?>" disabled>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="site">Site: *</label>
                                    <input type="text" class="form-control" id="site" name="site" value="<?= $fomento['site'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_projeto">Valor do projeto: *</label>
                                    <input type="text" class="form-control" id="valor_projeto" name="valor_projeto" value="<?= $fomento['valor_projeto'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="duracao">Duração: (em meses) *</label>
                                    <input type="number" class="form-control" id="duracao" name="duracao" value="<?= $fomento['duracao'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="nucleo_artistico">Núcleo artístico: *</label>
                                    <textarea class="form-control" rows="5" id="nucleo_artistico" name="nucleo_artistico"><?= $fomento['nucleo_artistico'] ?></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="representante_nucleo">Representante do núcleo: *</label>
                                    <input type="text" class="form-control" id="representante_nucleo" name="representante_nucleo" maxlength="100" value="<?= $fomento['representante_nucleo'] ?>">
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