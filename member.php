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
    <style>
        .card {
          box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
          transition: 0.3s;
          width: 40%;
          border-radius: 5px;
        }

        .card:hover {
          box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }

        img {
          border-radius: 5px 5px 0 0;
        }

        .container {
          padding: 2px 16px;
        }
    </style>
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
        <div class="card">
        <img src="img_avatar.png" alt="Avatar" style="width:100%">
        <div class="container">
		<h4>Member profile</h4>
        <?php 
            //check if there is an user logged in
            if($_SESSION["id"]){

                //---------
                //get user data (from member_profile table)
                //----------
                $sql = "SELECT first_name, city, email FROM member_profile WHERE user_id = ?";
                
                if($stmt = $mysqli->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("s", $param_username);
                    
                    // Set parameters
                    $param_username = $_SESSION["id"];
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Store result
                        $stmt->store_result();

                        if($stmt->num_rows == 1){       
                            //results
                            $stmt->bind_result($first_name, $city, $email);
                            if($stmt->fetch()){
                                echo "<div>First name: " . $first_name . "<br>";
                                echo "City: " . $city . "<br>";
                                echo "Email: " . $email . "<br>";
                                echo "</div><br>";
                            }  
                        } else {
                            echo "We could not find a profile for the specified member";
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    $stmt->close();
                }

                //---------
                //get count of categories from the posts that user made
                //---------
                $sql = "SELECT COUNT(post_master.category_id), post_master.category_id, category_master.name FROM post_master INNER JOIN category_master ON post_master.category_id  = category_master.category_id WHERE member_id = ? GROUP BY category_master.name LIMIT 6";

                if($stmt = $mysqli->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("s", $param_username);
                    
                    // Set parameters
                    $param_username = $_SESSION["id"];
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Store result
                        $stmt->store_result();
                        if($stmt->num_rows > 0){   

                            //results
                            $stmt->bind_result($count, $category_id, $category_name);

                            echo "<h5>Member's favorite categories</h5>";
                            while($stmt->fetch()){
                                echo "<div><a href='loadposts.php?cat=" . $category_id . "&catname=" . $category_name . "'>" . $category_name . ": " . $count . "</a><br>";
                                echo "</div>";
                            }
                        } else {
                            echo "It seems that this member has not posted anything yet.";
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    $stmt->close();
                }
            }
        ?>
        </div>
        </div>
	</div>
</body>
</html>