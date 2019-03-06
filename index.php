<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>The londoners</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
    <link rel = stylesheet href="index.css">
</head>
<body>
<!--the first nav with login signup and logo-->
<nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
  <a class="navbar-brand" href="#">The Londoners</a>
 
    <ul class="nav navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="register.php"><span class="fas fa-user"></span> Sign Up</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php"><span class="fas fa-sign-in-alt"></span> Login</a>
      </li>
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
    <nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top"  style = "margin-bottom:50px;">

<div id="navb" class="navbar-collapse collapse hide">
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="index.php">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Contact Us</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">About Us</a>
    </li>
  </ul>

  <ul class="nav navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" href="logout.php"><span class="fas fa-sign-in-alt"></span>Logout</a>
    </li>
  </ul>
</div>
</nav>
    
<?php
    
    display_data();
    
    function display_data(){

	
	 $db = new mysqli('localhost','londoners','London123!','Londoners');
	 
	 
	 $query = "select * from category_master;";
	 

	 if($db->query($query) == true){
      
		$rs = $db->query($query); 
			if($rs->num_rows > 0){
				$category = array();
			   while($row = $rs->fetch_assoc()){
				  array_push($category,$row);
				  //print_r(category[0]);
			   }

			}else{
				echo "No threads to display";
				return;
				
			};
			
		}else{
			echo "Connection error";
			exit;
		}  
     
		$category_len = count($category);
		echo  "<div class = 'container'>";
		for($i = 0; $i < $category_len; $i++){
            
            $_SESSION['category_id'] = $category[$i]['category_id'];
			echo "<div id = 'category".$i."' class = 'jumbotron'>";
			echo "<b><a href = 'post_master.php'> <p class = 'this'>".$category[$i]['name']."</p></a></b>";
			echo "<p class = 'this'><b>Date posted: </b>".$category[$i]['created_datetime']."</p>";
			echo "<p id = '".$i."' class = 'text-muted'>".$category[$i]['description']."</p>";
			echo "</div>";
		}
		echo "</div>";
        
  
	}
?>
    
    <footer class = "inverse">
        <div class = "container">
          <p class = "text-center" style="color:white;margin-top:50px;">&copy; Copyright 2019 The Londoners</p>
        </div>
    </footer>

</body>
</html>
