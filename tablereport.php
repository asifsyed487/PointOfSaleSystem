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
        SALES REPORT -> TABLE REPORT
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
                    $select = $pdo->prepare("select sum(ordertotal) as ordertotal, sum(ordersubtotal) as ordersubtotal, count(invoiceid) as totalinvoice  from invoice where orderdate between :fromdate AND :todate");
                        $select->bindParam(':fromdate', $_POST['date1']);
                        $select->bindParam(':todate', $_POST['date2']);
                        $select->execute();
                         $row=$select->fetch(PDO::FETCH_OBJ);
                        $netTotal = $row->ordertotal;
                        $subtotal = $row->ordersubtotal;
                        $totalinvoice = $row->totalinvoice;
                  ?>
                      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL INVOICE</span>
              <span class="info-box-number"><?php echo number_format($totalinvoice); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->


        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">SUB TOTAL</span>
              <span class="info-box-number"><?php echo number_format($subtotal, 2); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">NET TOTAL</span>
              <span class="info-box-number"><?php echo number_format($netTotal, 2); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    <br>
                <table id="salesreporttable" class="table table-striped">
                    <thead>
                        <tr>
<!--                            <th>#</th>-->
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>SUBTOTAL</th>
                            <th>TAX</th>
                            <th>DISCOUNT</th>
                            <th>TOTAL</th>
                            <th>PAID</th>
                            <th>DUE</th>
                            <th>DATE</th>
                            <th>PAYMENT METHOD</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php 
                        $select = $pdo->prepare("select * from invoice where orderdate between :fromdate AND :todate");
                        $select->bindParam(':fromdate', $_POST['date1']);
                        $select->bindParam(':todate', $_POST['date2']);
                        $select->execute();
                        while($row=$select->fetch(PDO::FETCH_OBJ)) {
                            echo '
                            <tr>
                                <td>'.$row->invoiceid.'</td>
                                <td>'.$row->customername.'</td>
                                <td>'.$row->ordersubtotal.'</td>
                                <td>'.$row->ordertax.'</td>
                                <td>'.$row->orderdiscount.'</td>
                                <td><span class="label label-danger">'."$".$row->ordertotal.'</span></td>
                                <td>'.$row->orderpaid.'</td>
                                <td>'.$row->orderdue.'</td>
                                
                                <td>'.$row->orderdate.'</td>
                           
                            
                            
                            
                            
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
          </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
   <script>
 //Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    });
    $('#datepicker2').datepicker({
      autoclose: true
    });
    $('#salesreporttable').DataTable({
        "order":[[0,"desc"]]
    });
</script>

 <?php 
include_once "footer.php";

?>