<?php
require_once "./controllers/OficinaController.php";
$oficObj = new OficinaController();

if (isset($_SESSION['origem_id_c'])){
    $idPf = $_SESSION['origem_id_c'];
    $ofic = $oficObj->recuperaOficina($_SESSION['usuario_id_c']);
    if ($ofic){
        $id = MainModel::encryption($ofic->id);
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
<?php if (isset($_SESSION['origem_id_c'])){ ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/pf_dados_cadastro<?= $idPf ? '&id='.$idPf : NULL ?>" class="nav-link" id="dados_cadastrais">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados pessoais</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/pf_endereco_cadastro<?= $idPf ? '&id='.$idPf : NULL ?>" class="nav-link" id="dados_endereco">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados de endereço</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/pf_banco_cadastro<?= $idPf ? '&id='.$idPf : NULL ?>" class="nav-link" id="dados_bancarios">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados bancários</p>
        </a>
    </li>

    <?php if (isset($_SESSION['oficina_id_c'])) { ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>oficina/oficina_cadastro&idC=<?= $_SESSION['oficina_id_c'] ?>" class="nav-link" id="programa">
                <i class="far fa-circle nav-icon"></i>
                <p>Dados da oficina</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>oficina/anexos" class="nav-link" id="anexos">
                <i class="far fa-circle nav-icon"></i>
                <p>Anexos</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>oficina/finalizar" class="nav-link" id="finalizar">
                <i class="far fa-circle nav-icon"></i>
                <p>Finalizar</p>
            </a>
        </li>
    <?php } ?>
<?php } ?>