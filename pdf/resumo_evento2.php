<?php
require_once "../config/configGeral.php";

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../views/plugins/fpdf/fpdf.php";
// ACESSO AO BANCO
$pedidoAjax = true;
require_once "../config/configAPP.php";

// CONSULTA
require_once "../controllers/EventoController.php";
$eventoObj = new EventoController();
session_start(['name' => 'cpc']);
$idEvento = $_SESSION['origem_id_c'];
$evento = $eventoObj->recuperaEvento($idEvento);

require_once "../controllers/AtracaoController.php";
$atracaoObj = new AtracaoController();
$idAtracao = $atracaoObj->getAtracaoId($idEvento);
$cenica = $atracaoObj->verificaCenica($idEvento);

require_once "../controllers/PedidoController.php";
$pedidoObj = new PedidoController();
$pedido = $pedidoObj->recuperaPedido(1);

?>
<script>
var pdfMake = require("../views/plugins/pdfmake/build/pdfmake");
var pdfFonts = require("../views/plugins/pdfmake/build/vfs_fonts");
pdfMake.vfs = pdfFonts.pdfMake.vfs;
</script>
<body>
<script>
    var htmlToPdfMake = require("html-to-pdfmake");

    var html = htmlToPdfMake(`
  <p>
    This sentence has <strong>a highlighted word</strong>, but not only.
  </p>
  `);

    var docDefinition = {
        content: [
            html
        ],
        styles:{
            'html-strong':{
                background:'yellow' // it will add a yellow background to all <STRONG> elements
            }
        }
    };

    var pdfDocGenerator = pdfMake.createPdf(docDefinition);
</script>
</body>

