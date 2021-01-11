<?php
require_once "./controllers/OficinaController.php";
$oficinaObj = new OficinaController();

$id = $_GET['id'] ?? null;

$evento_id = $_SESSION['origem_id_c'];
$oficina = $oficinaObj->recuperaOficina($evento_id);
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
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarOficina" : "cadastrarOficina" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?=$oficinaObj->encryption($oficina->id)?>">
                        <?php endif; ?>
                        <div class="card-body">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md">
                                            <label for="links">Links</label><br>
                                            <i>Esse campo deve conter os links relacionados ao espetáculo, ao artista/grupo que auxiliem na divulgação do evento.</i>
                                            <p style="color: gray; ">
                                                <strong><i>Links de exemplo:</i></strong><br>
                                                <i>
                                                    https://www.facebook.com/anacanasoficial/<br>
                                                    https://www.youtube.com/user/anacanasoficial
                                                </i>
                                            </p>
                                            <textarea id="links" name="links" class="form-control" rows="5"><?= $oficina->links ?? "" ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="classificacao_indicativa_id">Classificação indicativa * </label>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-info"></i></button>
                                            <select class="form-control" id="classificacao_indicativa_id" name="classificacao_indicativa_id" required>
                                                <option value="">Selecione...</option>
                                                <?php $oficinaObj->geraOpcao('classificacao_indicativas', $oficina->classificacao_indicativa_id ?? ""); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="quantidade_apresentacao">Quantidade de apresentação *</label>
                                            <input type="number" id="quantidade_apresentacao" name="quantidade_apresentacao" class="form-control" value="<?= $oficina->quantidade_apresentacao ?? "" ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="integrantes">Integrantes *</label><br/>
                                    <i>Esse campo deve conter a listagem de pessoas envolvidas no espetáculo <span style="color: #FF0000; ">incluindo o líder do grupo</span>. Apenas o <span style="color: #FF0000; ">nome civil, RG e CPF</span> de quem irá se apresentar, excluindo técnicos.</i>
                                    <p align="justify"><span style="color: gray; ">
                                        <i><strong>Elenco de exemplo:</strong><br/>Ana Cañas RG 00000000-0 CPF 000.000.000-00<br/>Lúcio Maia RG 00000000-0 CPF 000.000.000-00</i>
                                    </span></p>
                                    <textarea id="integrantes" name="integrantes" class="form-control" rows="8" required><?=$oficina->integrantes ?? ""?></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="modalidade_id">Modalidade: *</label>
                                    <select class="form-control" name="modalidade_id" id="modalidade_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $oficinaObj->geraOpcao('modalidades', $oficina->modalidade_id ?? "", true) ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="data_inicio">Data inicial: *</label><br/>
                                    <input type="date" class="form-control" name="data_inicio" id="data_inicio" value="<?= date("d/m/Y", strtotime($oficina->data_inicio)) ?? "" ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="data_fim">Data final: *</label><br/>
                                    <input type="date" class="form-control" name="data_fim" id="data_fim" value="<?= date("d/m/Y", strtotime($oficina->data_fim)) ?? "" ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="execucao_dia1_id">Dia execução 1: *</label><br/>
                                    <select class="form-control" name="execucao_dia1_id" id="execucao_dia1_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $oficinaObj->geraOpcao('execucao_dias', $oficina->execucao_dia1_id ?? "", false, true) ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="execucao_dia2_id">Dia execução 2: *</label><br/>
                                    <select class="form-control" name="execucao_dia2_id" id="execucao_dia2_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $oficinaObj->geraOpcao('execucao_dias', $oficina->execucao_dia2_id ?? "", false, true) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="nivel">Nível *</label>
                                    <select class="form-control" name="nivel" id="nivel" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $oficinaObj->geraOpcao('ofic_niveis', $oficina->nivel_id ?? "") ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="linguagem_id">Linguagem: *</label>
                                    <select class="form-control" name="linguagem_id" id="linguagem_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $oficinaObj->geraOpcao('ofic_linguagens', $oficina->linguagem_id ?? "") ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="sublinguagem_id">Sub Linguagem: *</label>
                                    <select class="form-control" name="sublinguagem_id" id="sublinguagem_id" required>
                                        <option value="">Selecione uma opção...</option>
                                    </select>
                                </div>
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

<!-- /modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Classificação Indicativa</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h4><strong>Informação e Liberdade de Escolha</strong></h4>
                <p align="justify">A Classificação Indicativa é um conjunto de informações sobre o conteúdo de
                    obras audiovisuais e diversões públicas quanto à adequação de horário, local e faixa etária.
                    Ela alerta os pais ou responsáveis sobre a adequação da programação à idade de crianças e
                    adolescentes. É da Secretaria Nacional de Justiça (SNJ), do Ministério da Justiça (MJ), a
                    responsabilidade da Classificação Indicativa de programas TV, filmes, espetáculos, jogos
                    eletrônicos e de interpretação (RPG).</p>
                <p align="justify">Programas jornalísticos ou noticiosos, esportivos, propagandas eleitorais e
                    publicidade, espetáculos circenses, teatrais e shows musicais não são classificados pelo
                    Ministério da Justiça e podem ser exibidos em qualquer horário.</p>
                <p align="justify">Os programas ao vivo poderão ser classificados se apresentarem inadequações,
                    a partir de monitoramento ou denúncia.</p>
                <p align="justify">
                    <strong>Livre:</strong> Não expõe crianças a conteúdos potencialmente prejudiciais. Exibição
                    em qualquer horário.<br>
                    <strong>10 anos:</strong> Conteúdo violento ou linguagem inapropriada para crianças, ainda
                    que em menor intensidade. Exibição em qualquer horário.<br>
                    <strong>12 anos:</strong> As cenas podem conter agressão física, consumo de drogas e
                    insinuação sexual. Exibição a partir das 20h.<br>
                    <strong>14 anos:</strong> Conteúdos mais violentos e/ou de linguagem sexual mais acentuada.
                    Exibição a partir das 21h.<br>
                    <strong>16 anos:</strong> Conteúdos mais violentos ou com conteúdo sexual mais intenso, com
                    cenas de tortura, suicídio, estupro ou nudez total. Exibição a partir das 22h.<br>
                    <strong>18 anos:</strong> Conteúdos violentos e sexuais extremos. Cenas de sexo, incesto ou
                    atos repetidos de tortura, mutilação ou abuso sexual. Exibição a partir das 23h.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->