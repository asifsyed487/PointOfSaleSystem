<?php 
include_once "connectdb.php";
session_start();
if($_SESSION['useremail'] == "" OR $_SESSION['role'] == "User") {
    header("location: index.php");
}
include_once "header.php";



if(isset($_POST['submit'])){
    
 $categoryname = $_POST['categoryname'];
    
    
if(empty( $categoryname)){
    
 $error='<script type="text/javascript">
jQuery(function validation(){


swal({
  title: "Feild is Empty!",
  text: "Please Fill Feild!!",
  icon: "error",
  button: "Ok",
});


});

</script>';   
    
  echo $error;  
    
    
    
}
    
    
if(!isset($error)){
    
$insert = $pdo->prepare("insert into category(categoryname) values(:categoryname)");
$insert->bindParam(":categoryname", $categoryname);
    
if($insert->execute()){
   
    echo '<script type="text/javascript">
jQuery(function validation(){


swal({
  title: "Added!",
  text: "Your Category is Added!",
  icon: "success",
  button: "Ok",
});


});

</script>';
    
    
    
    
}else{
 echo '<script type="text/javascript">
jQuery(function validation(){


swal({
  title: "Error",
  text: "Query Fail!",
  icon: "error",
  button: "Ok",
});


});

</script>';
    
}    
}        
}


if(isset($_POST['update'])) {
    $categoryid = $_POST['categoryid'];
    $categoryname = $_POST['categoryname'];
    if(!empty($categoryid AND $categoryname)) {
        $update = $pdo->prepare("update category set categoryname=:categoryname where categoryid=:categoryid");
        $update->bindParam(":categoryid", $categoryid);
        $update->bindParam(":categoryname", $categoryname);
        $update->execute();
        if($update->rowCount()) {
             echo '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "Category Update Success ..",
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
            title: "Category Update Failed ..",
            text: "",
            icon: "error",
            });
        });
        
        </script>
        
        ';
        }
        
        
    }
}





if(isset($_POST['id'])){
    
 $delete=$pdo->prepare("delete from category where categoryid=".$_POST['id']); 
    
  
    
    
   if($delete->execute()){
       
       echo '<script type="text/javascript">
jQuery(function validation(){


swal({
  title: "Deleted!",
  text: "Your Category is Deleted!",
  icon: "success",
  button: "Ok",
});


});

</script>'; 
       
   }else{
       echo '<script type="text/javascript">
jQuery(function validation(){


swal({
  title: "Error!",
  text: "Your Category is Not Deleted!",
  icon: "success",
  button: "Ok",
});


});

</script>';
       
       
       
       
       
   } 
    
    
}

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Categories
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
              <h3 class="box-title">Categories Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
            
              <div class="box-body">
               <?php 
                   if(isset($_POST['edit'])) {
                       $edit = $_POST['edit'];
                        $select = $pdo->prepare("select * from category where categoryid='$edit'");
                        $select->execute();
                        while($row=$select->fetch(PDO::FETCH_OBJ)){
                        echo '
            <div class="col-md-4">
                <div class="form-group">
                  <label >category</label>
                  <input type="hidden" value="'.$row->categoryid.'"  class="form-control" id="exampleInputEmail1" placeholder="Enter Category Name" name="categoryid">
                  
                  <input type="text" value="'.$row->categoryname.'"  class="form-control" id="exampleInputEmail1" placeholder="Enter Category Name" name="categoryname">
                </div> 
              
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-warning" name="update">Update</button>
              </div>
            </div>
                       
                       
                       
                       
                       ';
                        }
                       
                   } else {
                       echo '
                           <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">category</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Category Name" name="categoryname">
                </div> 
              
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-warning" name="submit">Submit</button>
              </div>
            </div>
                       
                       
                       
                       
                       ';
                   }
                   
                   
                   
                   
                   ?>
            <div class="col-md-8">
                <table id="categorytable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $select = $pdo->prepare("select * from category");
                        $select->execute();
                        while($row=$select->fetch(PDO::FETCH_OBJ)) {
                            echo '
                            <tr>
                                <td>'.$row->categoryid.'</td>
                                <td>'.$row->categoryname.'</td>
                                <td>
                                <button type="submit" value="'.$row->categoryid.'" class="btn btn-success" name="edit">EDIT</button>
                                </td>
                                <td>
                                <button type="submit" value="'.$row->categoryid.'" class="btn btn-danger glyphicon glyphicon-trash" name="id"></button>
                                </td>
                                
                            
                            </tr>
                                 
                            ';
                            }
                        
                        
                                ?>
                    </tbody>
                </table>
            </div>
            </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
       $(document).ready( function () {
    $('#categorytable').DataTable();
} );
 
  </script>
  
 <?php 
include_once "footer.php";

?>