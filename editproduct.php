<?php 
include_once "connectdb.php";
session_start();
if($_SESSION['useremail'] == "" OR $_SESSION['role'] == "User") {
    header("location: index.php");
}
include_once "header.php";
if(isset($_GET['id'])) {
$id = $_GET['id'];
    $select = $pdo->prepare("select * from product where productid='$id'");
    $select->execute();
    $row=$select->fetch(PDO::FETCH_OBJ);
    $productname = $row->productname;
    $productcategory = $row->productcategory;
    $productpurchaseprice = $row->productpurchaseprice;
    $productsaleprice = $row->productsaleprice;
    $productstock = $row->productstock;
    $productdescription = $row->productdescription;
    $productimage = $row->productimage;
    echo "..............................".$id;
}

if(isset($_POST['updateproduct'])) {
    $productnameupdate = $_POST["productname"];
    $productcategoryupdate = $_POST["productcategory"];
    $productpurchasepriceupdate = $_POST["productpurchaseprice"];
    $productsalepriceupdate = $_POST["productsaleprice"];
    $productstockupdate = $_POST["productstock"];
    $productdescriptionupdate = $_POST["productdescription"];
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
        
    } else{
        if(move_uploaded_file($fTemp, $storeFile)) {
            $productimage = $newFile;
                
            if(!isset($error)) {
                $update = $pdo->prepare("update product set productname=:productname, productcategory=:productcategory, productpurchaseprice=:productpurchaseprice, productsaleprice=:productsaleprice, productstock=:productstock, productdescription=:productdescription, productimage=:productimage where productid='$id'");
                $update->bindParam(":productname", $productnameupdate);
                $update->bindParam(":productcategory", $productcategoryupdate);
                $update->bindParam(":productpurchaseprice", $productpurchasepriceupdate);
                $update->bindParam(":productsaleprice", $productsalepriceupdate);
                $update->bindParam(":productstock", $productstockupdate);
                $update->bindParam(":productdescription", $productdescriptionupdate);
                $update->bindParam(":productimage", $productimage);
                
                
                        if($update->execute()) {
             echo '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "Product Update Success ..",
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
            title: "Product Update Failed ..",
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
    }else {
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
    }else {
        $update = $pdo->prepare("update product set productname=:productname, productcategory=:productcategory, productpurchaseprice=:productpurchaseprice, productsaleprice=:productsaleprice, productstock=:productstock, productdescription=:productdescription, productimage=:productimage where productid='$id'");
        $update->bindParam(":productname", $productnameupdate);
        $update->bindParam(":productcategory", $productcategoryupdate);
        $update->bindParam(":productpurchaseprice", $productpurchasepriceupdate);
        $update->bindParam(":productsaleprice", $productsalepriceupdate);
        $update->bindParam(":productstock", $productstockupdate);
        $update->bindParam(":productdescription", $productdescriptionupdate);
        $update->bindParam(":productimage", $productimage);
        
        if($update->execute()) {
             echo '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "Product Update Success ..",
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
            title: "Product Update Failed ..",
            text: "",
            icon: "error",
            });
        });
        
        </script>
        
        ';
        }
    }
}
        


$select = $pdo->prepare("select * from product where productid='$id'");
    $select->execute();
    $row=$select->fetch(PDO::FETCH_OBJ);
    $productname = $row->productname;
    $productcategory = $row->productcategory;
    $productpurchaseprice = $row->productpurchaseprice;
    $productsaleprice = $row->productsaleprice;
    $productstock = $row->productstock;
    $productdescription = $row->productdescription;
    $productimage = $row->productimage;

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        EDIT PRODUCT
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
            <form role="form" action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
                
                    <div class="col-md-6">
                         <div class="form-group">
                  <label for="exampleInputEmail1">Product Name</label>
                  <input type="text" value="<?php echo $productname; ?>" class="form-control" id="exampleInputEmail1" placeholder="Enter Product Name" name="productname" required>
                </div> 
                     <div class="form-group">
                  <label>Select Category</label>
                  <select class="form-control" name="productcategory" required>
<!--                    <option value="" disabled selected>Select Category</option>-->
                    <?php 
                      
                      $select = $pdo->prepare("select categoryname from category");
                      $select->execute();
                      while($row=$select->fetch(PDO::FETCH_OBJ)) {
                         if($row->categoryname == $productcategory) {
                          echo '
                          <option value="" disabled selected>'.$row->categoryname.'</option>
                          
                          ';
                          }
                          echo '
                          <option>'.$row->categoryname.'</option>
                          
                          ';
                      }
                      
                      
                      
                      ?>
                    
                  </select>
                </div>
                    <div class="form-group">
                  <label for="exampleInputEmail1">Purchase Price</label>
                  <input type="number" value="<?php echo $productpurchaseprice; ?>" min="1" step="1" class="form-control" id="exampleInputEmail1" placeholder="Enter Product's Purchase Price" name="productpurchaseprice" required>
                </div> 
                 <div class="form-group">
                  <label for="exampleInputEmail1">Sale Price</label>
                  <input type="number" value="<?php echo $productsaleprice; ?>" min="1" step="1" class="form-control" id="exampleInputEmail1" placeholder="Enter Product's Sale Price" name="productsaleprice" required>
                </div>
                    </div>
                    <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Stock</label>
                  <input type="number" value="<?php echo $productstock; ?>" min="1" step="1" class="form-control" id="exampleInputEmail1" placeholder="Enter Product's Stock" name="productstock" required>
                </div> 
                 <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea id="exampleInputEmail1" type="text" class="form-control" id="exampleInputEmail1" placeholder="About the Product .." name="productdescription" cols="30" rows="5" ><?php echo $productdescription; ?></textarea>
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Product Image</label>
                  <img src="productimages/<?php echo $productimage; ?>" class="img-responsive" height="40px" width="40px"/>
                  <input type="file" class="input-group" id="exampleInputEmail1" placeholder="Enter Product's Stock" name="productimage">
                  <p>Input Product's Image</p>
                </div> 
                </div>
                
            
             </div>
             <div class="box-footer">
                <button type="submit" class="btn btn-warning" name="updateproduct">UPDATE PRODUCT</button>
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