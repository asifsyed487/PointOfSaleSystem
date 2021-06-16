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
$pdf = new FPDF('P', 'mm', array(80,200));
//P -> potrait L-> landscape
//pt, mm, cm, in -> measure unit
// A3, A4, A5, Letter, Legal -> format of pages
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(60,8,"NORSHAF LTD.",1,1, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(60,5,"Address: Japan",0,1, 'C');
$pdf->Cell(60,5,"Phone: +8801998126567",0,1, 'C');
$pdf->Cell(60,5,"email: norshaf@gmail.com",0,1, 'C');
$pdf->Cell(60,5,"website: norshaf.com",0,1, 'C');

//Line(x1,y1,x2,y2);

$pdf->Line(7,38,72,38);

$pdf->Ln(1); //line break

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(20,4,"Bill To :",0,0, '');

$pdf->SetFont('Courier', 'BI', 8);
$pdf->Cell(40,4,$row['customername'],0,1, '');

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(20,4,"Invoice No :",0,0, '');

$pdf->SetFont('Courier', 'BI', 8);
$pdf->Cell(40,4,$row['invoiceid'],0,1, '');

$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(20,4,"Date :",0,0, '');

$pdf->SetFont('Courier', 'BI', 8);
$pdf->Cell(40,4,$row['orderdate'],0,1, '');

$pdf->SetFont('Courier', 'B', 8);
$pdf->SetX(7);
$pdf->Cell(34,5,"PRODUCT",1,0, 'C');
$pdf->Cell(8,5,"QTY",1,0, 'C');
$pdf->Cell(13,5,"PRICE",1,0, 'C');
$pdf->Cell(12,5,"TOTAL",1,1, 'C');

$select = $pdo->prepare("select * from invoicedetails where invoiceid='$id'");
$select->execute();


while($item= $select->fetch(PDO::FETCH_OBJ)) {
$pdf->SetX(7);
$pdf->SetFont('Helvetica', 'B', 6);
$pdf->Cell(34,5,$item->productname,1,0, 'L');
$pdf->SetFont('Helvetica', 'B', 6);
$pdf->Cell(8,5,$item->productquantity,1,0, 'C');
$pdf->Cell(13,5,$item->productprice,1,0, 'C');
$pdf->Cell(12,5,$item->productprice*$item->productquantity,1,1, 'C');

}

$pdf->SetX(9);
$pdf->SetFont('Courier', 'B', 8);
//$pdf->Cell(20,5,"",0,0, 'C');
$pdf->Cell(20,5,"",0,0, 'L');
$pdf->Cell(25,5,"SUBTOTAL",1,0, 'C');
$pdf->Cell(20,5,$row['ordersubtotal'],1,1, 'C');

$pdf->SetX(9);
$pdf->SetFont('Courier', 'B', 8);
//$pdf->Cell(20,5,"",0,0, 'C');
$pdf->Cell(20,5,"",0,0, 'L');
$pdf->Cell(25,5,"TAX(5%)",1,0, 'C');
$pdf->Cell(20,5,$row['ordertax'],1,1, 'C');

$pdf->SetX(9);
$pdf->SetFont('Courier', 'B', 8);
//$pdf->Cell(20,5,"",0,0, 'C');
$pdf->Cell(20,5,"",0,0, 'L');
$pdf->Cell(25,5,"DISCOUNT",1,0, 'C');
$pdf->Cell(20,5,$row['orderdiscount'],1,1, 'C');

$pdf->SetX(9);
$pdf->SetFont('Courier', 'B', 8);
//$pdf->Cell(20,5,"",0,0, 'C');
$pdf->Cell(20,5,"",0,0, 'L');
$pdf->Cell(25,5,"GRAND TOTAL",1,0, 'C');
$pdf->Cell(20,5,$row['ordertotal'],1,1, 'C');

$pdf->SetX(9);
$pdf->SetFont('Courier', 'B', 8);
//$pdf->Cell(20,5,"",0,0, 'C');
$pdf->Cell(20,5,"",0,0, 'L');
$pdf->Cell(25,5,"PAID",1,0, 'C');
$pdf->Cell(20,5,$row['orderpaid'],1,1, 'C');

$pdf->SetX(9);
$pdf->SetFont('Courier', 'B', 8);
//$pdf->Cell(20,5,"",0,0, 'C');
$pdf->Cell(20,5,"",0,0, 'L');
$pdf->Cell(25,5,"DUE",1,0, 'C');
$pdf->Cell(20,5,$row['orderdue'],1,1, 'C');

$pdf->SetX(9);
$pdf->SetFont('Courier', 'B', 8);
//$pdf->Cell(20,5,"",0,0, 'C');
$pdf->Cell(20,5,"",0,0, 'L');
$pdf->Cell(25,5,"PAYMENT TYPE",1,0, 'C');
$pdf->Cell(20,5,$row['orderpaymentmethod'],1,1, 'C');


$pdf->Cell(20,5,"",0,1, '');

$pdf->SetX(7);
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(25,5,"Important Notice :",0,1, '');

$pdf->SetX(7);
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(75,5,"No item will be replaced or refunded if you do not have the invoice with you.",0,2, '');

$pdf->SetX(7);
$pdf->SetFont('Arial', '', 5);
$pdf->Cell(75,5,"You will be able to get the refund within 2 days of purchase.",0,1, '');

//$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(112,5,"Date: ".$row['orderdate'],0,1, 'C');


$pdf->Output();
?>