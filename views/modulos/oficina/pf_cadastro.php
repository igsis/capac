<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
require_once "./controllers/PessoaFisicaController.php";
$insPessoaFisica = new PessoaFisicaController();
$pf = $insPessoaFisica->recuperaPessoaFisica($id)->fetch();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de pessoa física</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/pessoaFisicaAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="ultima_atualizacao" value="<?= date('Y-m-d H-i-s') ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome: *</label>
                                    <input type="text" class="form-control" name="nome" placeholder="Digite o nome" maxlength="70" value="<?= $pf['nome'] ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nomeArtistico">Nome Artistico:</label>
                                    <input type="text" class="form-control" name="nome_artistico" placeholder="Digite o nome artistico" maxlength="70" value="<?= $pf['nome_artistico'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <?php
                                //if ($tipoDocumento == 1){
                                    ?>
                                    <div class="form-group col-md-2">
                                        <label for="rg">RG: *</label>
                                        <input type="text" class="form-control" name="rg" placeholder="Digite o RG" maxlength="20" value="<?= $pf['rg'] ?>" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="cpf">CPF: </label>
                                        <input type="text" name="cpf" class="form-control" id="cpf" value="<?= $pf['cpf'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="ccm">CCM:</label>
                                        <input type="text" name="ccm" class="form-control" placeholder="Digite o CCM" maxlength="11" value="<?= $pf['ccm'] ?>">
                                    </div>
                                    <?php
                                //}
                                //else{
                                    ?>
                                    <div class="form-group col-md-6">
                                        <label for="passaporte" id="documento">Passaporte: </label>
                                        <input type="text" id="passaporte" name="passaporte" class="form-control" value="<?= $pf['passaporte'] ?>" readonly>
                                    </div>
                                    <?php
                                //}
                                ?>
                                <div class="form-group col-md-3">
                                    <label for="dataNascimento">Data de Nascimento: *</label>
                                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" onkeyup="barraData(this);" value="<?= $pf['data_nascimento'] ?>" required/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nacionalidade">Nacionalidade: *</label>
                                    <select class="form-control" id="nacionalidade" name="nacionalidade_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $insPessoaFisica->geraOpcao("nacionalidades");
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="cep" id="cep" maxlength="9" placeholder="Digite o CEP" required data-mask="00000-000" value="<?= $pf['cep'] ?>" >
                                </div>
                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label><br>
                                    <input type="button" class="btn btn-primary" value="Carregar">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="rua">Rua: *</label>
                                    <input type="text" class="form-control" name="logradouro" id="rua" placeholder="Digite a rua" maxlength="200" value="<?= $pf['logradouro'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="numero">Número: *</label>
                                    <input type="number" name="numero" class="form-control" placeholder="Ex.: 10" value="<?= $pf['numero'] ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" name="complemento" class="form-control" maxlength="20" placeholder="Digite o complemento" value="<?= $pf['complemento'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Digite o Bairro" maxlength="80" value="<?= $pf['bairro'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Digite a cidade" maxlength="50" value="<?= $pf['cidade'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="uf" id="estado" maxlength="2" placeholder="Ex.: SP" value="<?= $pf['estado'] ?>" readonly>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail: *</label>
                                    <input type="email" name="email" class="form-control" maxlength="60" placeholder="Digite o E-mail" value="<?= $pf['email'] ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #1: *</label>
                                    <input type="text" id="telefone" name="telefone[0]" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" required value="<?= $pf['telefone'] ?>" maxlength="15">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #2:</label>
                                    <input type="text" id="telefone1" name="telefone[1]" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" maxlength="15" value="<?= $pf['telefone'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #3:</label>
                                    <input type="text" id="telefone2" name="telefone[2]" onkeyup="mascara( this, mtel );"  class="form-control telefone" placeholder="Digite o telefone" maxlength="15" value="<?= $pf['telefone'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="nit">NIT: </label>
                                    <input type="text" id="nit" name="nit" class="form-control" maxlength="45" placeholder="Digite o NIT" value="<?= $pf['nit'] ?>">
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="banco">Banco:</label>
                                    <select required id="banco" name="banco" class="form-control">
                                        <option value="">Selecione um banco...</option>
                                        <?php
                                        $insPessoaFisica->geraOpcao("pf_bancos");
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="agencia">Agência: *</label>
                                    <input type="text" id="agencia" name="agencia" class="form-control"  placeholder="Digite a Agência" maxlength="12" value="<?= $pf['agencia'] ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="conta">Conta: *</label>
                                    <input type="text" id="conta" name="conta" class="form-control" placeholder="Digite a Conta" maxlength="12" value="<?= $pf['conta'] ?>" required>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="oficina_nivel_id">Nível:</label>
                                    <select required id="oficina_nivel_id" name="oficina_nivel_id" class="form-control">
                                        <option value="">Selecione um nível...</option>
                                        <?php
                                        $insPessoaFisica->geraOpcao("oficina_niveis");
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="oficina_linguagem_id">Linguagem: *</label>
                                    <select required id="oficina_linguagem_id" name="oficina_linguagem_id" class="form-control">
                                        <option value="">Selecione uma linguagem...</option>
                                        <?php
                                        $insPessoaFisica->geraOpcao("oficina_linguagens");
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="oficina_sublinguagem_id">Sub linguagem: *</label>
                                    <select required id="oficina_sublinguagem_id" name="oficina_sublinguagem_id" class="form-control">
                                        <option value="">Selecione uma sub linguagem...</option>
                                        <?php
                                        $insPessoaFisica->geraOpcao("oficina_sublinguagens");
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
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
