<?php


class ViewsModel
{
    protected function verificaModulo ($mod) {
        $modulos = [
            "eventos",
            "formacao",
            "inicio",
            "jovemMonitor",
            "oficina",
            "pessoaFisica",
            "pessoaJurídica",
        ];

        if (in_array($mod, $modulos)) {
            if (is_dir("./views/modulos/" . $mod)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    protected function exibirViewModel($view, $modulo = "") {
        $whitelist = [
            'cadastro',
            'inicio',
            'evento_cadastro',
            'atracao_cadastro',
            'atracao_lista',
            'produtor_cadastro',
            'arquivos_com_prod',
            'pf_cadastro',
            'pj_cadastro',
            'representante_cadastro',
            'informacoes_complementares_cadastro',
            'complemento_oficina_cadastro',
            'evento_lista',
            'proponente',
            'edita',
            'logout',
            'lider_cadastro',
            'lider',
            'proponente_lista',
            'anexos_proponente',
            'anexos_lider'
        ];
        if (self::verificaModulo($modulo)) {
            if (in_array($view, $whitelist)) {
                if (is_file("./views/modulos/$modulo/$view.php")) {
                    $conteudo = "./views/modulos/$modulo/$view.php";
                } else {
                    $conteudo = "./views/modulos/$modulo/inicio.php";
                }
            } else {
                $conteudo = "./views/modulos/$modulo/inicio.php";
            }
        } elseif ($modulo == "login") {
            $conteudo = "login";
        } elseif ($modulo == "cadastro") {
            $conteudo = "cadastro";
        } elseif ($modulo == "index") {
            $conteudo = "login";
        } else {
            $conteudo = "login";
        }

        return $conteudo;
    }

    protected function exibirMenuModel ($modulo) {
        if (self::verificaModulo($modulo)) {
            if (is_file("./views/modulos/$modulo/include/menu.php")) {
                $menu = "./views/modulos/$modulo/include/menu.php";
            } else {
                $menu = "./views/template/menuExemplo.php";
            }
        } else {
            $menu = "./views/template/menuExemplo.php";
        }

        return $menu;
    }
}