<?php
    require_once "./controllers/ViewsController.php";
    $view = new ViewsController();
    if(isset($_SESSION['nome'])){
        $nomeUser = $_SESSION['nome'];
    }
    else{
        $nomeUser = "Pessoinha";
    }
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
            <?php
            /** @var ViewsController $view */
            $menu = $view->exibirMenuController();
            if ($menu == 'login') {
                require_once "./views/template/menuExemplo.php";
            } else {
                require_once $menu;
            }
            ?>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->