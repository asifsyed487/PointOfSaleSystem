<?php
require('fpdf/fpdf.php'); // call the fpdf library

include_once "connectdb.php";

$id = $_GET['id'];
$select = $pdo->prepare("select * from invoice where invoiceid='$id'");
$select->execute();
$row= $select->fetch(PDO::FETCH_ASSOC);


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
$pdf->Cell(112,5,"Invoice: ".$row['invoiceid'],0,1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(80,5,"Phone: +8801998126567",0,0, '');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(112,5,"Date: ".$row['orderdate'],0,1, 'C');

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
$pdf->Cell(50,10,$row['customername'],0,1, '');
$pdf->Cell(20,10,"",0,1, '');

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(100,8,"PRODUCT",1,0, 'C', true);
$pdf->Cell(20,8,"QTY",1,0, 'C', true);
$pdf->Cell(30,8,"PRICE",1,0, 'C', true);
$pdf->Cell(40,8,"TOTAL",1,1, 'C', true);

$select = $pdo->prepare("select * from invoicedetails where invoiceid='$id'");
$select->execute();


while($item= $select->fetch(PDO::FETCH_OBJ)) {
$pdf->SetFont('Arial', 'B', 7.5);
$pdf->Cell(100,8,$item->productname,1,0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20,8,$item->productquantity,1,0, 'C');
$pdf->Cell(30,8,$item->productprice,1,0, 'C');
$pdf->Cell(40,8,$item->productprice*$item->productquantity,1,1, 'C');

}
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"SubTotal",1,0, 'C', true);
$pdf->Cell(40,8,$row['ordersubtotal'],1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"Tax",1,0, 'C', true);
$pdf->Cell(40,8,$row['ordertax'],1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"Discount",1,0, 'C', true);
$pdf->Cell(40,8,$row['orderdiscount'],1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"GrandTotal",1,0, 'C', true);
$pdf->Cell(40,8,$row['ordertotal'],1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"Paid",1,0, 'C', true);
$pdf->Cell(40,8,$row['orderpaid'],1,1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"Due",1,0, 'C', true);
$pdf->Cell(40,8,$row['orderdue'],1,1, 'C');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(100,8,"",0,0, 'L');
$pdf->Cell(20,8,"",0,0, 'C');
$pdf->Cell(30,8,"Payment Type",1,0, 'C', true);
$pdf->Cell(40,8,$row['orderpaymentmethod'],1,1, 'C');

$pdf->Cell(50,10,"",0,1, '');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(29,8,"Important Notice :",0,0, '', true);

$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(148,10,"No item will be replaced or refunded if you do not have the invoice with you. You will be able to get the refund within 2 days of purchase.",0,0, '');


$pdf->Output();

?>