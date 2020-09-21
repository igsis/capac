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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/formacaoAjax.php"
                          role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="cadastrarPf">
                        <input type="hidden" name="pf_ultima_atualizacao" value="<?= date('Y-m-d H-i-s') ?>">
                        <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome: *</label>
                                    <input type="text" class="form-control" name="pf_nome" placeholder="Digite o nome" maxlength="70" value="<?= $pf['nome'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nomeArtistico">Nome Artistico:</label>
                                    <input type="text" class="form-control" name="pf_nome_artistico" id="nomeArtistico" placeholder="Digite o nome artistico" maxlength="70" value="<?= $pf['nome_artistico'] ?? '' ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="rg">RG: *</label>
                                    <input type="text" class="form-control" name="pf_rg" id="rg" placeholder="Digite o RG" maxlength="20" value="<?= $pf['rg'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cpf">CPF: </label>
                                    <input type="text" name="pf_cpf" class="form-control" id="cpf" value="<?= $documento ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="ccm">CCM:</label>
                                    <input type="text" id="ccm" name="pf_ccm" class="form-control" placeholder="Digite o CCM" maxlength="11" value="<?= $pf['ccm'] ?? '' ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="dataNascimento">Data de Nascimento: *</label>
                                    <input type="date" class="form-control" id="data_nascimento"
                                           name="pf_data_nascimento" onkeyup="barraData(this);"
                                           value="<?= $pf['data_nascimento'] ?? '' ?>" required/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nacionalidade">Nacionalidade: *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="nacionalidade" name="pf_nacionalidade_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $pfObjeto->geraOpcao("nacionalidades",$pf['nacionalidade_id'] ?? '');
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail: *</label>
                                    <input type="email" name="pf_email" class="form-control"
                                           maxlength="60" placeholder="Digite o E-mail"
                                           value="<?= $pf['email'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #1: *</label>
                                    <input type="text" id="telefone" name="te_telefone_1"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" required
                                           value="<?= $pf['telefones']['tel_0'] ?? "" ?>" maxlength="15">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #2:</label>
                                    <input type="text" id="telefone1" name="te_telefone_2"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" maxlength="15"
                                           value="<?= $pf['telefones']['tel_1'] ?? "" ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #3:</label>
                                    <input type="text" id="telefone2" name="te_telefone_3"
                                           onkeyup="mascara( this, mtel );"  class="form-control telefone"
                                           placeholder="Digite o telefone" maxlength="15"
                                           value="<?= $pf['telefones']['tel_2'] ?? "" ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nit">NIT: *</label>
                                    <input type="text" id="nit" name="ni_nit" class="form-control" maxlength="45"
                                           placeholder="Digite o NIT" required value="<?= $pf['nit'] ?? '' ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="drt">DRT: </label>
                                    <input type="text" id="drt" name="dr_drt" class="form-control" maxlength="45"
                                           placeholder="Digite o DRT em caso de artes cênicas"
                                           value="<?= $pf['drt'] ?? '' ?>">
                                </div>
                            </div>

                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="en_cep" id="cep"
                                           onkeypress="mask(this, '#####-###')" maxlength="9" placeholder="Digite o CEP"
                                           required value="<?= $pf['cep'] ?? '' ?>" >
                                </div>
                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label><br>
                                    <input type="button" class="btn btn-primary" value="Carregar">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="rua">Rua: *</label>
                                    <input type="text" class="form-control" name="en_logradouro" id="rua"
                                           placeholder="Digite a rua" maxlength="200" value="<?= $pf['logradouro'] ?? '' ?>"
                                           readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="numero">Número: *</label>
                                    <input type="number" name="en_numero" class="form-control" placeholder="Ex.: 10"
                                           value="<?= $pf['numero'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" name="en_complemento" class="form-control" maxlength="20"
                                           placeholder="Digite o complemento" value="<?= $pf['complemento'] ?? '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="en_bairro" id="bairro"
                                           placeholder="Digite o Bairro" maxlength="80"
                                           value="<?= $pf['bairro'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="en_cidade" id="cidade"
                                           placeholder="Digite a cidade" maxlength="50"
                                           value="<?= $pf['cidade'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="en_uf" id="estado" maxlength="2"
                                           placeholder="Ex.: SP" value="<?= $pf['uf'] ?? '' ?>" readonly>
                                </div>
                                <div class="col-6">
                                    <label for="subprefeitura">Subprefeitura *</label>
                                    <select name="fm_subprefeitura_id" id="genero" class="form-control select2bs4" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pfObjeto->geraOpcao('subprefeituras',$pf['subprefeitura_id'] ?? '') ?>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <div class="alert alert-warning alert-dismissible">
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
                                Realizamos pagamentos de valores acima de R$ 5.000,00 <b>* SOMENTE COM CONTA
                                    CORRENTE NO BANCO DO BRASIL *</b>. Não são aceitas: conta fácil, poupança e
                                conjunta.
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="banco">Banco:</label>
                                    <select required id="banco" name="bc_banco_id" class="form-control select2bs4">
                                        <option value="">Selecione um banco...</option>
                                        <?php
                                        $pfObjeto->geraOpcao("bancos", $pf['banco_id']);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="agencia">Agência: *</label>
                                    <input type="text" id="agencia" name="bc_agencia" class="form-control"
                                           placeholder="Digite a Agência" maxlength="12"
                                           value="<?= $pf['agencia'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="conta">Conta: *</label>
                                    <input type="text" id="conta" name="bc_conta" class="form-control"
                                           placeholder="Digite a Conta" maxlength="12" value="<?= $pf['conta'] ?? '' ?>"
                                           required>
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