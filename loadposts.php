<?php
    // Initialize the session
    session_start();

    //conn file
    require_once "dbcon.php";

    /**
 * Created by PhpStorm.
 * User: Pedro 
 * Date: 18/02/2019
 * Time: 22:14
 */

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==  true){
        header("location:login.php");
    }
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>The londoners</title>
	<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
    <link rel = stylesheet href="index.css">
    

</head>

<body>
<!--the first nav with login signup and logo-->
<nav class ="navbar navbar-inverse" style="margin:0;">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">The Londoners</a>
    </div>
    <div class="container-fluid">
    <ul class="nav navbar-nav navbar-right">
        
            <li><a href = "register.php"><span class="glyphicon glyphicon-user"></span>Sign Up</a></li>
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
        
    </ul>
  </div>
</nav>
    
    <!--Search bar with picture and search bar-->
<div id = "header" class = "jumbotron big-banner" style="height:350px;margin:0;">
<div class = "container">   
     <p class = "text-center" style = 'color:white;'>"Everything You Want and More !"</p>
   <input type = "text" placeholder = "Search...." id = "search" name = "search" class = "form-control">
</div> 	
   
</div>
    
    <!--the second and main nav-->
     <nav class = "navbar navbar-inverse">
    <div class="container-fluid">
   
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="member.php">Profile</a></li>
      <li><a href="#">About-Us</a></li>
      <li><a href="#">Contact-Us</a></li>
      
    </ul>
  </div>
</nav>
	<div id="container">
        <?php
            $sql = "SELECT post_heading, post_master_id FROM post_master WHERE member_id = ? AND category_id = ?";
                        
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("ii", $member_id, $category_id);
                
                // Set parameters
                $member_id = $_SESSION["id"];
                $category_id = $_GET['cat'];

                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Store result
                    $stmt->store_result();

                    if($stmt->num_rows > 0){       
                        //results
                        $stmt->bind_result($post_heading, $post_master_id);
                        echo "<div>";
                        echo "<h4>list of posts for category " . $_GET["catname"] . "</h4><br>";
                        while($stmt->fetch()){
                            echo "<a href='thread.php?id=" . $post_master_id . "'>" . $post_heading . "</a><br>";
                        }  
                        echo "</div>";
                    } else {
                        echo "Oops! We could not complete the task.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                $stmt->close();
            }
        ?>
	</div>
</body>
</html>