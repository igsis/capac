<?php
//CONTROLLERS
require_once "./controllers/PessoaFisicaController.php";

$projetoObj = new ProjetoController();
$fomentoObj = new FomentoController();
$pfObj = new PessoaFisicaController();

//Projeto
$idProj = $_SESSION['projeto_c'];
$projeto = $projetoObj->recuperaProjeto($idProj);

//Pessoa Física
$pf = $pfObj->recuperaPessoaFisicaFom(MainModel::encryption($projeto['pessoa_fisica_id']));

$status = $projetoObj->recuperaStatusProjeto($projeto['fom_status_id']);
if ($projeto['data_inscricao']) {
    $dataEnvio = MainModel::dataHora($projeto['data_inscricao']);
}

$nomeEdital = $fomentoObj->recuperaNomeEdital($_SESSION['edital_c']);

$validacaoArquivos = $projetoObj->validaProjeto($idProj, $_SESSION['edital_c']);
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Finalizado Projeto</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <?php
        if ($validacaoArquivos) {
            ?>
            <div class="row erro-validacao">
                <?php foreach ($validacaoArquivos as $titulo => $erros): ?>
                    <div class="col-md-4">
                        <div class="card bg-danger">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-exclamation mr-3"></i><strong>Erros
                                        em <?= $titulo ?></strong></h3>
                            </div>
                            <div class="card-body">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= $erro ?></li>
                                <?php endforeach; ?>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        }
        ?>
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
                    <?php if ($projeto['protocolo'] == null || $projeto['data_inscricao'] == null): ?>
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-10">
                                <div class="alert alert-warning alert-dismissible">
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
                                    <p class="mb-1">Antes de finalizar verifique se todos os dados estão
                                        corretos.</p>
                                    <p>Após verificar clique no botão "Clique aqui para enviar seu projeto"</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- /.card-header -->
                    <ul id="lista-finalizar-fom">
                        <?= $projeto['protocolo'] ? "<li class=\"my-2\"><span class=\"subtitulos mr-2\">Código de cadastro:</span> {$projeto['protocolo']}</li>" : '' ?>
                        <li class="my-2"><span
                                    class="subtitulos mr-2">Responsável pela inscrição: </span> <?= $_SESSION['nome_c'] ?>
                        </li>
                        <li class="my-2">
                            <span class="subtitulos mr-2">Nome: </span><?= $pf['nome'] ?>
                            <span class="ml-5 subtitulos mr-2">CPF: </span> <?= $pf['cpf'] ?> </li>
                        <li class="my-2">
                            <span class="subtitulos mr-2">E-mail: </span><?= $pf['email'] ?>
                            <span class="ml-5 subtitulos mr-2">Telefone: </span> (11) 99999-9999
                        </li>
                        <li class="my-2">
                            <span class="subtitulos mr-2">Endereço: </span> <?= "{$pf['logradouro']}, {$pf['numero']}  {$pf['complemento']} - {$pf['bairro']}, {$pf['cidade']} - {$pf['uf']}, {$pf['cep']}" ?>
                        </li>
                        <li class="my-2">
                            <span class="subtitulos mr-2">Site:</span> <a href="<?= "http://{$pf['rede_social']}" ?>"
                                                                          target="_blank"><?= $pf['rede_social'] ?></a>
                        </li>
                        <li class="my-2">
                            <span class="subtitulos mr-2">Valor do projeto:</span>
                            <span id="dinheiro"><?= $projeto['valor_projeto'] ?></span>
                        </li>
                        <li class="my-2"><span
                                    class="subtitulos mr-2">Duração do projeto em meses: </span><?= $projeto['duracao'] ?>
                            meses
                        </li>
                        <li class="my-2"><span class="subtitulos mr-2">Status: </span><?= $status ?> </li>
                        <li class="my-2"><span class="subtitulos mr-2">Fomento: </span><?= $nomeEdital ?></li>
                        <?= $projeto['data_inscricao'] ? "<li class=\"my-2\"><span class=\"subtitulos mr-2\">Data de Envio: </span> {$dataEnvio} </li>" : '' ?>
                    </ul>
                    <?php if ($projeto['protocolo'] == null && $projeto['data_inscricao'] == null): ?>
                        <div class="row justify-content-center mb-4">
                            <form class="formulario-ajax" method="post"
                                  action="<?= SERVERURL ?>ajax/projetoAjax.php"
                                  role="form"
                                  data-form="save">
                                <input type="hidden" name="_method" value="finalizar_fom">
                                <input type="hidden" name="id" value="<?= $projeto['id'] ?>">
                                <input type="hidden">
                                <button type="submit" id="btnEnviar" class="btn btn-success btn-lg">
                                    Clique aqui para enviar seu projeto
                                </button>
                                <div class="resposta-ajax"></div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<script>
    $(document).ready(function () {
        if ($('.erro-validacao').length) {
            $('#btnEnviar').attr('disabled', true);
        } else {
            $('#btnEnviar').attr('disabled', false);
        }
    })
</script>
<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#finalizar').addClass('active');
    })
</script>