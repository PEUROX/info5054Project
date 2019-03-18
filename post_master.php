<?php
  session_start();
 
?>

<?php
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['btn_new_post'])){
      if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==  true){
          header("location:login.php");
      }
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


	
<section id="templates">

<header>
    
<h2> Category Header</h2>
	

</header>

<!-- 	
<div class="templates_icons">
  
   
    <div class="item"><img src="images/sub-category/news.jpg">
	<div class="img-text"><a href="#"></a>News</div>
	</div>
	
	<div class="item"><img src="images/sub-category/rent.png">
	<div class="img-text"><a href="#"></a>renting a house</div>
	</div>
	
	<div class="item"><img src="images/sub-category/job.png">
	<div class="img-text"><a href="#"></a>finding a job</div>
	</div>
	
	<div class="item"><img src="images/sub-category/car.png">
	<div class="img-text"><a href="#"></a>buying a car</div>
	</div>
	
	<div class="item"><img src="images/sub-category/carpool.png">
	<div class="img-text"><a href="#">looking for a ride</a></div>
	</div>
	
	<div class="item"><img src="images/sub-category/chat.png">
	<div class="img-text"><a href="#">Wanna chat?</a></div>
	</div>

    </div>
	<button id="btnMore">more </button>
-->	

</section>

<div id="container">
<?php 
  $category_id = 1;
	require_once("dbOperations.php"); 
	 
	if (isset($_POST['btn_new_post']))
{

formPostAdd($category_id ,'','');
	
}

else if (isset($_POST['btn_post_save']))
{

formPostSave($category_id );
	
}
else if (isset($_POST['btn_view_back']))
{

  header("Location: index.php");
    exit;
	
}
else  
{
	formDisplayPosts($category_id);
}





function formDisplayPosts($category_id){


	 // get the selected contact details
	 
	 $rs = getPostsByCategoryID($category_id) ;
	
		// $row = $rs->fetch_assoc();

?>
			 <form action ="./post_master.php" method ="POST">
			 
 <h3>Posts </h3>
 <table style ="background-color:white;  width:100% ; border: 2px solid green">
 
 <?php 
	 
	 if ($rs->num_rows > 0)
     {
		 while ($row = $rs->fetch_assoc())
         { ?>
            
			<tr>
			
			<td colspan=2><h4><a href = <?php echo "thread.php?id=". $row['post_master_id'] ;?>  name=  <?php echo $row['post_master_id']; ?> ><?php echo $row['post_heading'];  ?> </a></h4> </td>
			 <tr><td> </td></tr>
			</tr>
			<tr><td><b> Posted By : <?php echo $row['first_name'] . ' '.$row['last_name'];  ?></b></td>
			<td><b><?php echo $row['post_date'];  ?></b></td></tr>
			<tr>
			
			<td colspan =2><?php echo $row['contents']; ?></td>
			</tr>
			<tr>
			
			<td colspan =2>
			
			<?php 
			     $_SESSION['user_type']  ='mbr';
					 if ($_SESSION['user_type'] =='mbr') { 
           $_SESSION['member_id']  ='1';
             if ($_SESSION['member_id'] ==$row['member_id']) { ?>

<a href = <?php formPostDelete($row['post_master_id']) ?>  name=  <?php echo 'btn_Delete'.$row['post_master_id'];?> >Delete </a> &nbsp;
			       
<a href = <?php formPostArchive($row['post_master_id']) ?>  name=  <?php echo 'btn_Archive'.$row['post_master_id'];?> >Archive </a>
					<?php }} ?>
       
			
			 </td>

			</tr>
			<tr>
			
			<td colspan =2><hr></td>
			</tr>
			
<?php }} ?>

 
 </table>
 <br><br>

 <?php 
 $_SESSION['user_type']  ='mbr';
if ($_SESSION['user_type'] =='mbr') { ?>

 <input type="submit" name="btn_new_post" value="Write a new Post" class = "btn btn-primary" style="margin-bottom:20px;"> &nbsp;
<?php } ?>
<input type="submit" name="btn_view_back" value="Back" class = "btn btn-primary" style="margin-bottom:20px;>
			</form>

	

<?php  } ?>


