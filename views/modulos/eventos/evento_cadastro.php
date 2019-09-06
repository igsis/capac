<?php
    $tipoContratacao = $_SESSION['tipoContratacao_c'];

    $id = isset($_GET['key']) ? $_GET['key'] : null;
    require_once "./controllers/EventoController.php";
    $eventoObj = new EventoController();
    $evento = $eventoObj->recuperaEvento($id);
    if ($evento) {
        $tipoContratacao = $evento->contratacao;
    }

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro do Evento</h1>
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
                        <h3 class="card-title">Informações iniciais</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/eventoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarEvento" : "cadastrarEvento" ?>">
                        <input type="hidden" name="contratacao" value="<?=$tipoContratacao?>">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nome_evento">Nome do Evento *</label>
                                <input type="text" class="form-control" id="nome_evento" name="nome_evento" placeholder="Digite o nome do Evento" maxlength="240" value="<?=$evento->nome_evento ?? ""?>" required>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Espaço em que será realizado o evento é público?</label>
                                    <br>
                                    <div class="form-check-inline">
                                        <input name="espaco_publico" class="form-check-input" type="radio" value="1" <?=$evento ? ($evento->espaco_publico == 1 ? "checked" : "") : ""?>>
                                        <label class="form-check-label">Sim</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input name="espaco_publico" class="form-check-input" type="radio" value="0"<?=$evento ? ($evento->espaco_publico == 0 ? "checked" : "") : "checked"?>>
                                        <label class="form-check-label">Não</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="fomento">É fomento/programa?</label>
                                    <br>
                                    <div class="form-check-inline">
                                        <input name="fomento" class="form-check-input fomento" type="radio" value="1" id="sim" <?=$evento ? ($evento->fomento == 1 ? "checked" : "") : ""?>>
                                        <label class="form-check-label">Sim</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input name="fomento" class="form-check-input fomento" type="radio" value="0" <?=$evento ? ($evento->fomento == 0 ? "checked" : "") : "checked"?>>
                                        <label class="form-check-label">Não</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="tipoFomento">Fomento/Programa</label> <br>
                                    <select class="form-control" name="fomento_id" id="tipoFomento">
                                        <option value="">Selecione uma opção...</option>
                                        <?php $eventoObj->geraOpcao('fomentos', $evento->fomento_id ?? ""); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="acao">Público (Representatividade e Visibilidade Sócio-cultural)* <i>(multipla escolha) </i></label>
                                    <button class='btn btn-default' type='button' data-toggle='modal'
                                            data-target='#modalPublico' style="border-radius: 30px;">
                                        <i class="fa fa-question-circle"></i></button>
                                    <div class="row" id="msgEsconde">
                                        <div class="form-group col-md-6">
                                            <span style="color: red;">Selecione ao menos uma representatividade!</span>
                                        </div>
                                    </div>
                                    <?php $eventoObj->geraCheckbox('publicos', 'evento_publico', $evento->id ?? null); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sinopse">Sinopse *</label><br/>
                                <i>Esse campo deve conter uma breve descrição do que será apresentado no evento.</i>
                                <p align="justify"><span style="color: gray; "><strong><i>Texto de exemplo:</strong><br/>Ana Cañas faz o show de lançamento do seu quarto disco, “Tô na Vida” (Som Livre/Guela Records). Produzido por Lúcio Maia (Nação Zumbi) em parceria com Ana e mixado por Mario Caldato Jr, é o primeiro disco totalmente autoral da carreira da cantora e traz parcerias com Arnaldo Antunes e Dadi entre outros.</span></i>
                                </p>
                                <textarea name="sinopse" id="sinopse" class="form-control" rows="5" required><?=$evento->sinopse ?? ""?></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right" id="cadastra">Gravar</button>
                            <button type="submit" class="btn btn-default">Cancel</button>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax">

                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- /.row -->

        <!-- modal público -->
        <div class="modal fade" id="modalPublico" style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Público (Representatividade e Visibilidade Sócio-cultural)</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body" style="text-align: left;">
                        <table class="table table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th>Público</th>
                                <th>Descrição</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $eventoObj->exibeDescricaoPublico() ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-theme" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal público -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- /modal -->

<script>
    let fomento = $('.fomento');
    let acao = $("input[name='acao[]']");
    const oficinaId = "Oficinas e Formação Cultural";
    let oficinaRadio = $("input[name='oficina']");
    var oficinaOficial = acao[8];

    function verificaOficina() {
        if ($('#simOficina').is(':checked')) {
            checaCampos(oficinaOficial);
        } else {
            checaCampos("");
        }
    }

    function checaCampos(obj) {
        if (obj.id == oficinaId && obj.value == '8') {

            for (i = 0; i < acao.size(); i++) {
                if (!(acao[i] == obj)) {
                    let acoes = acao[i].id;

                    document.getElementById(acoes).disabled = true;
                    document.getElementById(acoes).checked = false;
                    document.getElementById(oficinaId).checked = true;
                    document.getElementById(oficinaId).disabled = false;

                    document.getElementById(oficinaId).readonly = true;

                }
            }
        } else {
            for (i = 0; i < acao.size(); i++) {

                if (!(acao[i] == acao[8])) {
                    let acoes = acao[i].id;

                    document.getElementById(acoes).disabled = false;
                    document.getElementById(acoes).checked = false;
                    document.getElementById(oficinaId).checked = false;
                    document.getElementById(oficinaId).disabled = true;

                    document.getElementById(oficinaId).readonly = false;
                }
            }

        }
    }

    fomento.on("change", verificaFomento);
    oficinaRadio.on("change", verificaOficina);



    function verificaFomento() {
        if ($('#sim').is(':checked')) {
            $('#tipoFomento')
                .attr('disabled', false)
                .attr('required', true)
        } else {
            $('#tipoFomento')
                .attr('disabled', true)
                .attr('required', false)
        }
    }

    $(document).ready(
        verificaFomento(),
        verificaOficina()
    );

    function publicoValidacao() {
        var isMsg = $('#msgEsconde');
        isMsg.hide();

        var i = 0;
        var counter = 0;
        var publico = $('.publicos');

        for (; i < publico.length; i++) {
            if (publico[i].checked) {
                counter++;
            }
        }

        if (counter == 0) {
            $('#cadastra').attr("disabled", true);
            isMsg.show();
            return false;
        }

        $('#cadastra').attr("disabled", false);
        isMsg.hide();
        return true;
    }

    $(document).ready(publicoValidacao);

    $('.publicos').on("change", publicoValidacao);
</script>