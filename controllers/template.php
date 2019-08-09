<?php

    class TemplateController {
        public function template() {
            include "views/master/template.php";
        }

        public function navbar() {
            include "views/master/navbar.php";
        }

        public function sidebar() {
            include "views/master/sidebar.php";
        }

        public function content() {
          include "views/master/content.php";
        }

        public function footer() {
          include "views/master/footer.php";
        }
    }