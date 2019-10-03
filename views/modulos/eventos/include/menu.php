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
    <?php
    if (isset($_SESSION['pedido_id_c'])):
        require_once "./controllers/PedidoController.php";
        $pedidoObj = new PedidoController();

        $idPedido = $pedidoObj->getPedido($_SESSION['pedido_id_c']);

        $pedido = $pedidoObj->consultaSimples("SELECT * FROM pedidos WHERE id = $idPedido AND pessoa_juridica_id IS NOT NULL");
        if ($pedido->rowCount()>0):
        ?>
            <li class="nav-item">
                <a href="<?= SERVERURL ?>eventos/lider" class="nav-link" id="proponente">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Líder</p>
                </a>
            </li>
        <?php endif;?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>eventos/proponente" class="nav-link" id="proponente">
                <i class="far fa-circle nav-icon"></i>
                <p>Anexos</p>
            </a>
        </li>
    <?php endif; ?>
<?php endif; ?>