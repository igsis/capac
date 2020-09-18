<?php
require_once "./controllers/FormacaoController.php";
$formObj = new FormacaoController();

if (isset($_SESSION['origem_id_c'])){
    $idPf = $_SESSION['origem_id_c'];
    $form = $formObj->recuperaFormacao($idPf)->fetch();
    if ($form){
        $id = MainModel::encryption($form['id']);
    }
}
?>
<li class="nav-item">
    <a href="<?= SERVERURL ?>formacao/inicio" class="nav-link" id="fomentos_inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Lista Cadastros</p>
    </a>
</li>
<hr/>
<?php /*if (!isset($_SESSION['origem_id_c'])): */?><!--
    <li class="nav-item">
        <a href="<?/*= SERVERURL */?>formacao/busca_pf" class="nav-link" id="busca_pf">
            <i class="fa fa-search nav-icon"></i>
            <p>Buscar pessoa física</p>
        </a>
    </li>
--><?php /*endif; */?>

<?php if (isset($_SESSION['pf_form'])){ ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>formacao/pf_cadastro<?= $idPf ? '&id='.$idPf : NULL ?>" class="nav-link" id="dados_cadastrais">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados cadastrais</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>formacao/programa<?= $form != NULL ? '&idC='.$idPf : NULL ?>" class="nav-link" id="programa">
            <i class="far fa-circle nav-icon"></i>
            <p>Detalhes do programa</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>formacao/anexos_proponente" class="nav-link" id="anexos-proponente">
            <i class="far fa-circle nav-icon"></i>
            <p>Anexos</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>formacao/finalizar" class="nav-link" id="finalizar">
            <i class="far fa-circle nav-icon"></i>
            <p>Finalizar</p>
        </a>
    </li>
<?php } ?>