<?php 

function formPostAdd($category_id ,$heading ,$contents)
{ ?>
	<form method="POST" action="post_master.php" >
	<div  width="100%" height="100%"  >
	 <h2> New Post Entry Page </h2>
	
	 <br>
				
	 <label for="heading">Heading</label>  <br>
		<input type="text" size="100"  id ="txtheading" name="txtheading" value= "<?php echo  $heading ?>"></input>
		<br>
				 <br>  

				 <label for="txtContents">Content</label><br>
		<textarea id="txtContents" name="txtContents" rows="7" cols="125" maxlength="65530"  width ="100%"><?php echo  $contents ?></textarea>
		<br>
				 		
				 
				 <br>
				 
				 <input type="submit" name ="btn_post_save" value="Save" />
				 <input type="submit" name ="Cancel" value="Cancel"/>
				 <br>
			</div>
		 </form>
	<?php

}
?>
<?php 
function formPostSave($category_id ){
	
	$error_formAdd_msg = validate_formAdd_fields();
	if (count($error_formAdd_msg) > 0){
					display_error($error_formAdd_msg);
					// if error stay on page 2 with user data 
					//form_next($_POST['notes'], strtolower(pathinfo($_FILES['pic']['name'])));
					formPostAdd($category_id,$_POST['txtheading'], $_POST['txtContents']);
	}
	else{
			//if page 2 validation success , upload image and save data to db .
	save_data($category_id);
	// if save success  show summary page

	formDisplayPosts($category_id);
//display_success();
	}
}


?>
<?php
function save_data($category_id){
	
	$db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);
$qry = "INSERT INTO post_master (member_id,category_id , location_id,post_heading,contents,post_date, 
          approved_by,approved_date,post_active,post_inactive_date,post_viewer_action_id,comments) 
         values(".$_SESSION['id'].", '".$category_id."',1,'".$_POST['txtheading']."',
         '".$_POST['txtContents']."', current_timestamp,1,current_timestamp,'Y',current_timestamp,1,'test');";
	
//.$_SESSION['id']
//$db_conn->query($qry);
    
    if($db_conn->query($qry)!==true){
        echo $db_conn->error;
    }
    
//get PK from table
$post_id  = mysqli_insert_id($db_conn);   

return $post_id;

}
?>


<?php 
  // validate page 1
function validate_formAdd_fields(){
    $error_msg = array();
     
    //Name validation
	if (!isset($_POST['txtheading'])){
		$error_msg[] = " Heading field not defined";
	} else if (isset($_POST['txtheading'])){
		$heading = trim($_POST['txtheading']);
		if (empty($heading)){
			$error_msg[] = "The  Heading field is empty";
		} else {
			if (strlen($heading) >  100){
				$error_msg[] = "The  heading field contains too many characters";
			}
		}
    }
    
    if (!isset($_POST['txtContents'])){
			$error_msg[] = " Notes field not defined";
		} else if (isset($_POST['txtContents'])){
			$txtContents = trim($_POST['txtContents']);
			if (empty($txtContents)){
				$error_msg[] = "The  Contents field is empty";
			} else {
				if (strlen($txtContents) >  65535){
					$error_msg[] = "The   Contents field contains too many characters";
				}
			}
			}
    
    
/*	if (count($error_msg) == 0){
       // if no error store session 
        store_form1_session( $name, $age);         
	} */
	return $error_msg;
} ?>

<?php function display_error($error_msg){
	echo "<p>\n";
	foreach($error_msg as $v){
		echo $v."<br>\n";
	}
	echo "</p>\n";
} ?>

</div>
  
	<footer class = "inverse">
        <div class = "container">
          <p class = "text-center" style="color:white;margin-top:50px;">&copy; Copyright 2019 The Londoners</p>
        </div>
    </footer>
</body>
</html>
