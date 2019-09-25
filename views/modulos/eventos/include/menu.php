<li class="nav-item">
    <a href="<?= SERVERURL ?>eventos/inicio" class="nav-link" id="evento_cc_inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Dados necessários</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>eventos/evento_lista" class="nav-link" id="evento_lista">
        <i class="far fa-circle nav-icon"></i>
        <p>Eventos</p>
    </a>
</li>
<?php if (isset($_SESSION['evento_id_c'])): ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>eventos/evento_cadastro" class="nav-link" id="evento_cc_cadastro">
            <i class="far fa-circle nav-icon"></i>
            <p>Informações Iniciais</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>eventos/atracao_lista" class="nav-link" id="atracao_lista">
            <i class="far fa-circle nav-icon"></i>
            <p>Atrações</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>eventos/arquivos_com_prod" class="nav-link" id="com_prod">
            <i class="far fa-circle nav-icon"></i>
            <p>Comunicação/Produção</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>eventos/proponente" class="nav-link" id="proponente">
            <i class="far fa-circle nav-icon"></i>
            <p>Proponente</p>
        </a>
    </li>
<?php endif; ?>