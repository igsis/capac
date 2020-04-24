<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro do projeto</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="<?= SERVERURL ?>ajax/projetoAjax.php" role="form"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="pagina" value="fomentos">
                        <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id_c'] ?>">
                        <input type="hidden" name="pessoa_tipo_id" value="1">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="nome_projeto">Nome do projeto: *</label>
                                    <input type="text" class="form-control" id="nome_projeto" name="nome_projeto"  maxlength="80" value="<?= $projeto['nome_projeto'] ?? null ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="usuario_nome">Responsável pela inscrição: *</label>
                                    <input type="text" class="form-control" id="usuario_nome" name="usuario_nome"
                                           value="<?= $_SESSION['nome_c'] ?>" disabled>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_projeto">Valor do projeto: *</label>
                                    <input type="text" class="form-control" id="valor_projeto" name="valor_projeto"
                                           value="<?= isset($projeto['valor_projeto']) ? $objProjeto->dinheiroParaBr($projeto['valor_projeto']) : null ?>"
                                           onKeyPress="return(moeda(this,'.',',',event))" required autocomplete="off">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="duracao">Duração: (em meses) *</label>
                                    <input type="number" class="form-control" id="duracao" name="duracao"
                                           value="<?= $projeto['duracao'] ?? null ?>" min="0" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Há representante do núcleo?  <a href="" class="btn btn-sm btn-primary"><i class="fas fa-info"></i></a></label>
                                    <br>
                                    <div class="form-check-inline">
                                        <input name="ev_espaco_publico" class="form-check-input" type="radio" value="1" >
                                        <label class="form-check-label">Sim</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input name="ev_espaco_publico" class="form-check-input" type="radio" value="0">
                                        <label class="form-check-label">Não</label>
                                    </div>
                                </div>
                                <div class="form-group col-md">
                                    <label for="representante_nucleo">Nome do representante do núcleo: *</label>
                                    <input type="text" class="form-control" id="representante_nucleo"
                                           name="representante_nucleo" maxlength="100" placeholder="não se aplica" disabled
                                           value="<?= $projeto['representante_nucleo'] ?? null ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Há coletivo/produtor independente? <a href="" class="btn btn-sm btn-primary"><i class="fas fa-info"></i></a></label>
                                    <br>
                                    <div class="form-check-inline">
                                        <input name="coletivo" class="form-check-input" type="radio" value="1" >
                                        <label class="form-check-label">Sim</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input name="coletivo" class="form-check-input" type="radio" value="0">
                                        <label class="form-check-label">Não</label>
                                    </div>
                                </div>
                                <div class="form-group col-md">
                                    <label for="representante_nucleo">Nome do coletivo/produtor independente: *</label>
                                    <input type="text" class="form-control" id="representante_nucleo"
                                           name="representante_nucleo" maxlength="100" placeholder="não se aplica" disabled
                                           value="<?= $projeto['representante_nucleo'] ?? null ?>" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" id="btnGrava" class="btn btn-info float-right">Gravar</button>
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
<script type="application/javascript">
    const valorMaximo = parseFloat('<?=  $objProjeto->recuperaValorMax() ?>');
    const btnGrava = document.querySelector('#btnGrava');

    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#projeto').addClass('active');
    })
    $('#duracao').keyup(function () {
        let num = $(this).val();
        num = num.split('-');
        $(this).val(num);
    });

    $('#valor_projeto').keyup(function () {
        let valorP = converteValor($(this).val());

        if (valorP > valorMaximo) {
            Swal.fire(
                'Valor de Projeto acima do máximo!',
                "Valor deve ter no maximo até R$  <?= $objProjeto->dinheiroParaBr($objProjeto->recuperaValorMax()) ?>.",
                'error'
            );
            $(this).val('');
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }

    });


    function converteValor(valor) {
        let ValorNovo = '';
        let valores = valor.split('.');

        valores.forEach((valor) => {
            ValorNovo = ValorNovo + valor;
        });
        ValorNovo = ValorNovo.replace(',', '.');

        return parseFloat(ValorNovo).toFixed(2);
    }


</script>