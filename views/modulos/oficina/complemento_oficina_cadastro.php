<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Informações complementares da oficina</h1>
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
                        <h3 class="card-title">Detalhes</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="POST" action="#" role="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="modalidade_id">Modalidade:</label>
                                    <select class="form-control" name="modalidade_id" id="modalidade_id" required>
                                        <option value="">Selecione uma opção...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="data_inicio">Data inicial:</label><br/>
                                    <input type="date" id="data_inicio" name="data_inicio" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="data_fim">Data final:</label><br/>
                                    <input type="date" id="data_fim" name="data_fim" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="execucao_dia1_id">Dia execução 1:</label><br/>
                                    <select class="form-control" name="execucao_dia1_id" id="execucao_dia1_id" required>
                                        <option value="">Selecione uma opção...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="execucao_dia2_id">Dia execução 2:</label><br/>
                                    <select class="form-control" name="execucao_dia2_id" id="execucao_dia2_id" required>
                                        <option value="">Selecione uma opção...</option>
                                    </select>
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