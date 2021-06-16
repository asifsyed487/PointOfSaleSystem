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

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Product List:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               <div style="overflow-x: auto;">
                               <table id="producttable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Purchase Price</th>
                            <th>Sale Price</th>
                            <th>Stock</th>
                            <th>Description</th>
                            <th>Images</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                        $select = $pdo->prepare("select * from product");
                        $select->execute();
                        while($row=$select->fetch(PDO::FETCH_OBJ)) {
                            echo '
                            <tr>
                                <td>'.$row->productid.'</td>
                                <td>'.$row->productname.'</td>
                                <td>'.$row->productcategory.'</td>
                                <td>'.$row->productpurchaseprice.'</td>
                                <td>'.$row->productsaleprice.'</td>
                                <td>'.$row->productstock.'</td>
                                <td>'.$row->productdescription.'</td>
                                
                                <td><img src="productimages/'.$row->productimage.'" class="img-rounded" height="40px" width="40px"/></td>
                                <td>
                                <a href="viewproduct.php?id='.$row->productid.'" class="btn btn-success glyphicon glyphicon-eye-open" style="color:#fff" data-toggle="tooltrip" title="View this Product" role="button"></a>
                                </td>
                                <td>
                                <a href="editproduct.php?id='.$row->productid.'" class="btn btn-info glyphicon glyphicon-edit" style="color:#fff" data-toggle="tooltrip" title="Edit this Product" role="button"></a>
                                </td>
                                <td>
                                <button id='.$row->productid.' class="btn btn-danger glyphicon glyphicon-trash deleteproduct" style="color:#fff" data-toggle="tooltrip" title="Delete this Product">
                                </button>
                                
                            
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
    $('#producttable').DataTable({
        "order":[[0,"desc"]]
    });
} );
 
  </script>
  
   <script>
       $(document).ready(function () {
           $('[data-toggle="tooltrip"]').tootrip();
       });
                        
 
  </script>
  
  <script>
      $(document).ready(function() {
          $(".deleteproduct").click(function() {
              var tag = $(this);
              var productidtag = $(this).attr("id");
              swal({
                  title: "Are you sure?",
                  text: "Once deleted, you will not be able to recover this product!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                        $.ajax({
                  url: "deleteproduct.php",
                  type: "post",
                  data: {
                      pidd: productidtag,
                    
                  },
                  success: function(data) {
                      tag.parents("tr").hide();
                  }
              })
 
                      
                    swal("Poof! Your Product has been deleted!", {
                      icon: "success",
                    });
                  } else {
                    swal("Your product is safe!");
                  }
            });
              
          })
      })

</script>

 <?php 
include_once "footer.php";

?>