<?php
  session_start();

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['new_thread'])){
      if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==  true){
          header("location:login.php");
      }
  }
?>

<?php

	 if(isset($_POST['red_posts'])){
 header("location: http://localhost/app/post_master.php");
 }

	function save_thread($thread){
		 $db1= new mysqli('localhost','londoners','London123!','Londoners');

		 $qry = "insert into post_threads (post_master_id,member_id,previous_thread_id,thread_data) values (".$_SESSION['thread_post_id'].",".$_SESSION['id'].",1,'".$thread."');";


		 if($db1->query($qry) !== true){
		 //echo $_SESSION['id'];
		 echo "<p style = 'color:red;'>Error in posting! Please try again.</p></br>";
							 echo $db1->error;

		 }else{
		 echo "<p style = 'color:green;'>New thread created</p></br>";
		 }

	}




	?>
<!doctype html>
<html>
<head>
<!-- Font Awesome Icon Library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
    <link rel = stylesheet href="index.css">
</head>
<!--CSS for stars-->
<style>
.checked {
  color: grey;
}
</style>

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
<div id = "header" class = "jumbotron big-banner" style="height:350px;margin:0;border-radius:0;">
<div class = "container">
     <p class = "text-center" style = 'color:white;'>"Everything You Want and More !"</p>
   <input type = "text" placeholder = "Search...." id = "search" name = "search" class = "form-control">
</div>

</div>

    <!--the second and main nav-->
		<nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top" style = "margin-bottom:50px;">

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

<?php
$_SESSION['thread_post_id'] = $_GET['id'];
//echo $_SESSION['thread_post_id'];
require_once("dbOperations.php");



//echo  $id ;

if (isset($_POST['new_thread'])){
	$err_message = array();

	 $thread = trim($_POST['thread']);
	 if (empty($thread)){
		 echo $err_message = "<p style = 'color:red;'>Sorry, the thread cannot be empty</p></br>";
	 }else{
		 //$_SESSION['thread'] = $thread;

		 save_thread($thread);
		 display_data();
	 }

}else{
	display_data();
}

