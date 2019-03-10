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

		echo "<div class = 'container'>";
		echo     "<center><h1 class = 'center text-white'>Selected Post By ".$posts[0]['first_name']."</h1></center>";
		echo "</div>";

    echo  "<div class = 'container'>";
		for($n = 0; $n < $post_len ; $n++){

		echo	"<div class = 'jumbotron' style = 'border-radius:5px;'>";
		echo 	"<div class='row'>";

		echo		         "<div class='col-sm-8'>";
		echo   		          "<p class = 'p-3 mb-2 border border-top-0' style = 'background-color:white'>Posted By : ".$posts[$n]['first_name']." ". $posts[$n]['last_name']."</p>";
	  echo		         "</div>";

		echo	          "<div class='col-sm-4'>";
		echo		   				 "<p class = 'p-3 mb-2 border border-top-0' style = 'background-color:white'>Date : ".$posts[$n]['approved_date']."</p>";
		echo	 "</div>";

		echo      "</div>";

		echo 	"<div class='row'>";
		echo		 "<div class='col-sm-12'>";
		echo   		   "<b><p style = 'background-color:white' class = 'p-3 mb-2 border border-top-0 text-info'>".strtoupper($posts[$n]['post_heading'])."</p></b>";
		echo		 "</div>";
		echo		 "</div>";

		echo 	"<div class='row'>";
		echo		 "<div class='col-sm-12'>";
		echo   		   "<p style = 'background-color:white' class = 'p-3 mb-2 border border-bottom-0'>".$posts[$n]['contents']."</p>";
		echo		 "</div>";
		echo		 "</div>";
				break;
		}
		echo "</div>";
    echo "</div>";


		echo  "<div class = 'container'>";
		echo     "<center><h3 class = 'center text-white' >Find out about ".$posts[0]['post_heading']." </h3></center>";
		for($i = 0; $i < $thread_len; $i++){
			echo "<div id = 'thread".$i."' class = 'jumbotron' style = 'border-radius:5px;margin-bottom:1px;border-bottom:'solid black 1px;'>";

			echo "<div class = 'row'>";
			echo		 "<div class='col-sm-8'>";
			echo   		   "<b><p style = 'background-color:white' class = 'p-3 mb-2 border border-top-0 text-dark'>Reply by : ".$thread[$i]['first_name'] ." ".$thread[$i]['last_name'] ."</p></b>";
			echo		 "</div>";

			echo		 "<div class='col-sm-4'>";
			echo   		   "<b><p style = 'background-color:white' class = 'p-3 mb-2 border border-top-0 text-dark'>Date : ".$thread[$i]['thread_created_date'] ."</p></b>";
			echo		 "</div>";
			echo "</div>";
			echo "<div style = 'background-color:white;' class = ' p-3 mb-2 border border-top-0'>";
			echo "<p style = 'padding:20px;' id = '".$i."' class = 'text-dark'>".$thread[$i]['thread_data']."</p>";
			echo "</div>";
	    echo     "<input type = 'button' style = 'margin-top:10px;margin-bottom:10px;' class = 'btn btn-primary' value = 'Reply' name = 'reply' id = 'reply".$i."'/>";
			echo "<form  id = 'replyForm".$i."' method = 'post'>";
			echo     "<textarea placeholder = 'Reply....'  id = 'threadArea".$i."' rows = '3' cols = '100' name='thread' class = ''></textarea></br></br>";
			echo     "<input style = '' type = 'submit' id = 'postReply' name = 'postReply' value = 'Post' class = 'btn btn-primary' />";
			 echo	"</form>";

			echo "</div>";

             ?>

             <script>
             $("#reply" + <?php echo $i ?>).click(function(){
                 if($("#replyForm"+<?php echo $i ?>).is(":visible")){
                     $("#replyForm"+<?php echo $i ?>).hide(1000);
                 }else{
                     $("#replyForm"+<?php echo $i ?>).show(1000);
                 }
             })
             </script>

             <?php

		}
		echo "</div>";
	}

?>
</section>

    <div class = "container" >
		<div id = 'thread".$i."' class = 'jumbotron' style = 'background-color:white;border-radius:5px;margin-top:10px;'>
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
