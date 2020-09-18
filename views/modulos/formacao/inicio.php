<?php
require_once "./controllers/FormacaoController.php";
unset($_SESSION['projeto_c']);
unset($_SESSION['origem_id_c']);

$formacaoObj = new FormacaoController();

$cadastros = $formacaoObj->listaFormacao($_SESSION['usuario_id_c']);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Projetos</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>formacao/busca_pf"><button class="btn btn-success btn-block">Adicionar</button></a>
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
                        <h3 class="card-title">Cadastros</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Ano</th>
                                <th>Proponente</th>
                                <th>Programa</th>
                                <th>Linguagem</th>
                                <th>Envio</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($cadastros as $cadastro): ?>
                            <tr>
                                <td><?= $cadastro->ano ?></td>
                                <td><?= $cadastro->nome ?></td>
                                <td><?= $cadastro->programa ?></td>
                                <td><?= $cadastro->linguagem ?></td>
                                <td><?= $cadastro->data_envio ? date('d/m/Y H:i:s', strtotime($cadastro->data_envio)) : "Não enviado" ?></td>
                                <td>
                                    <?php if (!$cadastro->data_envio): ?>
                                        <div class="col">
                                            <a href="<?= SERVERURL . "formacao/pf_cadastro&id=" . $formacaoObj->encryption($cadastro->id) ?>"
                                               class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                        </div>
                                        <div class="col">
                                            <form class="form-horizontal formulario-ajax" method="POST"
                                                  action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form"
                                                  data-form="delete">
                                                <input type="hidden" name="_method" value="apagaFormacao">
                                                <input type="hidden" name="id" value="<?= $cadastro->id ?>">
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>
                                                    Apagar
                                                </button>
                                                <div class="resposta-ajax"></div>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <div class="col">
                                            <a href="<?= SERVERURL . "pdf/resumo_formacao.php?id=" . $formacaoObj->encryption($cadastro->id) ?>"
                                               class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-edit"></i> Visualizar</a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Ano</th>
                                <th>Proponente</th>
                                <th>Programa</th>
                                <th>Linguagem</th>
                                <th>Envio</th>
                                <th>Ação</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->

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
        $('#formacao_inicio').addClass('active');
    })
</script>