function display_data(){


	 $db = new mysqli('localhost','londoners','London123!','Londoners');


	 $query = "select * from member_profile INNER JOIN post_threads
	           ON post_threads.member_id = member_profile.member_id WHERE post_threads.post_master_id = ".$_SESSION['thread_post_id'] .";";

	 $post_query = "select * from post_master INNER JOIN member_profile ON post_master.member_id = member_profile.member_id where post_master.post_master_id = ".$_SESSION['thread_post_id'].";";

	 if($db->query($query) == true){

		$rs = $db->query($query);
			if($rs->num_rows > 0){
				$thread = array();

			   while($row = $rs->fetch_assoc()){
				  array_push($thread,$row);
				  //print_r($thread[0]);
				 }


			}else{
				echo "No threads to display";
				return;

			};

		}else{
			echo "Connection error";
			exit;
		}
////////////////////////////////////////////////////////////////////////////
		if($db->query($post_query) == true){

			$rs = $db->query($post_query);
				if($rs->num_rows > 0){
					$posts = array();

					 while($row = $rs->fetch_assoc()){
						array_push($posts,$row);
						//print_r($thread[0]);
					 }


				}

			}else{
				echo "Connection error";
				exit;
			}

		$thread_len = count($thread);
		$post_len = count($posts);

		?>

		    <div class = 'container'>
         		<center><h1 class = 'center' style = 'color:black;'>Selected Post By <?php echo $posts[0]['first_name']?></h1></center>
		    </div>


   
      <div class = 'container'>

		<?php for($n = 0; $n < $post_len ; $n++){ ?>
		
		<div class = 'jumbotron'  style = 'box-shadow: 2px 3px 3px grey;background-color:white;' style = 'border-radius:5px;'>
		<div class='row'>
	<div class='col-sm-9'>
		<div class='row'>
		     <div class='col-sm-5'>
				   				 <p class = 'p-3 mb-2 border border-top-0' style = 'background-color:white'>Date : <?php echo $posts[$n]['approved_date'] ?> </p>
			</div>

		        </div>

		 	    <div class='row'>
				 <div class='col-sm-12'>
		   		   <b><p style = 'background-color:white' class = 'p-3 mb-2 border border-top-0 text-info'> <?php echo strtoupper($posts[$n]['post_heading']) ?> </p></b>
				 </div>
				 </div>

		 	 <div class='row'>
				 <div class='col-sm-12'>
		   		   <p style = 'background-color:white' class = 'p-3 mb-2 border border-bottom-0'><?php echo $posts[$n]['contents'] ?> </p>
				 </div>
		</div>
		   </div>
		 <div class='col-sm-3'>

				<div class = 'container' style = 'margin-top:30px;;text-align:center;'>
							<img style = 'border-radius:500px 500px 500px 500px;height:100px;width:100px;' src = 'images/london.jpg'><br><br>
							 <?php echo "Posted By: ".$posts[0]['first_name']."<br><br>";?>
							 <span class="fa fa-star checked"></span>
               <span class="fa fa-star checked"></span>
               <span class="fa fa-star checked"></span>
               <span class="fa fa-star"></span>
               <span class="fa fa-star"></span>
				</div>

		</div>
		 </div>
<?php
				break;
		}?>

		 </div>
    </div>
    

	  <div class = 'container'>
		     <center><h3 class = 'center' style ='color:black;'>Find out about <?php echo $posts[0]['post_heading'] ?> </h3></center>
		<?php for($i = 0; $i < $thread_len; $i++){?>
			<div id = 'thread<?php echo $i ?>' class = 'jumbotron' style = 'background-color:white;border-radius:5px;box-shadow: 2px 3px 3px grey;margin-bottom:10px;border-bottom:solid black 1px;'>

			<div class='row'>
	    <div class='col-sm-9'>

			<div class = 'row'>
				 <div class='col-sm-8'>
			   		   <b><p style = 'background-color:white' class = 'p-3 mb-2 border border-top-0 text-dark'>Reply by : <?php echo $thread[$i]['first_name'] ." ". $thread[$i]['last_name'] ?> </p></b>
					 </div>

					 <div class='col-sm-4'>
			   		   <b><p style = 'background-color:white' class = 'p-3 mb-2 border border-top-0 text-dark'>Date : <?php echo $thread[$i]['thread_created_date'] ?> </p></b>
					 </div>
			 </div>
			 <div style = 'background-color:white;' class = ' p-3 mb-2 border border-top-0'>
			 <p style = 'padding:20px;' id ='<?php echo $i ?>' class = 'text-dark'> <?php echo $thread[$i]['thread_data'] ?></p>
			 </div>
	         <input type = 'button' style = 'margin-top:10px;margin-bottom:10px;' class = 'btn btn-primary' value = 'Comment' name = 'reply' id = 'reply<?php echo $i ?>'/>
		
			
			 <form  id = 'replyForm<?php echo $i ?>' method = 'post' style = 'display:none;'>
			     <textarea placeholder = 'Comment....'  id = 'threadArea<?php echo $i ?>' rows = '3' cols = '100' name='thread <?php echo $i ?>' class = ''></textarea></br></br>
			     <input style = '' type = 'submit' id = 'postReply<?php echo $i ?>' name = 'postReply <?php echo $i ?>' value = 'Post' class = 'btn btn-primary' />
			 	</form>

     	<?php if(isset($_POST['postReply'.$i])){
				echo $_POST['thread'.$i];
			}?>

			       
			</div>
			<div class='col-sm-3'>

<div class = 'container' style = 'margin-top:30px;;text-align:center;'>
			<img style = 'border-radius:500px 500px 500px 500px;height:100px;width:100px;' src = 'images/london.jpg'><br><br>
			 <?php echo "Posted By: ".$posts[0]['first_name']."<br><br>";?>
			 <span class="fa fa-star checked"></span>
			 <span class="fa fa-star checked"></span>
			 <span class="fa fa-star checked"></span>
			 <span class="fa fa-star"></span>
			 <span class="fa fa-star"></span>
</div>

</div>

		</div>

			</div>

             <script>

              //jQuery code for comment section ajax communication

							

						 //jQuery code to hide and show reply form
             $("#reply<?php echo $i ?>").click(function(){
                 if($("#replyForm<?php echo $i ?>").is(":visible")){
                     $("#replyForm<?php echo $i ?>").hide(1000);
                 }else{
                     $("#replyForm<?php echo $i ?>").show(1000);
                 }
             })

             </script>

             <?php

		}?>
		 </div>
<?php	}?>

?>
</section>

    <div class = "container" >
		<div id = 'thread".$i."' class = 'jumbotron' style = 'box-shadow: 2px 3px 3px grey;background-color:white;border-radius:5px;margin-top:10px;'>
  <form method = "post">
        <h2 class = "text-dark">Start a new thread</h2>
		   <textarea id = "threadArea" rows = '5' cols = '100' name="thread" class = "form-control"></textarea></br></br>

		   <input type = "submit" name = "new_thread" value = "Post Thread" class = 'btn btn-primary' style ="margin-bottom:20px;"/>
		   <input type = "submit" id = "red_posts" name = "red_posts" value = "back" class = 'btn btn-primary' style ="margin-bottom:20px;"/>
	</form>
	  </div>
		</div>


	</div>

	<footer class = "inverse">
        <div class = "container">
          <p class = "text-center" style="color:white;margin-top:50px;">&copy; Copyright 2019 The Londoners</p>
        </div>
    </footer>


</body>


</html>
