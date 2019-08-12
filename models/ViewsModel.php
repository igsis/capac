<?php


class ViewsModel
{
    protected function listaModulos ($mod) {
        $modulos = [
            'emendaParlamentar',
            'eventos',
            'jovemMonitor',
            'oficina',
            'pessoaFisica',
            'pessoaJurídica',
        ];

        if (in_array($mod, $modulos)) {
            if (is_dir("./views/modulos/" . $mod)) {
                $modulo = "./views/modulos/".$mod;
            } else {
                $modulo = "./view/modulos";
            }
        } else {
            $modulo = "./view/modulos";
        }

        return $modulo;
    }

    protected function exibirViewModel($view) {
        $modulos = [
            'home',
        ];
        $modulo = self::listaModulos($view);
        if (in_array($view, $modulos)) {
            if (is_file("./views/modulos/".$view."")) {

            }
        }
    }
}