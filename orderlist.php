<?php 
include_once "connectdb.php";
session_start();
if($_SESSION['useremail'] == "") {
    header("location: index.php");
}
if($_SESSION['role'] == "Admin") {
    include_once "header.php";
} else {
    include_once "headeruser.php";
}



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

              <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Order List:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
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
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Payment Type</th>
                            <th>Print</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                        $select = $pdo->prepare("select * from invoice order by invoiceid desc");
                        $select->execute();
                        while($row=$select->fetch(PDO::FETCH_OBJ)) {
                            echo '
                            <tr>
                                <td>'.$row->invoiceid.'</td>
                                <td>'.$row->customername.'</td>
                                <td>'.$row->orderdate.'</td>
                                <td>'.$row->ordertotal.'</td>
                                <td>'.$row->orderpaid.'</td>
                                <td>'.$row->orderdue.'</td>
                                <td>'.$row->orderpaymentmethod.'</td>
                                
                                
                                <td>
                                <a href="thermalinvoice.php?id='.$row->invoiceid.'" class="btn btn-warning glyphicon glyphicon-print" style="color:#fff" data-toggle="tooltrip" title="Print Invoice" role="button" target="_blank"></a>
                                </td>
                                <td>
                                <a href="editorder.php?id='.$row->invoiceid.'" class="btn btn-info glyphicon glyphicon-edit" style="color:#fff" data-toggle="tooltrip" title="Edit Order" role="button"></a>
                                </td>
                                <td>
                                <button id='.$row->invoiceid.' class="btn btn-danger glyphicon glyphicon-trash deleteproduct" style="color:#fff" data-toggle="tooltrip" title="Delete Order">
                                </button>
                                </td>
                            
                            </tr>
                            
                            
                            
                            
                            ';
                        }
                        
                        
                        
                        
                        
                        ?>
                        
                    </tbody>
                </table>
                  </div>
                </div>
            
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
      <script>
       $(document).ready( function () {
    $('#ordertable').DataTable({
        "order":[[0,"desc"]]
    });
} );
 
  </script>
  
   <script>
       $(document).ready(function () {
           $('[data-toggle="tooltrip"]').tootrip();
       });
        $(document).ready(function() {
          $(".deleteproduct").click(function() {
              var tag = $(this);
              var productidtag = $(this).attr("id");
              swal({
                  title: "Are you sure?",
                  text: "Once deleted, you will not be able to recover this order!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                        $.ajax({
                  url: "deleteorder.php",
                  type: "post",
                  data: {
                      pidd: productidtag,
                    
                  },
                  success: function(data) {
                      tag.parents("tr").hide();
                  }
              })
 
                      
                    swal("Poof! Your Order has been deleted!", {
                      icon: "success",
                    });
                  } else {
                    swal("Your Order is safe!");
                  }
            });
              
          })
      })

                        
 
  </script>

 <?php 
include_once "footer.php";

?>