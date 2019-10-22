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
if ($evento->espaco_publico == 0): $espaco = "Sim"; else: $espaco = "Não"; endif;
if($evento->fomento == 0): $fomento =  "Não"; else: $fomento = "Sim: ".$evento->fomento_nome; endif;
/* rever publico */
foreach ($evento->publicos as $publico) {
    $sql = $eventoObj->listaPublicoEvento($publico);
    $publico = $sql['publico']."; ";
}

/*
foreach ($atracoes as $key => $atracao) {
    $produtor_id = MainModel::encryption($atracao->produtor_id);
    $atracoes[$key]->produtor = (new ProdutorController)->recuperaProdutor($produtor_id)->fetchObject();

    $atracoes[$key]->acoes = (object) $this->recuperaAtracaoAcao($atracao->id);
}
return $atracoes;
*/

require_once "../controllers/AtracaoController.php";
$atracaoObj = new AtracaoController();
$idAtracao = $atracaoObj->getAtracaoId($idEvento);
$cenica = $atracaoObj->verificaCenica($idEvento);

require_once "../controllers/PedidoController.php";
$pedidoObj = new PedidoController();
$pedido = $pedidoObj->recuperaPedido(1);


class PDF extends FPDF
{

}

// GERANDO O PDF:
$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();



$pdf->AddPage();

$x = 20;
$l = 5; //DEFINE A ALTURA DA LINHA
$f = 10; //tamanho da fonte

$pdf->SetXY($x, 15);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(90, 5, utf8_decode("EVENTO"), 0, 0, 'L');
$pdf->Cell(90, 5, utf8_decode("CÓDIGO DO CAPAC ". $evento->id), 0, 1, 'R');

$pdf->SetX($x);
$pdf->Cell(90, 5, utf8_decode($evento->nome_evento), 0, 1, 'L');

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(86, $l, utf8_decode("Espaço em que será realizado o evento é público?"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(85, $l, utf8_decode($espaco), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(22, $l, utf8_decode("É fomento?"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(85, $l, utf8_decode($fomento), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(16, $l, utf8_decode("Público:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(75, $l, utf8_decode($publico), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(17, $l, utf8_decode("Sinopse:"), 0, 0, 'L');
$pdf->SetFont('Arial','', $f);
$pdf->MultiCell(163,$l,utf8_decode($evento->sinopse));

$pdf->Ln(8);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(180, $l, utf8_decode("Atrações"), 'B', 1, 'L');

$pdf->Ln();

foreach ($atracaoObj->listaAtracoes($idEvento) as $atracao) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(31, $l, utf8_decode("Nome da atração:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(146, $l, utf8_decode($atracao->nome_atracao), 0, 1, 'L');

    foreach ($atracao->acoes as $acao){
        $lista_acao = $acao->acao."; ";
    }
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(14, $l, utf8_decode("Ações:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(165, $l, utf8_decode($lista_acao), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(26, $l, utf8_decode("Ficha técnica:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(180,$l,utf8_decode($atracao->ficha_tecnica));

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(22, $l, utf8_decode("Integrantes:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(180,$l,utf8_decode($atracao->integrantes));

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(42, $l, utf8_decode("Classificação indicativa:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(165, $l, utf8_decode($atracao->classificacao_indicativa), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(19, $l, utf8_decode("Realease:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(160,$l,utf8_decode($atracao->release_comunicacao));

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(13, $l, utf8_decode("Links:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(160,$l,utf8_decode($atracao->links));

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(51, $l, utf8_decode("Quantidade de Apresentação:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(10, $l, utf8_decode($atracao->quantidade_apresentacao), 0, 0, 'L');$pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(12, $l, utf8_decode("Valor:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(165, $l, utf8_decode("R$ ".$atracao->valor_individual), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(18, $l, utf8_decode("Produtor:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(10, $l, utf8_decode($atracao->valor_individual), 0, 1, 'L');


    $pdf->Ln();
}

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', $f);
$pdf->MultiCell(180,$l,utf8_decode(""));

$pdf->Ln();
$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(180, $l, utf8_decode(""), 0, 1, 'L');

$pdf->Output();