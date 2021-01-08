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
    <a href="<?= SERVERURL ?>oficina/inicio" class="nav-link" id="fomentos_inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Lista Cadastros</p>
    </a>
</li>
<hr/>

<li class="nav-item">
    <a href="<?= SERVERURL ?>oficina/oficina_cadastro&idC=<?= $_SESSION['origem_id_c'] ?? "" ?>" class="nav-link" id="oficina">
        <i class="far fa-circle nav-icon"></i>
        <p>Dados da oficina</p>
    </a>
</li>
<?php if (isset($_SESSION['origem_id_c'])) { ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/oficina_complemento_cadastro&idC=<?= $_SESSION['origem_id_c'] ?>" class="nav-link" id="oficina">
            <i class="far fa-circle nav-icon"></i>
            <p>Complemento da oficina</p>
        </a>
    </li>
<?php } ?>
<?php if (isset($_SESSION['pj_id_c'])){ ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/pj_dados_cadastro<?= $idPj ? '&idPj='.$idPj : NULL ?>" class="nav-link" id="dados_cadastrais">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados da empresa</p>
        </a>
    </li>
<?php } ?>
<?php if (isset($_SESSION['lider_id_c'])){ ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/lider_dados_cadastro<?= $idLider ? '&idLider='.$idLider : NULL ?>" class="nav-link" id="dados_cadastrais">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados pessoais</p>
        </a>
    </li>
<?php } ?>
<?php
if (isset($_SESSION['pf_id_c'])){
    $idPf = $_SESSION['pf_id_c'];
    ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/pf_dados_cadastro<?= $idPf ? '&idPf='.$idPf : NULL ?>" class="nav-link" id="dados_cadastrais">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados pessoais</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/pf_endereco_cadastro<?= $idPf ? '&idPf='.$idPf : NULL ?>" class="nav-link" id="dados_endereco">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados de endereço</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/pf_banco_cadastro<?= $idPf ? '&idPf='.$idPf : NULL ?>" class="nav-link" id="dados_bancarios">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados bancários</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/anexos" class="nav-link" id="anexos">
            <i class="far fa-circle nav-icon"></i>
            <p>Anexos pessoais</p>
        </a>
    </li>

    <?php $_SESSION['origem_id_c'] = $_SESSION['pf_id_c'] ?>

    <?php if (isset($_SESSION['origem_id_c'])) { ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>oficina/oficina_cadastro&idC=<?= $_SESSION['origem_id_c'] ?>" class="nav-link" id="oficina">
                <i class="far fa-circle nav-icon"></i>
                <p>Dados da oficina</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>oficina/oficina_complemento_cadastro&idC=<?= $_SESSION['origem_id_c'] ?>" class="nav-link" id="oficina">
                <i class="far fa-circle nav-icon"></i>
                <p>Complemento da oficina</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>oficina/anexos" class="nav-link" id="anexos">
                <i class="far fa-circle nav-icon"></i>
                <p>Anexos pessoais</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>oficina/anexos" class="nav-link" id="anexos">
                <i class="far fa-circle nav-icon"></i>
                <p>Anexos comunic./produc.</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>oficina/finalizar" class="nav-link" id="finalizar">
                <i class="far fa-circle nav-icon"></i>
                <p>Finalizar</p>
            </a>
        </li>
    <?php } else { ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>oficina/oficina_cadastro&idPf=<?= $idPf ?>" class="nav-link" id="oficina">
                <i class="far fa-circle nav-icon"></i>
                <p>Dados da oficina</p>
            </a>
        </li>
    <?php } ?>
<?php } ?>