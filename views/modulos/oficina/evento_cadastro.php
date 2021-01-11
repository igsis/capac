<?php
if (isset($_GET['key'])) {
    $_SESSION['origem_id_c'] = $id = $_GET['key'];
    require_once "./controllers/PedidoController.php";
    $pedidoObj = new PedidoController();
    $pedidoObj->startPedido();

} elseif (isset($_SESSION['origem_id_c'])) {
    $id = $_SESSION['origem_id_c'];
} else {
    $id = null;
}

require_once "./controllers/OficinaController.php";
$oficinaObj = new OficinaController();
$oficina = $oficinaObj->recuperaOficina($id);
/*if ($oficina) {
    $_SESSION['atracao_id_c'] = $oficinaObj->encryption($oficina->atracao_id);
    $tipoContratacao = $oficina->tipo_contratacao_id;
}*/

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de Oficina</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/oficinaAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarEvento" : "cadastrarEvento" ?>">
                        <input type="hidden" name="tipo_contratacao_id" value="5">
                        <input type="hidden" name="espaco_publico" value="1">
                        <input type="hidden" name="fomento" value="0">
                        <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id_c'] ?>">
                        <input type="hidden" name="data_cadastro" value="<?= date('Y-m-d H:i:s') ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?=$oficinaObj->encryption($oficina->id)?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nomeEvento">Nome da oficina *</label>
                                <input type="text" class="form-control" id="nomeEvento" name="nome_evento"
                                       placeholder="Digite o nome da oficina. Exemplo: Oficina de ponto cruz"
                                       maxlength="240" value="<?=$oficina->nome_evento ?? ""?>" required>
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
                                    <?php $oficinaObj->geraCheckbox('publicos', 'evento_publico', 'evento_id',$oficina->id ?? null, true); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sinopse">Sinopse *</label><br/>
                                <i>Esse campo deve conter uma breve descrição do que será apresentado no evento.</i>
                                <p align="justify"><span style="color: gray; "><strong><i>Texto de exemplo:</strong><br/>Ana Cañas faz o show de lançamento do seu quarto disco, “Tô na Vida” (Som Livre/Guela Records). Produzido por Lúcio Maia (Nação Zumbi) em parceria com Ana e mixado por Mario Caldato Jr, é o primeiro disco totalmente autoral da carreira da cantora e traz parcerias com Arnaldo Antunes e Dadi entre outros.</span></i>
                                </p>
                                <textarea name="sinopse" id="sinopse" class="form-control" rows="5" required><?=$oficina->sinopse ?? ""?></textarea>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right" id="cadastra">Gravar</button>
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
                    <?php $oficinaObj->exibeDescricaoPublico() ?>
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
    $('.publicos').attr("name", "publicos[]");
</script>