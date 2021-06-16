<?php
ini_set('magic_quotes_runtime', 0);
require('fpdf/fpdf.php'); // call the fpdf library

//A4 width: 219mm
//default margin: 10mm each side
    //writable horizonal: 219-(10*2) = 199mm
    
//create pdf object
$pdf = new FPDF('P', 'mm', 'A4');
//P -> potrait L-> landscape
//pt, mm, cm, in -> measure unit
// A3, A4, A5, Letter, Legal -> format of pages

$pdf->AddPage();
$pdf->SetFillColor(123,255,234);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(80,10,"NORSHAF LTD.",0,0, '');

$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(112,10,"INVOICE",0,1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(80,5,"Address: Japan",0,0, '');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(112,5,"Invoice : #12345 ",0,1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(80,5,"Phone: +8801998126567",0,0, '');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(112,5,"Date: 28-12-2020",0,1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(80,5,"email: norshaf@gmail.com",0,1, '');
$pdf->Cell(80,5,"website: norshaf.com",0,1, '');

//Line(x1,y1,x2,y2);

$pdf->Line(5,45,205,45);
$pdf->Line(5,46,205,46);

$pdf->Ln(10); //line break

$pdf->SetFont('Arial', 'BI', 12);
$pdf->Cell(20,10,"Bill To :",0,0, '');

$pdf->SetFont('Courier', 'BI', 14);
$pdf->Cell(50,10,"Asif Syed",0,1, '');
$pdf->Cell(20,10,"",0,1, '');

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(100,8,"PRODUCT",1,0, 'C', true);
$pdf->Cell(20,8,"QTY",1,0, 'C', true);
$pdf->Cell(30,8,"PRICE",1,0, 'C', true);
$pdf->Cell(40,8,"TOTAL",1,1, 'C', true);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"Iphone",1,0, 'L');
$pdf->Cell(20,8,"1",1,0, 'C');
$pdf->Cell(30,8,"800",1,0, 'C');
$pdf->Cell(40,8,"800",1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"Samsung A20s",1,0, 'L');
$pdf->Cell(20,8,"1",1,0, 'C');
$pdf->Cell(30,8,"600",1,0, 'C');
$pdf->Cell(40,8,"600",1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"Hard Disk",1,0, 'L');
$pdf->Cell(20,8,"2",1,0, 'C');
$pdf->Cell(30,8,"300",1,0, 'C');
$pdf->Cell(40,8,"600",1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"SubTotal",1,0, 'C', true);
$pdf->Cell(40,8,"600",1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"Tax",1,0, 'C', true);
$pdf->Cell(40,8,"60",1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"Discount",1,0, 'C', true);
$pdf->Cell(40,8,"30",1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"GrandTotal",1,0, 'C', true);
$pdf->Cell(40,8,"6600",1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"Paid",1,0, 'C', true);
$pdf->Cell(40,8,"7000",1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"Due",1,0, 'C', true);
$pdf->Cell(40,8,"400",1,1, 'C');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"Payment Type",1,0, 'C', true);
$pdf->Cell(40,8,"Cash",1,1, 'C');

$pdf->Cell(50,10,"",0,1, '');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(29,8,"Important Notice :",0,0, '', true);

$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(148,10,"No item will be replaced or refunded if you do not have the invoice with you. You will be able to get the refund within 2 days of purchase.",0,0, '');


$pdf->Output();

?>