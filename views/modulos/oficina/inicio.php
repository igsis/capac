<?php
require_once "./controllers/OficinaController.php";
unset($_SESSION['projeto_c']);
unset($_SESSION['origem_id_c']);
unset($_SESSION['oficina_id_c']);
unset($_SESSION['pf_id_c']);
unset($_SESSION['pj_id_c']);
unset($_SESSION['lider_id_c']);

$oficinaObj = new OficinaController();
$cadastros = $oficinaObj->listaOficina();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Lista de Cadastros</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>oficina/evento_cadastro" class="btn btn-success btn-block">Adicionar</a>
                <!--<button class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-default">Adicionar</button>-->
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
                                <th>Protocolo</th>
                                <th>Nome da oficina</th>
                                <th>Data do cadastro</th>
                                <th>Data do envio</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($cadastros as $cadastro): ?>
                                <tr>
                                    <td><?= $cadastro->protocolo ?? "Somente após envio" ?></td>
                                    <td><?= $cadastro->nome_evento ?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($cadastro->data_cadastro)) ?></td>
                                    <td><?= $cadastro->data_envio ? date('d/m/Y H:i:s', strtotime($cadastro->data_envio)) : "Não enviado" ?></td>
                                    <td>
                                        <div class="row">
                                            <?php if (!$cadastro->data_envio): ?>
                                                <div class="col">
                                                    <a href="<?= SERVERURL. 'oficina/evento_cadastro&key='.$oficinaObj->encryption($cadastro->id) ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                                </div>
                                                <div class="col">
                                                    <form class="form-horizontal formulario-ajax" method="POST"
                                                          action="<?= SERVERURL ?>ajax/oficinaAjax.php" role="form" data-form="delete">
                                                        <input type="hidden" name="_method" value="apagarOficina">
                                                        <input type="hidden" name="id" value="<?= $cadastro->id ?>">
                                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Apagar</button>
                                                        <div class="resposta-ajax"></div>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <div class="col">
                                                    <a href="<?= SERVERURL . "pdf/resumo_oficina.php?id=" . $oficinaObj->encryption($cadastro->id) ?>"
                                                       class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-edit"></i> Visualizar</a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Protocolo</th>
                                <th>Nome da oficina</th>
                                <th>Data do cadastro</th>
                                <th>Data do envio</th>
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

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="<?= SERVERURL ?>oficina/pf_dados_cadastro" role="form" id="formularioPf">
                    <div class="row">
                        <div class="form-group col-md-2"><label for="cpf">CPF:</label></div>
                        <div class="form-group col-md-7">
                            <input type="text" class="form-control" id="cpf" name="pf_cpf" maxlength="14" required onkeypress="mask(this, '999.999.999-99')" minlength="14">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn">Pesquisar</button>
                        </div>
                        <br>
                        <span style="display: none;" id="dialogError" class="alert alert-danger" role="alert">CPF inválido</span>
                    </div>
                </form>
                <p class="text-center"><b>ou</b></p>
                <form class="form-horizontal" method="POST" action="<?= SERVERURL ?>oficina/pj_dados_cadastro" role="form" id="formularioPj">
                    <div class="text-danger"><b>Somente com MEI</b></div>
                    <div class="row">
                        <div class="form-group col-md-2"><label for="cnpj">CNPJ:</label></div>
                        <div class="form-group col-md-7">
                            <input type="text" class="form-control" id="cnpj" name="cnpj" onkeypress="mask(this, '##.###.###\####-##')" maxlength="18" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn">Pesquisar</button>
                        </div>
                        <br>
                        <span style="display: none;" id="dialogError" class="alert alert-danger" role="alert">CNPJ inválido</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#buscaProponente').addClass('active');
    });

    $('#formularioCPF').submit(function (event) {
        var cpf = document.querySelector('#cpf').value

        if (cpf != '') {
            var strCpf = cpf.replace(/[^0-9]/g, '');

            var validado = testaCpf(strCpf);

            if (!validado) {
                event.preventDefault()
                $('#dialogError').show();
            }
        }
    })
</script>

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#oficina_inicio').addClass('active');
    })
</script>