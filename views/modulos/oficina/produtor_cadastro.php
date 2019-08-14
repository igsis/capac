<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de produtor</h1>
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
                        <h3 class="card-title">Informações Gerais</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="POST" action="#" role="form">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nome">Nome: *</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome completo" maxlength="120" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail: *</label>
                                    <input type="email" class="form-control" id="email" name="email" maxlength="60" placeholder="Digite o e-mail" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="telefone1">Telefone #1: *</label>
                                    <input type="text" data-mask="(00) 00000-0000" class="form-control" id="telefone" name="telefone1" maxlength="15" onkeyup="mascara( this, mtel );" placeholder="Digite o Telefone principal" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="telefone2">Telefone #2</label>
                                    <input type="text" data-mask="(00) 00000-0000" class="form-control" id="telefone" name="telefone2" maxlength="15" onkeyup="mascara( this, mtel );" placeholder="Digite o Telefone secundário">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="observacao">Observação</label>
                                <textarea name="observacao" id="observacao" class="form-control" rows="3"></textarea>
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
