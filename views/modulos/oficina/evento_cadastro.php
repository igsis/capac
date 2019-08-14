<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de evento</h1>
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
                                <label for="nomeEvento">Nome do evento *</label>
                                <input type="text" class="form-control" id="nomeEvento" name="nomeEvento" placeholder="Digite o nome do evento" maxlength="240" required>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="contratacao">Espaço em que será realizado o evento é público?</label>
                                    <br>
                                    <label><input type="radio" name="tipoLugar" value="1"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="tipoLugar" value="0" checked> Não </label>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fomento">É fomento/programa?</label> <br>
                                    <label><input type="radio" class="fomento" name="fomento" value="1" id="sim"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" class="fomento" name="fomento" value="0" id="nao" checked> Não </label>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tipoFomento">Fomento/Programa</label> <br>
                                    <select class="form-control" name="tipoFomento" id="tipoFomento">
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                            //geraOpcao("fomentos");
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="acao">Público (Representatividade e Visibilidade Sócio-cultural)* <i>(multipla escolha) </i></label>
                                    <button class='btn btn-default' type='button' data-toggle='modal'
                                            data-target='#modalPublico' style="border-radius: 30px;">
                                        <i class="fa fa-question-circle"></i></button>
                                    <div class="row" id="msgEsconde">
                                        <div class="form-group col-md-6">
                                            <span style="color: red;">Selecione ao menos uma representatividade!</span>
                                        </div>
                                    </div>
                                    <?php
                                    //geraCheckBox('publicos', 'publico', 'evento_publico', 'col-md-6', 'evento_id', 'publico_id', null);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sinopse">Sinopse *</label><br/>
                                <i>Esse campo deve conter uma breve descrição do que será apresentado no evento.</i>
                                <p align="justify"><span style="color: gray; "><strong><i>Texto de exemplo:</strong><br/>Ana Cañas faz o show de lançamento do seu quarto disco, “Tô na Vida” (Som Livre/Guela Records). Produzido por Lúcio Maia (Nação Zumbi) em parceria com Ana e mixado por Mario Caldato Jr, é o primeiro disco totalmente autoral da carreira da cantora e traz parcerias com Arnaldo Antunes e Dadi entre outros.</span></i>
                                </p>
                                <textarea name="sinopse" id="sinopse" class="form-control" rows="5" required></textarea>
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

<!-- modal público -->
<div class="modal fade" id="modalPublico" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Público (Representatividade e Visibilidade Sócio-cultural)</h4>
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
                    <?php
                    $sqlConsultaPublico = "SELECT publico, descricao FROM publicos WHERE publicado = '1' ORDER BY 1";
                    foreach ($con->query($sqlConsultaPublico)->fetch_all(MYSQLI_ASSOC) as $publico) {
                        ?>
                        <tr>
                            <td><?= $publico['publico'] ?></td>
                            <td><?= $publico['descricao'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
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

    $(document).ready(
        verificaFomento(),
        verificaOficina()
    );

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
</script>

<script>

    function publicoValidacao() {
        var isMsg = $('#msgEsconde');
        isMsg.hide();

        var i = 0;
        var counter = 0;
        var publico = $('.publico');

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

    $('.publico').on("change", publicoValidacao);
</script>