<?php 

include_once "connectdb.php";
session_start();
if($_SESSION['useremail'] == "" OR $_SESSION['role'] == "User") {
    header("location: index.php");
}



include_once "header.php";

if(isset($_POST['addproduct'])) {
    $productname = $_POST["productname"];
    $productcategory = $_POST["productcategory"];
    $productpurchaseprice = $_POST["productpurchaseprice"];
    $productsaleprice = $_POST["productsaleprice"];
    $productstock = $_POST["productstock"];
    $productdescription = $_POST["productdescription"];
    $jinishupdate = $_FILES["productimage"]["name"];
    
    if(!empty($jinishupdate)) {
    $jinish = $_FILES["productimage"];
//    echo"..................................................................";
//    print_r($_FILES['productimage']);
    $fileName = $jinish["name"];
//    echo"..................................................................";
//    echo $productname;
    $fTemp = $_FILES["productimage"]["tmp_name"];
//    echo "<br />";
//    echo"..................................................................";
//    echo $productcategory;
    $fileNameToArray = explode(".", $fileName);
//    echo "<br />";
//    echo"..................................................................";
//    print_r($productpurchaseprice);
    
    $fileExtension = strtolower(end($fileNameToArray));
//    echo "<br />";
//    echo"..................................................................";
//    echo $productsaleprice;
    
    $newFile = uniqid().".".$fileExtension;
//    echo "<br />";
//    echo"..................................................................";
//    echo $productstock;

    $storeFile = "productimages/".$newFile;
//    echo "<br />";
//    echo"..................................................................";
//    echo $productdescription;
  
    $fileSize = $_FILES["productimage"]["size"];
//    echo "<br />";
//    echo"..................................................................";
//    print_r( $jinish);
    
    
    if($fileExtension == "jpg" || $fileExtension == "jpeg" || $fileExtension == "png" || $fileExtension == "gif" ) {
        if($fileSize>=26214400) {
        $error= '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "File Size exceeded ..",
            text: "File can not be more than 23mb ..",
            icon: "warning",
            });
        });
        
        </script>
        
        ';
        echo $error;
        } else {
            if(move_uploaded_file($fTemp, $storeFile)) {
                $productimage = $newFile;
                
    if(!isset($error)) {
        $insert = $pdo->prepare("insert into product(productname, productcategory, productpurchaseprice, productsaleprice, productstock, productdescription, productimage) values(:productname, :productcategory, :productpurchaseprice, :productsaleprice, :productstock, :productdescription, :productimage)");
        $insert->bindParam(":productname", $productname);
        $insert->bindParam(":productcategory", $productcategory);
        $insert->bindParam(":productpurchaseprice", $productpurchaseprice);
        $insert->bindParam(":productsaleprice", $productsaleprice);
        $insert->bindParam(":productstock", $productstock);
        $insert->bindParam(":productdescription", $productdescription);
        $insert->bindParam(":productimage", $productimage);
        $insert->execute();
        if($insert->rowCount()) {
             echo '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "Product Added ..",
            text: "",
            icon: "success",
            });
        });
        
        </script>
        
        ';
        } else {
             echo '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "Product Add Failed ..",
            text: "",
            icon: "error",
            });
        });
        
        </script>
        
        ';
        }
    }
            }
        }
    } else {
        $error= '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "Only jpg, jpeg, png and gif file supports ..",
            text: "",
            icon: "warning",
            });
        });
        
        </script>
        
        ';
        echo $error;
    }
    }
    
    
//    
}


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Product:
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
                    <a href="productlist.php" class="btn btn-info" role="button">BACK TO PRODUCT LIST</a>
              </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
                
                    <div class="col-md-6">
                         <div class="form-group">
                  <label for="exampleInputEmail1">Product Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Product Name" name="productname" required>
                </div> 
                     <div class="form-group">
                  <label>Select Category</label>
                  <select class="form-control" name="productcategory" required>
                    <option value="" disabled selected>Select Category</option>
                    <?php 
                      
                      $select = $pdo->prepare("select categoryname from category");
                      $select->execute();
                      while($row=$select->fetch(PDO::FETCH_OBJ)) {
                          echo '
                          <option>'.$row->categoryname.'</option>
                          
                          ';
                      }
                      
                      
                      ?>
                    
                  </select>
                </div>
                    <div class="form-group">
                  <label for="exampleInputEmail1">Purchase Price</label>
                  <input type="number" min="1" step="1" class="form-control" id="exampleInputEmail1" placeholder="Enter Product's Purchase Price" name="productpurchaseprice" required>
                </div> 
                 <div class="form-group">
                  <label for="exampleInputEmail1">Sale Price</label>
                  <input type="number" min="1" step="1" class="form-control" id="exampleInputEmail1" placeholder="Enter Product's Sale Price" name="productsaleprice" required>
                </div>
                    </div>
                    <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Stock</label>
                  <input type="number" min="1" step="1" class="form-control" id="exampleInputEmail1" placeholder="Enter Product's Stock" name="productstock" required>
                </div> 
                 <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea id="exampleInputEmail1" type="text" class="form-control" id="exampleInputEmail1" placeholder="About the Product .." name="productdescription" cols="30" rows="5" ></textarea>
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Product Image</label>
                  <input type="file" class="input-group" id="exampleInputEmail1" placeholder="Enter Product's Stock" name="productimage">
                  <p>Input Product's Image</p>
                </div> 
                </div>
                
            
             </div>
             <div class="box-footer">
                <button type="submit" class="btn btn-success" name="addproduct">ADD</button>
              </div>
             </form>
             
            </div>
            
            

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php 
include_once "footer.php";

?>