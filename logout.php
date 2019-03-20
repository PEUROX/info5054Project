<?php
// session start
session_start();
 
$_SESSION = array();
 
//unset($_SESSION['loggedin']);
// Destroy the session.
session_destroy();
 
// Redirect to index page not the home page of user
header("location: index.php");
exit;
?>