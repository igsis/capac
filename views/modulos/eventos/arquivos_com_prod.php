<?php
    $evento_id = $_SESSION['evento_id_c'];
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Comunicação / Produção</h1>
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
            <div class="offset-md-1 col-md-10">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Atenção!</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        Nesta página você envia os arquivos como o rider, mapas de cenas e luz, logos de parceiros, programação de filmes de mostras de cinema, entre outros arquivos destinados à comunicação e produção. Não envie cópias de documentos nesta página.<br/>
                        Em caso de envio de fotografia, considerar as seguintes especificações técnicas:
                        <br>- formato: horizontal
                        <br>- tamanho: mínimo de 300dpi
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Aquivos anexados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- table start -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Nome do documento</th>
                                <th style="width: 30%">Data de envio</th>
                                <th style="width: 10%">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Arquivo 1</td>
                                <td>14/08/2018 17:00:01</td>
                                <td><button class="btn btn-sm btn-danger">Apagar</button></td>
                            </tr>
                            <tr>
                                <td>Arquivo 2</td>
                                <td>14/08/2018 17:02:01</td>
                                <td><button class="btn btn-sm btn-danger">Apagar</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Informações Gerais</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- table start -->
                    <div class="card-body p-0">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="<?= $evento_id ?>">
                            <input type="hidden" name="evento_id" value="<?= $evento_id ?>">
                            <input type="hidden" name="lista_documento_id" value="1">
                            <table class="table table-striped">
                            <?php
                                echo "<tbody>";
                                $linhas = 0;
                                for ($i = 5    ; $i > $linhas; $i--) {
                            ?>
                                    <tr>
                                        <td>
                                            <input class="text-center" type='file' name='arquivos[]'><br>
                                        </td>
                                        <td>
                                            <input class="text-center" type='file' name='arquivos[]'><br>
                                        </td>
                                    </tr>
                            <?php
                                    echo "</tbody>";
                                }
                            ?>
                            </table>
                            <input type="submit" class="btn btn-success btn-md btn-block" name="enviar" value='Enviar'>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#com_prod').addClass('active');
    })
</script>