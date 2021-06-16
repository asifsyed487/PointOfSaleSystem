<?php 
include_once "connectdb.php";
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
        PRODUCT | VIEW
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
        <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">
                   <a href="productlist.php" class="btn btn-info" role="button">BACK TO PRODUCT LIST</a>
              </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
              <?php
                  $id=$_GET['id'];
                 $select = $pdo->prepare("select * from product where productid='$id'");
                        $select->execute();
                        while($row=$select->fetch(PDO::FETCH_OBJ)) {
              echo'
              <div class="col-md-6">
                <ul class="list-group">
                 <center> <p class="list-group-item list-group-item-success"><b>PRODUCT DETAILS</b></p> </center>
                 <li class="list-group-item"><b>Product ID </b><span class="badge">'.$row->productid.'</span></li>
                 <li class="list-group-item"><b>Product Name</b> <span class="label label-info pull-right">'.$row->productname.'</span></li>
                 <li class="list-group-item"><b>Category</b> <span class="label label-primary pull-right">'.$row->productcategory.'</span></li>
                 <li class="list-group-item"><b>Purchase Price</b> <span class="label label-warning pull-right">'.$row->productpurchaseprice.'</span></li>
                 <li class="list-group-item"><b>Sale Price </b><span class="label label-warning pull-right">'.$row->productsaleprice.'</span></li>
                 <li class="list-group-item"><b>Profit </b><span class="label label-success pull-right">'.$row->productsaleprice - $row->productpurchaseprice.'</span></li>
                 <li class="list-group-item"><b>Stock </b><span class="label label-info pull-right">'.$row->productstock.'</span></li>
                 <li class="list-group-item"><b>Description: - </b><span>'.$row->productdescription.'</span></li>
                 
                </ul>
              </div>
               <div class="col-md-6">
                <ul class="list-group">
                 <center> <p class="list-group-item list-group-item-success"><b>PRODUCT IMAGE</b></p> </center>
                 <center>
                  <img src="productimages/'.$row->productimage.'" class="img-responsive" />
                  </center>
                </ul>
              </div>
                  ';
                        }
                  ?>
            </div>
            </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php 
include_once "footer.php";

?>