<?php 
include "connectdb.php";
session_start();

if($_SESSION['useremail'] == "" OR $_SESSION['role'] == "User") {
    header("location: index.php");
}
include_once "header.php";
if(isset($_GET['id'])) {
$id = $_GET['id'];
if(!empty($id)) {
    $delete = $pdo->prepare("delete from user where userid='$id'");
    if($delete->execute()) {
        echo '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "Account Successfully Deleted ..",
            text: "",
            icon: "success",
            });
        });
        
        </script>
        
        ';
    }
}

}
if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $useremail = $_POST['useremail'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    if(!empty($username && $useremail && $password && $role)) {
        $select = $pdo->prepare("select * from user where useremail='$useremail'");
        $select->execute();
        if($select->rowCount()) {
                  echo '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "Account Already Exists ..",
            text: "",
            icon: "warning",
            });
        });
        
        </script>
        
        ';
        } else {
        $insert = $pdo->prepare("insert into user(username, useremail, password, role) values(:username, :useremail, :password, :role)");
        $insert->bindParam(":username", $username);
        $insert->bindParam(":useremail", $useremail);
        $insert->bindParam(":password", $password);
        $insert->bindParam(":role", $role);
        $insert->execute();
        if($insert->rowCount()) {
             echo '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "Registration Success ..",
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
            title: "Registration Failed ..",
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


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Registration
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
            <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Registration Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <form role="form" action="" method="post">
            <div class="box-body">
             <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Username</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter username" name="username" required>
                </div> 
                 <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="useremail" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
                </div>
                 <div class="form-group">
                  <label>Select</label>
                  <select class="form-control" name="role" required>
                    <option value="" disabled selected>Select Role</option>
                    <option>User</option>
                    <option>Admin</option>
                  </select>
                </div>
              
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              </div>
            </div>
                        <div class="col-md-8">
               <div style="overflow-x: auto;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>username</th>
                            <th>useremail</th>
                            <th>password</th>
                            <th>role</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                        $select = $pdo->prepare("select * from user");
                        $select->execute();
                        while($row=$select->fetch(PDO::FETCH_OBJ)) {
                            echo '
                            <tr>
                                <td>'.$row->userid.'</td>
                                <td>'.$row->username.'</td>
                                <td>'.$row->useremail.'</td>
                                <td>'.$row->password.'</td>
                                <td>'.$row->role.'</td>
                                <td>
                                <a href="registration.php?id='.$row->userid.'" class="btn btn-danger glyphicon glyphicon-trash" role="button"></a>
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
            </form>

          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php 
include_once "footer.php";

?>