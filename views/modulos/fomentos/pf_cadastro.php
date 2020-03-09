<?php
require_once "./controllers/PessoaFisicaController.php";

$pfObjeto =  new PessoaFisicaController();

if (isset($_GET['id'])) {
    $_SESSION['origem_id_c'] = $id = $_GET['id'];
} elseif (isset($_SESSION['origem_id_c'])){
    $id = $_SESSION['origem_id_c'];
} else {
    $id = null;
}

if (isset($_POST['pf_cpf'])) {
    if($pfObjeto->getCPFFom($_POST['pf_cpf'])){
        $pf = $pfObjeto->getCPFFom($_POST['pf_cpf']);
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
                          data-form="<?= isset($pf) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="cadastrarPj">
                        <input type="hidden" name="ultima_atualizacao" value="<?= date('Y-m-d H-i-s') ?>">
                        <input type="hidden" name="pagina" value="fomentos">
                        <?php if (isset($pf)): ?>
                            <input type="hidden" name="id" value="<?= $pf['id'] ?>">
                            <button class="btn swalDefaultWarning">
                            </button>
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="nome">Nome Completo:</label>
                                    <input type="text" class="form-control" name="nome" id="nome">
                                </div>
                                <div class="col">
                                    <label for="nomeColetivo">Nome do Coletivo/Grupo</label>
                                    <input type="text" class="form-control" name="nomeColetivo" id="nomeColetivo">
                                </div>
                                <div class="col">
                                    <label for="cpf">CPF:</label>
                                    <input type="text" class="form-control" name="cpf" readonly value="<?= $_POST['pf_cpf']?>">
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col">
                                    <label for="genero">Gênero:</label>
                                    <select name="genero" id="genero" class="form-control">
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pfObjeto->geraOpcao('generos',isset($pf) ? $pf['generos_id']: '') ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="etinia">Etnia:</label>
                                    <select name="etnia" id="etnia" class="form-control">
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pfObjeto->geraOpcao('etnias',isset($pf) ? $pf['etnias_id']: '','',false) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="redeSocial">Rede Social:</label>
                                    <input type="text" class="form-control" name="redeSocial" id="redeSocial">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="email">E-mail: *</label>
                                    <input type="email" name="email" class="form-control" maxlength="60" placeholder="Digite o E-mail" required>
                                </div>
                                <div class="col">
                                    <label for="telefone">Telefone #1: *</label>
                                    <input type="text" id="telefone" name="te_telefone_1" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" required maxlength="15">
                                </div>
                                <div class="col">
                                    <label for="telefone">Telefone #2: *</label>
                                    <input type="text" id="telefone1" name="te_telefone_2" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" required maxlength="15">
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="form-group col-5">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="en_cep" id="cep" onkeypress="mask(this, '#####-###')" maxlength="9" placeholder="Digite o CEP" required value="<?= $pj['cep'] ?? '' ?>" >
                                </div>
                                <div class="form-group col-2">
                                    <label>&nbsp;</label><br>
                                    <input type="button" class="btn btn-primary" value="Carregar">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="rua">Rua: *</label>
                                    <input type="text" class="form-control" name="en_logradouro" id="rua" placeholder="Digite a rua" maxlength="2   00" value="<?= $pj['logradouro'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-2">
                                    <label for="numero">Número: *</label>
                                    <input type="number" name="en_numero" class="form-control" placeholder="Ex.: 10" value="<?= $pj['numero'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" name="en_complemento" class="form-control" maxlength="20" placeholder="Digite o complemento" value="<?= $pj['complemento'] ?? '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="en_bairro" id="bairro" placeholder="Digite o Bairro" maxlength="80" value="<?= $pj['bairro'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="en_cidade" id="cidade" placeholder="Digite a cidade" maxlength="50" value="<?= $pj['cidade'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="en_uf" id="estado" maxlength="2" placeholder="Ex.: SP" value="<?= $pj['uf'] ?? '' ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="subprefeitura">Subprefeitura</label>
                                    <select name="genero" id="genero" class="form-control">
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pfObjeto->geraOpcao('subprefeituras',isset($pf) ? $pf['subprefeitura_id']: '') ?>
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