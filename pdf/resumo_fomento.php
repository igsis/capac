<?php
require_once "../config/configGeral.php";

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../views/plugins/fpdf/fpdf.php";
// ACESSO AO BANCO
$pedidoAjax = true;
require_once "../config/configAPP.php";

// CONSULTA
$id = $_GET['id'];
require_once "../controllers/ProjetoController.php";
$projObj = new ProjetoController();
$projeto = $projObj->recuperaProjeto($id);

$idPj = MainModel::encryption($projeto['pessoa_juridica_id']);

require_once "../controllers/PessoaJuridicaController.php";
$pjObj = new PessoaJuridicaController();
$pj = $pjObj->recuperaPessoaJuridica($idPj);


class PDF extends FPDF
{

}

// GERANDO O PDF:
$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();

$pdf->AddPage();

$x = 20;
$l = 7; //DEFINE A ALTURA DA LINHA
$f = 12; //tamanho da fonte

$pdf->SetXY($x, 25);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(170, $l, utf8_decode("CADASTRO"), 0, 1, 'C');

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(120, $l, utf8_decode(""), '0', 0, 'L');
$pdf->Cell(50, $l, utf8_decode("Protocolo"), 'TLR', 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(120, $l, utf8_decode(""), '0', 0, 'L');
$pdf->Cell(50, $l, utf8_decode($projeto['protocolo']), 'BLR', 1, 'C');

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(50, $l, utf8_decode("Instituição responsável:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($projeto['instituicao']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(58, $l, utf8_decode("Responsável pela inscrição:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($projeto['instituicao']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(15, $l, utf8_decode("E-mail:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($pj['email']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(22, $l, utf8_decode("Telefones:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode(isset($pj['telefones']) ? implode(" | ", $pj['telefones']) : ""), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(22, $l, utf8_decode("Endereço:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->MultiCell(150, $l, utf8_decode($pj['logradouro'] . ", " . $pj['numero'] . " " . $pj['complemento'] . " " . $pj['bairro'] . " - " . $pj['cidade'] . "-" . $pj['uf'] . " CEP: " . $pj['cep']));

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(10, $l, utf8_decode("Site:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($projeto['site']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(35, $l, utf8_decode("Valor do projeto:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode("R$: ".$projeto['valor_projeto']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(44, $l, utf8_decode("Duração (em meses):"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($projeto['duracao']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(35, $l, utf8_decode("Núcleo artístico:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->MultiCell(150, $l, utf8_decode($projeto['nucleo_artistico']));

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(53, $l, utf8_decode("Representante do núcleo:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($projeto['representante_nucleo']), 0, 1, 'L');

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(170, $l, utf8_decode("Cadastro enviado em:"), 0, 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(170, $l, date("d/m/Y H:i:s", strtotime($projeto['data_inscricao'])), 0, 1, 'C');

$pdf->Output();