<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de pessoa física</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Starter Page</li>
                </ol>
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
                    <form class="form-horizontal" method="POST" action="#" role="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome: *</label>
                                    <input type="text" class="form-control" name="nome" placeholder="Digite o nome" maxlength="70" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nomeArtistico">Nome Artistico:</label>
                                    <input type="text" class="form-control" name="nomeArtistico" placeholder="Digite o nome artistico" maxlength="70">
                                </div>
                            </div>

                            <div class="row">
                                <?php
                                //if ($tipoDocumento == 1){
                                    ?>
                                    <div class="form-group col-md-2">
                                        <label for="rg">RG: *</label>
                                        <input type="text" class="form-control" name="rg" placeholder="Digite o RG" maxlength="20" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="cpf">CPF: </label>
                                        <input type="text" name="cpf" class="form-control" id="cpf" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="ccm">CCM:</label>
                                        <input type="text" name="ccm" class="form-control" placeholder="Digite o CCM" maxlength="11">
                                    </div>
                                    <?php
                                //}
                                //else{
                                    ?>
                                    <div class="form-group col-md-6">
                                        <label for="passaporte" id="documento">Passaporte: </label>
                                        <input type="text" id="passaporte" name="passaporte" class="form-control"  readonly>
                                    </div>
                                    <?php
                                //}
                                ?>
                                <div class="form-group col-md-3">
                                    <label for="dataNascimento">Data de Nascimento: *</label>
                                    <input type="date" class="form-control" id="dataNascimento" name="dtNascimento" onkeyup="barraData(this);" required/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nacionalidade">Nacionalidade: *</label>
                                    <select class="form-control" id="nacionalidade" name="nacionalidade" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        //geraOpcao("nacionalidades","");
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="cep" id="cep" maxlength="9" placeholder="Digite o CEP" required data-mask="00000-000">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label><br>
                                    <input type="button" class="btn btn-primary" value="Carregar">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="rua">Rua: *</label>
                                    <input type="text" class="form-control" name="rua" id="rua" placeholder="Digite a rua" maxlength="200" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="numero">Número: *</label>
                                    <input type="number" name="numero" class="form-control" placeholder="Ex.: 10" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" name="complemento" class="form-control" maxlength="20" placeholder="Digite o complemento">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Digite o Bairro" maxlength="80" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Digite a cidade" maxlength="50" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="estado" id="estado" maxlength="2" placeholder="Ex.: SP" readonly>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail: *</label>
                                    <input type="email" name="email" class="form-control" maxlength="60" placeholder="Digite o E-mail" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #1: *</label>
                                    <input type="text" id="telefone" name="telefone[0]" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" required maxlength="15">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #2:</label>
                                    <input type="text" id="telefone1" name="telefone[1]" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" maxlength="15">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #3:</label>
                                    <input type="text" id="telefone2" name="telefone[2]" onkeyup="mascara( this, mtel );"  class="form-control telefone" placeholder="Digite o telefone" maxlength="15">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="nit">NIT: </label>
                                    <input type="text" name="nit" class="form-control" maxlength="45" placeholder="Digite o NIT">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="observacao">Observação: </label>
                                    <textarea id="observacao" name="observacao" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="banco">Banco:</label>
                                    <select required id="banco" name="banco" class="form-control">
                                        <option value="">Selecione um banco...</option>
                                        <?php
                                        //geraOpcao("bancos", "");
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="agencia">Agência: *</label>
                                    <input type="text" name="agencia" class="form-control"  placeholder="Digite a Agência" maxlength="12" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="conta">Conta: *</label>
                                    <input type="text" name="conta" class="form-control" placeholder="Digite a Conta" maxlength="12" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                            <button type="submit" class="btn btn-default">Cancel</button>
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
