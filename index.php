<?php
session_start();
require_once 'includes/Dbconnect.php';

if (isset($_SESSION['username'])!="") {
header("Location: user/home");
exit;
}

if (isset($_POST['btn-login'])) {
 $username =  trim($_POST['username']);
 $password =  trim($_POST['password']);
 $username = strip_tags($_POST['username']);
 $password = strip_tags($_POST['password']);
 $username = $DBcon->real_escape_string($username);
 $password = $DBcon->real_escape_string($password);
 $pass = sha1($password);

 $query = "SELECT log_username, log_status, log_category, log_password FROM user_login WHERE log_username ='$username' AND log_password = '$pass' ";
 $result = $DBcon->query($query);
 $row = $result->fetch_array();

 $count = $result->num_rows; // if username/password are correct returns must be 1 row
   //echo $row['log_username'];
 if ($count==1) {
    if($row['log_status'] == 1)
      {
        if($row['log_category'] == 0)
          {
             $_SESSION['username'] = $row['log_username'];
             $_SESSION['categorySession'] = $row['log_category'];
             $_SESSION['status'] = $row['log_status'];

             header("Location: user/home");
             exit;
          }
       if($row['log_category'] == 1)
          {
            $_SESSION['username'] = $row['log_username'];
            $_SESSION['categorySession'] = $row['log_category'];
            $_SESSION['status'] = $row['log_status'];
            header("Location: admin/home");
            exit;
          }
      }
    if($row['log_status'] == 0)
      {
        $msg = "<div class='alert alert-danger'>
        <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Account is Deactivated!.Contact Admin </div>";
      }
 }
 else {
      $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password !</div>";
 }
 $DBcon->close();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bus Booking</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css"> <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <span class="logo-mini"><b><img src="dist/img/bus1.png" alt="Smiley face" height="42" width="42"></b></span>
            <a href="home.php"><b>BUS BOOKING</b></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form id="form-login" method="post">
                <?php 
    if(isset($msg)){
      echo $msg;
    }
    ?>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="username" placeholder="Username">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn-login">Sign
                            In</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
    </script>
</body>

</html>