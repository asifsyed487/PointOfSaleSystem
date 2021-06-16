<?php 
include_once "connectdb.php";
error_reporting(0);
session_start();
if($_SESSION['useremail'] == "" OR $_SESSION['role'] == "User") {
    header("location: index.php");
}
include_once "header.php";



?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        GRAPH REPORT
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">FROM : <?php echo $_POST['date1'] ?> TO : <?php echo $_POST['date2'] ?></h3>
            </div>
            <form role="form" action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
                              <div class="row">
                    <div class="col-md-5">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="date1" data-date-format="yyyy-mm-dd" id="datepicker1" autocomplete="off">
                </div>
                    </div>
                    <div class="col-md-5">
                                        <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="date2" data-date-format="yyyy-mm-dd" id="datepicker2" autocomplete="off">
                </div>
                    </div>
                    <div class="col-md-2">
                        <div align="center">
                    <input type="submit" value="Filter by Date" class="btn btn-success" name="datefilter">
                </div>
                    </div>
                </div>
                <br>
                <br>
                <?php
                    $select = $pdo->prepare("select orderdate, sum(ordertotal) as price from invoice where orderdate between :fromdate AND :todate group by orderdate");
                        $select->bindParam(':fromdate', $_POST['date1']);
                        $select->bindParam(':todate', $_POST['date2']);
                        $select->execute();
                  $total = [];
                  $date = [];
                         while($row=$select->fetch(PDO::FETCH_ASSOC)) {
                             extract($row);
                             $total[] = $price;
                             $date[] = $orderdate;
                             
                         }
//                            echo json_encode($total);
//                        $netTotal = $row->ordertotal;
//                        $subtotal = $row->ordersubtotal;
//                        $totalinvoice = $row->totalinvoice;
                  ?>
                
                <div class="chart">
                    <canvas id="myChart" style="height: 250px;"></canvas>
                </div>
                
                
                <br>
                <br>
                <?php
                    $select = $pdo->prepare("select productname, sum(productquantity) as q from invoicedetails where orderdate between :fromdate AND :todate group by productid");
                        $select->bindParam(':fromdate', $_POST['date1']);
                        $select->bindParam(':todate', $_POST['date2']);
                        $select->execute();
                  $pname = [];
                  $qty = [];
                         while($row=$select->fetch(PDO::FETCH_ASSOC)) {
                             extract($row);
                             $pname[] = $productname;
                             $qty[] = $q;
                             
                         }
//                            echo json_encode($total);
//                        $netTotal = $row->ordertotal;
//                        $subtotal = $row->ordersubtotal;
//                        $totalinvoice = $row->totalinvoice;
                  ?>
<!--                  <?php echo json_encode($pname); ?>-->
                   <div class="chart">
                    <canvas id="bestsellingproduct" style="height: 250px;"></canvas>
                </div>
                </div>
          </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($date); ?>,
        datasets: [{
            label: 'TOTAL EARNING',
            backgroundColor: 'rgb(115, 239, 235)',
            borderColor: 'rgb(255, 99, 132)',
            data: <?php echo json_encode($total); ?>
        }]
    },

    // Configuration options go here
    options: {}
});
</script>
   
   
    <script>
        var ctx = document.getElementById('bestsellingproduct').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($pname); ?>,
        datasets: [{
            label: 'TOTAL QUANTITY',
            backgroundColor: 'rgb(138, 224, 118)',
            borderColor: 'rgb(54, 132, 50)',
            data: <?php echo json_encode($qty); ?>
        }]
    },

    // Configuration options go here
    options: {}
});
</script>

<script>
//Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    });
    $('#datepicker2').datepicker({
      autoclose: true
    });
</script>

 <?php 
include_once "footer.php";

?>