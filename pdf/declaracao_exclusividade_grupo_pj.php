<?php
require_once "../config/configGeral.php";

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../views/plugins/fpdf/fpdf.php";
// ACESSO AO BANCO
$pedidoAjax = true;
require_once "../config/configAPP.php";


class PDF extends FPDF
{

    // Simple table
    function BasicTable($header, $data)
    {
        // Header
        foreach ($header as $col)
            $this->Cell(40, 7, $col, 1);
        $this->Ln();
        // Data
        foreach ($data as $row) {
            foreach ($row as $col)
                $this->Cell(40, 6, $col, 1);
            $this->Ln();
        }
    }

    // Simple table
    function Cabecalho($header, $data)
    {
        // Header
        foreach ($header as $col)
            $this->Cell(40, 7, $col, 1);
        $this->Ln();
        // Data
    }
    // Simple table
    function Tabela($header, $data)
    {
        //Data
        foreach ($data as $col)
            $this->Cell(40, 7, $col, 1);
        $this->Ln();
        // Data
    }
}

// CONSULTA
require_once "../controllers/EventoController.php";
$eventoObj = new EventoController();
session_start(['name' => 'cpc']);
$idEvento = $eventoObj->descriptografia($_SESSION['origem_id_c']);
$evento = $eventoObj->consultaSimples("
    SELECT pf.nome AS lider_nome, pf.rg AS lider_rg, pf.cpf AS lider_cpf, pj.razao_social, rl.nome AS rep_nome, rl.rg AS rep_rg, rl.cpf AS rep_cpf, a.integrantes
    FROM eventos AS eve
        INNER JOIN pedidos AS ped ON eve.id = ped.origem_id
        INNER JOIN atracoes a on eve.id = a.evento_id
        INNER JOIN pessoa_juridicas pj on ped.pessoa_juridica_id = pj.id
        INNER JOIN representante_legais rl on pj.representante_legal1_id = rl.id
        INNER JOIN lideres l on a.id = l.atracao_id
        INNER JOIN pessoa_fisicas pf on l.pessoa_fisica_id = pf.id
    WHERE ped.origem_tipo_id = 1 AND ped.publicado = 1 AND eve.id = '$idEvento';
")->fetchAll(PDO::FETCH_ASSOC);

$teste = $evento['razao_social'];

// GERANDO O PDF:
$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x = 15;
$l = 5; //DEFINE A ALTURA DA LINHA
$f = 9; //tamanho da fonte

$pdf->SetXY($x, 15);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(180, 5, utf8_decode("DECLARAÇÃO DE EXCLUSIVIDADE"), 0, 1, 'C');

$pdf->Ln();

$pdf->SetX($x);

var_dump($evento);

$pdf->SetFont('Arial', '', $f);
$pdf->MultiCell(180, $l, utf8_decode("Eu, " . $teste . ", RG " . $evento->lider_rg . ", CPF " . "$evento->lider_cpf" . ", sob penas da lei, declaro que sou líder do grupo " . "grupo" . " e que o mesmo é representado exclusivamente pela empresa " . "pjRazaoSocial" . ". Estou ciente de que o pagamento dos valores decorrentes dos serviços do grupo é de responsabilidade da nossa representante, não nos cabendo pleitear à Prefeitura quaisquer valores eventualmente não repassados."));

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->MultiCell(180, $l, utf8_decode("Estou ciente de que o pagamento dos valores decorrentes dos serviços do grupo é de responsabilidade da nossa representante, não nos cabendo pleitear à Prefeitura quaisquer valores eventualmente não repassados."));
/*
if ($rep02Nome != '') {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(180, $l, utf8_decode("" . "$pjRazaoSocial" . ", representada por " . "$rep01Nome" . ", RG " . "$rep01RG" . ", CPF " . "$rep01CPF" . " e " . "$rep02Nome" . ", RG " . "$rep02RG" . ", CPF " . "$rep02CPF" . ", declara sob penas da lei ser representante do grupo " . "$grupo" . ""));
} else {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(180, $l, utf8_decode("" . "$pjRazaoSocial" . ", representada por " . "$rep01Nome" . ", RG " . "$rep01RG" . ", CPF " . "$rep01CPF" . " declara sob penas da lei ser representante do grupo " . "$grupo" . "."));
}

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->MultiCell(180, $l, utf8_decode("Declaro, sob as penas da lei, que eu e os integrantes abaixo listados, não somos servidores públicos municipais e que não nos encontramos em impedimento para contratar com a Prefeitura do Município de São Paulo / Secretaria Municipal de Cultura, mediante recebimento de cachê e/ou bilheteria, quando for o caso. "));

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->MultiCell(180, $l, utf8_decode("Declaro, sob as penas da lei, dentre os integrantes abaixo listados não há crianças e adolescentes. Quando houver, estamos cientes que é de nossa responsabilidade a adoção das providências de obtenção  de  decisão judicial  junto à Vara da Infância e Juventude."));

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->MultiCell(180, $l, utf8_decode("Declaro, ainda, neste ato, que autorizo, a título gratuito, por prazo indeterminado, a Municipalidade de São Paulo, através da SMC, o uso da nossa imagem, voz e performance nas suas publicações em papel e qualquer mídia digital, streaming ou internet existentes ou que venha a existir como também para os fins de arquivo e material de pesquisa e consulta."));

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->MultiCell(180, $l, utf8_decode("A empresa fica autorizada a celebrar contrato, inclusive receber cachê e/ou bilheteria quando for o caso, outorgando quitação."));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->MultiCell(170, $l, utf8_decode("Integrantes do grupo: " . "$integrantes" . ""));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(128, $l, utf8_decode("São Paulo, _______ / _______ / " . $ano . "."), 0, 1, 'L');

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(128, 4, utf8_decode("_______________________________"), 0, 1, 'L');
$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(128, 4, utf8_decode("Nome do Líder do Grupo: " . "$exNome" . ""), 0, 1, 'L');
$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(128, 4, utf8_decode("RG: " . "$exRG" . ""), 0, 1, 'L');
$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(128, 4, utf8_decode("CPF: " . "$exCPF" . ""), 0, 1, 'L');

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(128, 4, utf8_decode("_______________________________"), 0, 1, 'L');
$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(128, 4, utf8_decode("Representante Legal 1: " . "$rep01Nome" . ""), 0, 1, 'L');
$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(128, 4, utf8_decode("RG: " . "$rep01RG" . ""), 0, 1, 'L');
$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(128, 4, utf8_decode("CPF: " . "$rep01CPF" . ""), 0, 1, 'L');

$pdf->Ln();

if ($rep02Nome != '') {

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(128, 4, utf8_decode("_______________________________"), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(128, 4, utf8_decode("Representante Legal 2: " . "$rep02Nome" . ""), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(128, 4, utf8_decode("RG: " . "$rep02RG" . ""), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(128, 4, utf8_decode("CPF: " . "$rep02CPF" . ""), 0, 1, 'L');
}
*/

$pdf->Output();


?>