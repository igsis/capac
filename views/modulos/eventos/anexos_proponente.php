<?php
$evento_id = $_SESSION['evento_id_c'];
require_once "./controllers/ArquivoController.php";
$arquivosObj = new ArquivoController();
$lista_documento_id = $arquivosObj->recuperaIdListaDocumento(4)->fetch(PDO::FETCH_COLUMN);
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
                        <ul>
                            <li><strong>Formato:</strong> horizontal</li>
                            <li><strong>Resolução:</strong> mínimo de 300dpi</li>
                            <li><strong>Tamanho Máximo:</strong> 15Mb</li>
                        </ul>
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
                            <?php
                            $arquivosEnviados = $arquivosObj->listarArquivosEnviados($evento_id, $lista_documento_id)->fetchAll(PDO::FETCH_OBJ);
                            if (count($arquivosEnviados) != 0) {
                                foreach ($arquivosEnviados as $arquivo) {
                                    ?>
                                    <tr>
                                        <td><a href="<?=SERVERURL."uploads/".$arquivo->arquivo?>" target="_blank"><?= $arquivo->arquivo ?></a></td>
                                        <td><?= $arquivosObj->dataParaBR($arquivo->data) ?></td>
                                        <td>
                                            <form class="formulario-ajax" action="<?=SERVERURL?>ajax/arquivosAjax.php" method="POST" data-form="delete">
                                                <input type="hidden" name="_method" value="removerArquivo">
                                                <input type="hidden" name="arquivo_id" value="<?=$arquivosObj->encryption($arquivo->id)?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Apagar</button>
                                                <div class="resposta-ajax"></div>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="text-center" colspan="3">Nenhum arquivo enviado</td>
                                </tr>
                                <?php
                            }
                            ?>
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
                        <form class="formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/arquivosAjax.php" data-form="save" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="enviarArquivo">
                            <input type="hidden" name="origem_id" value="<?= $evento_id ?>">
                            <table class="table table-striped">
                                <tbody>
                                <?php
                                $arquivos = $arquivosObj->listarArquivos(1)->fetchAll(PDO::FETCH_OBJ);
                                foreach ($arquivos as $arquivo) {
                                    ?>
                                    <tr>
                                        <td>
                                            <label for=""><?=$arquivo->documento?></label>
                                        </td>
                                        <td>
                                            <input class="text-center" type='file' name='<?=$arquivo->sigla?>'><br>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            <input type="submit" class="btn btn-success btn-md btn-block" name="enviar" value='Enviar'>

                            <div class="resposta-ajax">

                            </div>
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
        $('#itens-proponente').addClass('menu-open');
        $('#anexos-proponente').addClass('active');
    })
</script>