<li class="nav-item">
    <a href="<?= SERVERURL ?>oficina/dados_necessarios" class="nav-link">
        <i class="fa fa-info nav-icon"></i>
        <p>Dados necessários</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>oficina/evento_lista" class="nav-link">
        <i class="fa fa-list-alt nav-icon"></i>
        <p>Oficinas</p>
    </a>
</li>
<?php if (isset($_SESSION['origem_id_c'])): ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/evento_cadastro" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Informações iniciais</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/complemento_oficina_cadastro" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados complementares</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>oficina/arquivos_com_prod" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Comunicação/Produção</p>
        </a>
    </li>
    <?php
    if (isset($_SESSION['pedido_id_c'])) {
        ?>
        <li class="nav-item has-treeview menu-open" id="itens-proponente">
            <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i>
                <p>
                    Proponente
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= SERVERURL ?>oficina/proponente_lista" class="nav-link" id="proponentes-cadastrados">

                        <div class="row">
                            <div class="col-3"><i class="ml-3 far fa-dot-circle nav-icon"></i></div>
                            <div class="col-9">Cadastro</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= SERVERURL ?>oficina/anexos_proponente" class="nav-link" id="anexos-proponente">
                        <div class="row">
                            <div class="col-3"><i class="ml-3 far fa-dot-circle nav-icon"></i></div>
                            <div class="col-9">Anexos</div>
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <?php
    } else {
        ?>

        <li class="nav-item">
            <a href="<?= SERVERURL ?>oficina/proponente" class="nav-link" id="proponente">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Proponente
                </p>
            </a>
        </li>
        <?php
    }
    ?>
<?php endif; ?>