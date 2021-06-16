<?php

include "connectdb.php";
session_start();
if($_SESSION['useremail'] == "") {
    header('location:index.php');
}

$select = $pdo->prepare("select sum(ordertotal) as totalorder, count(invoiceid) as totalinvoice from invoice");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);
$totalorder = $row->totalinvoice;
$nettotal = $row->totalorder;


  $select = $pdo->prepare("select orderdate, ordertotal from invoice group by orderdate LIMIT 30");

    $select->execute();
    $totalorderarray = [];
    $orderdatearray = [];
    while($row=$select->fetch(PDO::FETCH_ASSOC)) {
           extract($row);
           $totalorderarray[] = $ordertotal;
           $orderdatearray[] = $orderdate;
           
       }
//                            echo json_encode($total);
//                        $netTotal = $row->ordertotal;
//                        $subtotal = $row->ordersubtotal;
//                        $totalinvoice = $row->totalinvoice;


include_once "header.php";
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Admin Dashboard
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <div class="box-body">
                <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $totalorder; ?></h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="orderlist.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo "$".number_format($nettotal, 2); ?></h3>

              <p>Total Revenue</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="graphreport.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        
        
        
        <?php
        
        $select = $pdo->prepare("select count(productname) as totalproduct from product");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $totalproduct = $row->totalproduct;
          
          ?>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo "$".number_format($totalproduct); ?></h3>

              <p>Total Products</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="productlist.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <?php
        
        $select = $pdo->prepare("select count(categoryname) as totalcategory from category");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $totalcategory = $row->totalcategory;
          
          ?>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo "$".number_format($totalcategory); ?></h3>

              <p>Total Categories</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="category.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
        <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">EARNING BY DATE</h3>
            </div>
                <div class="box-body">
                    <div class="chart">
                    <canvas id="earningbydate" style="height: 250px;"></canvas>
                </div>
                </div>
          </div>
          
           <div class="row">
               <div class="col-md-6">
                   <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">BEST SELLING PRODUCT</h3>
            </div>
                <div class="box-body">
                <div style="overflow-x: auto;">
                <table id="bestsellingproduct" class="table table-striped">
                    <thead>
                        <tr>
<!--                            <th>#</th>-->
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                        $select = $pdo->prepare("select productid, productname, productquantity, productprice, sum(productquantity) as totalproductquantity, sum(productquantity*productprice) as totalproductprice from invoicedetails group by productid order by sum(productquantity) DESC LIMIT 15");
                        $select->execute();
                        while($row=$select->fetch(PDO::FETCH_OBJ)) {
                            echo '
                            <tr>
                                <td>'.$row->productid.'</td>
                                <td>'.$row->productname.'</td>
                                <td><span class="label label-info">'.$row->totalproductquantity.'</span></td>
                                <td><span class="label label-success">'."$".$row->productprice.'</span></td>
                                <td><span class="label label-danger">'."$".$row->totalproductprice.'</span></td>
                            
                             
                            
                            </tr>
                            
                            
                            
                            
                            ';
                        }
                        
                        
                        
                        
                        
                        ?>
                        
                    </tbody>
                </table>
                    </div>
                </div>
          </div>
               </div>
               <div class="col-md-6">
                           <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">RECENT ORDERS</h3>
            </div>
                <div class="box-body">
                <div style="overflow-x: auto;">
                <table id="ordertable" class="table table-striped">
                    <thead>
                        <tr>
<!--                            <th>#</th>-->
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>Total</th>
                            <th>Payment Type</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                        $select = $pdo->prepare("select * from invoice order by invoiceid desc LIMIT 15");
                        $select->execute();
                        while($row=$select->fetch(PDO::FETCH_OBJ)) {
                            echo '
                            <tr>
                                <td> <a href="editorder.php?id='.$row->invoiceid.'">'.$row->invoiceid.'</a></td>
                                <td>'.$row->customername.'</td>
                                <td>'.$row->orderdate.'</td>
                                <td><span class="label label-danger">'."$".$row->ordertotal.'</td>

                            ';
                            if($row->orderpaymentmethod == "cash") {
                                echo'<td><span class="label label-primary">'.$row->orderpaymentmethod.'</span></td>';
                            } else if($row->orderpaymentmethod == "card") {
                                echo'<td><span class="label label-warning">'.$row->orderpaymentmethod.'</span></td>';
                            } else {
                                echo'<td><span class="label label-info">'.$row->orderpaymentmethod.'</span></td>';
                            }
                            echo "</tr>";
                        }
                        
                        
                        
                        
                        
                        ?>
                        
                    </tbody>
                </table>
                    </div>
                </div>
          </div>
               </div>
           </div> 
          
          
          
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


    <script>
    var ctx = document.getElementById('earningbydate').getContext('2d');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($orderdatearray); ?>,
        datasets: [{
            label: 'Earning By Date',
            backgroundColor: 'rgb(59, 160, 76)',
            borderColor: 'rgb(255, 99, 132)',
            data: <?php echo json_encode($totalorderarray); ?>
        }]
    },

    // Configuration options go here
    options: {}
});
</script>
<!--
<script>
       $(document).ready( function () {
    $('#bestsellingproduct').DataTable({
        
    });
} );
 
  </script>
   <script>
       $(document).ready( function () {
    $('#ordertable').DataTable({
        "order":[[0,"desc"]]
    });
} );
 
  </script>
-->
 <?php 
include_once "footer.php";

?>