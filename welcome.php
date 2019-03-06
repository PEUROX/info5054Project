<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] !== true){
    header("location: login.php");
    exit;
}
$time = $_SERVER['REQUEST_TIME'];
/**
* for a 30 minute timeout, specified in seconds
*/
/*$timeout_duration = 10;
/**
* Here we look for the user's LAST_ACTIVITY timestamp. If
* it's set and indicates our $timeout_duration has passed,
* blow away any previous $_SESSION data and start a new one.
*/
/*if (isset($_SESSION['LAST_ACTIVITY']) && 
   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
   
      
    header("location:welcome.php");
    session_unset();
    session_destroy();
    session_start();
  
    
    
}*
/**
* Finally, update LAST_ACTIVITY so that our timeout
* is based on it and not the user's login time.
*/

$_SESSION['LAST_ACTIVITY'] = $time;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="10">
    <title>Welcome</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["adminusername"]); ?></b>. Welcome to our site.</h1>
    </div>
    <p>
        <!--<a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>-->
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
 
    <form method="POST" action="welcome.php">



</form>
</body>
</html>