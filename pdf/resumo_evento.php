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
$l = 6; //DEFINE A ALTURA DA LINHA
$f = 11; //tamanho da fonte

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
$pdf->Cell(95, $l, utf8_decode("Espaço em que será realizado o evento é público?"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(85, $l, utf8_decode($espaco), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(24, $l, utf8_decode("É fomento?"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(85, $l, utf8_decode($fomento), 0, 1, 'L');

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


$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(128, $l, utf8_decode("São Paulo, _______ / _______ / " . date('Y') . "."), 0, 1, 'L');


$pdf->Output();