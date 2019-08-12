<?php
require_once "./models/ViewsModel.php";

class ViewsController extends ViewsModel
{
    public function exibirTemplate() {
        include "views/template/master.php";
    }

    public function navbar() {
        include "views/template/navbar.php";
    }

    public function sidebar() {
        include "views/template/sidebar.php";
    }

    public function footer() {
        include "views/template/footer.php";
    }
}