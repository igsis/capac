<li class="nav-item">
    <a href="<?= SERVERURL ?>formacao/inicio" class="nav-link" id="evento_cc_inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Dados necessários</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>formacao/proponente" class="nav-link" id="proponente">
        <i class="far fa-circle nav-icon"></i>
        <p>Cadastro</p>
    </a>
</li>
<?php if (isset($_SESSION['origem_id_c'])){ ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>formacao/informacoes_complementares" class="nav-link" id="informacoes_complementares">
            <i class="far fa-circle nav-icon"></i>
            <p>Cadastro</p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?= SERVERURL ?>formacao/anexos_proponente" class="nav-link" id="anexos-proponente">
                    <div class="row">
                        <div class="col-3"><i class="ml-3 far fa-dot-circle nav-icon"></i></div>
                        <div class="col-9">Anexos</div>
                    </div>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>formacao/programa" class="nav-link" id="programa">
            <i class="far fa-circle nav-icon"></i>
            <p>Programa</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>formacao/demais_anexos" class="nav-link" id="demais_anexos">
            <i class="far fa-circle nav-icon"></i>
            <p>Demais anexos</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>formacao/finalizar" class="nav-link" id="finalizar">
            <i class="far fa-circle nav-icon"></i>
            <p>Finalizar</p>
        </a>
    </li>
<?php } ?>
