

<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>



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


if(isset($_POST['submit'])) {
   $oldpassword = $_POST['oldpassword'];
$newpassword = $_POST['newpassword'];
$confirmpassword = $_POST['confirmpassword'];
//echo "<br>".$oldpassword."<br>".$newpassword."<br>".$confirmpassword;
$email = $_SESSION['useremail'];
    $select = $pdo->prepare("select * from user where useremail='$email'");
    $select->execute();
    $row=$select->fetch(PDO::FETCH_ASSOC);
    $useremaildb = $row['useremail'];
    $userpassworddb = $row['password'];
    if($userpassworddb == $oldpassword) {
        if($newpassword == $confirmpassword) {
            $update = $pdo->prepare("update user set password=:pass where
            useremail=:email");
            $update->bindParam(":pass", $confirmpassword);
            $update->bindParam(":email", $email);
            if($update->execute()) {
                 echo '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "Password Updated ..",
            text: "",
            icon: "success",
            });
        });
        
        </script>
        
        ';
            }else {
                
                echo '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "Some error occured ..",
            text: "",
            icon: "error",
            });
        });
        
        </script>
        
        ';
            }
            
        }
        else {
            echo '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "New Password and Confirm Password does not match ..",
            text: "",
            icon: "error",
            });
        });
        
        </script>
        
        ';
        }
    }else {
        echo '
        <script type="text/javascript">
        jQuery(function validation() {
             swal({
            title: "Wrong old password ..",
            text: "",
            icon: "error",
            });
        });
        
        </script>
        
        ';
    }
}
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Fill the form!</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputPassword1">Input old password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name ="oldpassword" required>
                </div> 
                 <div class="form-group">
                  <label for="exampleInputPassword1">Input new password</label>
                  <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" name="newpassword" required>
                </div> 
                 <div class="form-group">
                  <label for="exampleInputPassword1">Confirm Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword3" placeholder="Password" name="confirmpassword" required>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
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