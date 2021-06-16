<?php 
include "connectdb.php";
session_start();
if($_SESSION['useremail'] == "" OR $_SESSION['role'] == "") {
    header("location: index.php");
}






function watch_products($pdo) {
    $output = '';
    $select = $pdo->prepare("select * from product order by productname asc");
    $select->execute();
    $result = $select->fetchall();
    foreach($result as $row) {
        $output .= '<option value="'.$row['productid'].'">'.$row['productname'].'</option>';
    }
    return $output;
    
}
if(isset($_POST["saveorder"])) {
    $customername = $_POST['customername'];
    $orderdate = date('Y-m-d',strtotime($_POST['orderdate']));
    $ordersubtotal = $_POST['ordersubtotal'];
    $ordertax = $_POST['ordertax'];
    $orderdiscount = $_POST['orderdiscount'];
    $ordertotal = $_POST['ordertotal'];
    $orderpaid = $_POST['orderpaid'];
    $orderdue = $_POST['orderdue'];
    $orderpaymentmethod = $_POST['orderpaymentmethod'];
    
    $inarrayproductid = $_POST['productid'];
    $inarrayproductname= $_POST['productname'];
    $inarrayproductstock= $_POST['productstock'];
    $inarrayproductquantity= $_POST['productquantity'];
    $inarrayproductprice= $_POST['productprice'];
    $inarrayproductotal= $_POST['producttotal'];
    
    $insert = $pdo->prepare("insert into invoice(customername, orderdate, ordersubtotal, ordertax, orderdiscount, ordertotal, orderpaid, orderdue, orderpaymentmethod) values(:customername, :orderdate, :ordersubtotal, :ordertax, :orderdiscount, :ordertotal, :orderpaid, :orderdue, :orderpaymentmethod)");
        $insert->bindParam(":customername", $customername);
        $insert->bindParam(":orderdate", $orderdate);
        $insert->bindParam(":ordersubtotal", $ordersubtotal);
        $insert->bindParam(":ordertax", $ordertax);
        $insert->bindParam(":orderdiscount", $orderdiscount);
        $insert->bindParam(":ordertotal", $ordertotal);
        $insert->bindParam(":orderpaid", $orderpaid);
        $insert->bindParam(":orderdue", $orderdue);
        $insert->bindParam(":orderpaymentmethod", $orderpaymentmethod);
        $insert->execute();
    
    $invoiceid = $pdo->lastInsertId();
    if($invoiceid != null) {
        for($i=0; $i<count($inarrayproductid); $i++) {
            $rem_qty = $inarrayproductstock[$i]-$inarrayproductquantity[$i];
    
            if($rem_qty<0){
                
                return"Order Is Not Complete";
            }else{
                
       $update=$pdo->prepare("update product SET productstock ='$rem_qty' where productid='".$inarrayproductid[$i]."'");
        
        $update->execute();
        
        
    }
            
            
            
            
            $insert = $pdo->prepare("insert into invoicedetails(invoiceid, productid, productname,	productquantity, productprice, orderdate) values(:invoiceid, :productid, :productname, :productquantity, :productprice, :orderdate)");
        $insert->bindParam(":invoiceid", $invoiceid);
        $insert->bindParam(":productid", $inarrayproductid[$i]);
        $insert->bindParam(":productname", $inarrayproductname[$i]);
        $insert->bindParam(":productquantity", $inarrayproductquantity[$i]);
        $insert->bindParam(":productprice", $inarrayproductprice[$i]);
        $insert->bindParam(":orderdate", $orderdate);
        $insert->execute();
            
           
        }
//         echo"Successfully created order";
        header("location:orderlist.php");
    }
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
        Create Order
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
                 <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">
                    <a href="orderlist.php" class="btn btn-info" role="button">BACK TO ORDER LIST</a>
              </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
                
                <div class="col-md-6">
                <div class="form-group">
                <label for="exampleInputEmail1">Customer Name</label>
                 <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                     <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Customer Name" name="customername" required></div>
                </div> 
                </div>
                <div class="col-md-6">
                <div class="form-group">
                <label>Date:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="orderdate" value="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>
                </div>
                
                
            
             </div>
                <div class="box-body">
                    <div class="col-md-12">
                       <div style="overflow-x: auto;">
                        <table id="producttable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Search Product</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Enter Quantity</th>
                            <th>Total</th>
                            <th><center>
                                <button type="button" class="btn btn-sm btn-success glyphicon glyphicon-plus orderadd" name="orderadd">
                                </button>
                                </center>
                            </th>
                        </tr>
                    </thead>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                  <label for="exampleInputEmail1">SubTotal</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-dollar"></i>
                  </div>
                      <input type="text" class="form-control" placeholder="" name="ordersubtotal" id="ordersubtotal" required readonly> </div>
                </div>        
                  <div class="form-group">
                  <label for="exampleInputEmail1">Tax(5%)</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-dollar"></i>
                  </div>
                      <input type="text" class="form-control" placeholder="" name="ordertax" id="ordertax" required readonly> </div>
                </div>       
                   <div class="form-group">
                  <label for="exampleInputEmail1">Discount</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-dollar"></i>
                  </div>
                      <input type="text" class="form-control" placeholder="" name="orderdiscount" id="orderdiscount" required> </div>
                </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                  <label for="exampleInputEmail1">Total</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-dollar"></i>
                  </div>
                      <input type="text" class="form-control" placeholder="" name="ordertotal" id="ordertotal" required readonly> </div>
                </div>        
                  <div class="form-group">
                  <label for="exampleInputEmail1">Paid</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-dollar"></i>
                  </div>
                      <input type="text" class="form-control" placeholder="" name="orderpaid" id="orderpaid" required> </div>
                </div>       
                   <div class="form-group">
                  <label for="exampleInputEmail1">Due</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-dollar"></i>
                  </div>
                      <input type="text" class="form-control" placeholder="" name="orderdue" id="orderdue" required readonly> </div>
                </div> 
                <label for="">Payment Method</label>
                <div class="form-group">
                <label>
                  <input type="radio" name="orderpaymentmethod" class="minimal-red" value="cash" checked>CASH
                </label>
                <label>
                  <input type="radio" name="orderpaymentmethod" class="minimal-red" value="card">CARD
                </label>
                <label>
                  <input type="radio" name="orderpaymentmethod" class="minimal-red" value="check">CHECK
                </label>
              </div>
                    </div>
                </div>
                <div align="center">
                    <input type="submit" value="Save Order" class="btn btn-success" name="saveorder">
                </div>
             
             </form>
             
            </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
 //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
      
 //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    });
      
      $(document).ready(function(){
    $(document).on('click', '.orderadd', function() {
        var html='';
        html += '<tr>';
        html += '<td> <input type="hidden" class="form-control pid" name="productname[]" readonly></td>';
        html += '<td><select class="form-control pname" name="productid[]" style="width: 250px;"> <option value="" disabled selected>Select Product</option> <?php echo watch_products($pdo); ?> </select></td>';
        html += '<td> <input type="text" class="form-control pstock" name="productstock[]" readonly></td>';
        html += '<td> <input type="text" class="form-control pprice" name="productprice[]" readonly></td>';
        html += '<td> <input type="number" min="1" class="form-control pquantity" name="productquantity[]"></td>';
        html += '<td> <input type="text" class="form-control ptotal" name="producttotal[]" readonly></td>';
        html += '<td> <center> <button type="button" class="btn btn-sm btn-danger glyphicon glyphicon-remove orderremove" name="remove"> </button></center></td>';
        html += '</tr>';
        $('#producttable').append(html);
        $('.pname').select2()
        
          $(".pname").on("change", function(e) {
          var productid = this.value;
            var tr = $(this).parent().parent();
//              console.log(productid);
              console.log(tr);
          $.ajax({
              url: "getproduct.php",
              method:"get",
              data:{
                  id:productid
              },
              success:function(data) {
//                  console.log(data);
                    tr.find(".pid").val(data["productname"]);
                    tr.find(".pstock").val(data["productstock"]);
                    tr.find(".pprice").val(data["productsaleprice"]);
                    tr.find(".pquantity").val(1);
                    tr.find(".ptotal").val( tr.find(".pprice").val() *  tr.find(".pquantity").val());
                  calculate(0,0);
                    
              }
          })
      })
    });
      
      $(document).on('click', '.orderremove', function() {
          $(this).closest('tr').remove();
          calculate(0,0);
          $("#orderpaid").val(0);
      });
      
      $("#producttable").delegate(".pquantity", "keyup change", function() {
          var quantity = $(this);
          var tr = $(this).parent().parent();
          if((quantity.val()-0) > (tr.find(".pstock").val()-0)) {
              swal("WARNING!", "SORRY! This much of quantity is not available", "warning");
              quantity.val(1);
              tr.find(".ptotal").val(tr.find(".pprice").val() *  quantity.val());
              calculate(0,0);
          } else {
              tr.find(".ptotal").val(quantity.val() * tr.find(".pprice").val());
              calculate(0,0);
          }
          
      });
        function calculate(dis, paid) {
            var ordersubtotal = 0;
            var ordertax=0;
            var orderdiscount=dis;
            var ordertotal=0;
            var orderpaid=paid;
            var orderdue=0;
            
            $(".ptotal").each(function() {
                ordersubtotal = ordersubtotal+($(this).val()*1);
            })
            
            ordertax = 0.05 * ordersubtotal;
            ordertotal = (ordertax + ordersubtotal)-orderdiscount;
            orderdue= ordertotal-orderpaid;
            console.log(orderdue);
            
            $("#ordersubtotal").val(ordersubtotal.toFixed(2));
            $("#ordertax").val(ordertax.toFixed(2));
            
            $("#ordertotal").val(ordertotal.toFixed(2));
            $("#orderdiscount").val(orderdiscount);
            $("#orderdue").val(orderdue.toFixed(2));
            
        }
        $("#orderdiscount").keyup(function() {
            var discount = $(this).val();
            calculate(discount, 0);
        })
        $("#orderpaid").keyup(function() {
            var paid = $(this).val();
            var discount = $("#orderdiscount").val();
            calculate(discount, paid);
        })
      
      })
      
    
      </script>

 <?php 
include_once "footer.php";

?>