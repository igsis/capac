<?php
    require_once "./controllers/ViewsController.php";
    $view = new ViewsController();
    /* Apagar esse bloco após login pronto
    */
//$nomeUser = "Pessoinha Feliz";
//$_SESSION['nome'] = $nomeUser;
    /* */
    $nomeUser = strstr($_SESSION['nome_c'], ' ', true);

?>
<!-- Brand Logo -->
<a href="inicio" class="brand-link">
    <img src="<?= SERVERURL ?>views/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light"><?= NOMESIS ?></span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="<?= SERVERURL ?>inicio/cadastro" class="d-block">Olá, <?= $nomeUser ?>!</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <div class="user-panel pb-3 mb-3">
                <?php
                /** @var ViewsController $view */
                $menu = $view->exibirMenuController();
                if ($menu == 'login') {
                    require_once "./views/template/menuExemplo.php";
                } else {
                    require_once $menu;
                }
                ?>
            </div>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-user"></i>
                    <p>Minha conta</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-question"></i>
                    <p>Ajuda</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-sign-out"></i>
                    <p>Sair</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->