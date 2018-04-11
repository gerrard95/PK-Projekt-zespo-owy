<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Logowanie</title>
    <!-- Bootstrap core CSS-->
    <link href="admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="admin/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">

<?php
require('include/db.php');
session_start();

if (isset($_POST['username'])){


    $username = stripslashes($_REQUEST['username']);

    $username = mysqli_real_escape_string($con,$username);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con,$password);



    if(!$_POST["username"] || !$_POST["password"])
    {
        header("Location: login.php?form=empty");
        exit();
    }




    //Checking is user existing in the database or not
    $query = "SELECT * FROM `users` WHERE username='$username' and password='".md5($password)."'";
    $result = mysqli_query($con,$query) or die(mysql_error());
    $rows = mysqli_num_rows($result);
    if($rows==1){
        $_SESSION['username'] = $username;

        header("Location: admin/index.php");
    }else{
        echo "<div class='form'>
<h3>Username/password is incorrect.</h3>
<br/>Click here to <a href='login.php'>Login</a></div>";
    }
}
else{
?>


<div class="container">


    <?php
        $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if(strpos($fullUrl, "form=empty") == true) {
            echo '<div class="alert alert-danger" role="alert">
                 Konto nie istnieje lub hasło jest niepoprawne!
                </div>';
        }

    ?>

    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Logowanie </div>
        <div class="card-body">
            <form action="" method="post" name="login">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nazwa użytkownika</label>
                    <input class="form-control" name="username" type="text" placeholder="Login">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Hasło</label>
                    <input class="form-control" name="password" type="password" placeholder="Hasło">
                </div>
                <div class="form-group">
                </div>
                <input class="btn btn-primary btn-block" name="submit" type="submit" value="Zaloguj się" />

            </form>
        </div>
    </div>
</div>
<?php }



?>

<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>