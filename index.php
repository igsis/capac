<?php
require_once "config/configGeral.php";
require_once "controllers/ViewsController.php";

spl_autoload_register(function($class) {
    if (file_exists("./controllers/$class.php")) {
        require_once "./controllers/$class.php";
        return true;
    }
});

$template = new ViewsController();

$template->exibirTemplate();