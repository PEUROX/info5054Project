<?php
  session_start();

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['new_thread'])){
      if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==  true){
          header("location:../register_funcs/login.php");
      }
  }
?>

<?php

	 if(isset($_POST['red_posts'])){
 header("location: http://localhost/app/post_master/post_master.php");
 }

	function save_thread($thread){
		 $db1= new mysqli('localhost','londoners','London123!','Londoners');

		 $qry = "insert into post_threads (post_master_id,member_id,previous_thread_id,thread_data) values (".$_SESSION['thread_post_id'].",".$_SESSION['id'].",1,'".$thread."');";


		 if($db1->query($qry) !== true){
		 //echo $_SESSION['id'];
		 echo "<p style = 'color:red;'>Error in posting! Please try again.</p></br>";
							 echo $db1->error;

		 }else{
		  ?>
			     <script>
                alert("New Thread Posted !")
					 </script>
			<?php
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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
    <link rel = stylesheet href="../css/index.css">
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
			<a class="nav-link" href="../logout.php"><span class="fas fa-sign-in-alt"></span>Logout</a>
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
			<a class="nav-link" href="../index.php">Home</a>f
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">Contact Us</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">About Us</a>
		</li>
	</ul>


</div>
</nav>

<section id="templates">

<?php
$_SESSION['thread_post_id'] = $_GET['id'];
//echo $_SESSION['thread_post_id'];
require_once("../post_master/dbOperations.php");



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
				$thread = ["No value"];

			   while($row = $rs->fetch_assoc()){
				  array_push($thread,$row);
				  //print_r($thread[0]);
				 }


			}else{
				echo "No threads to display";
				return;

			};

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

			}

		$thread_len = count($thread);
		$post_len = count($posts);

		?>

		  <!-- <div class = 'container'>
         		<center><h1 class = 'center' style = 'color:black;'>Selected Post By <?php echo $posts[0]['first_name']?></h1></center>
		    </div>-->



      <div class = 'container'>

		<?php for($n = 0; $n < $post_len ; $n++){ ?>

		<div class = 'container'  style = ''>
		<div class='row'>

		          <div class='col-sm-3'>

      <div class = 'container' style = 'text-align:center;'>
			<img style = 'box-shadow: 3px 3px 4px grey;border-radius:500px 500px 500px 500px;height:80px;width:80px;' src = '../images/log2.jfif'><br><br>


</div>

</div>

	<div class='col-sm-9'>
		<div class='row'>
		     <div class='col-sm-5'>
				   				 <p class = '' style = 'padding:0;font-size:0.8em;color:grey;'>Date : <?php echo $posts[$n]['approved_date'] ?> </p>
			</div>

		        </div>

		 	    <div class='row'>
				 <div class='col-sm-12'>
		   		   <b><p style = 'font-size:2em;color:green;' class = ''> <?php echo ucwords($posts[$n]['post_heading']) ?> </p></b>
				 </div>
				 </div>

		 	 <div class='row'>

		</div>
		   </div>

		 </div>
<?php
				break;
		}?>

		 </div>
    </div>


	  <div class = 'container'>
		    <!-- <center><h3 class = 'center' style ='color:black;'>Find out about <?php// echo $posts[0]['post_heading'] ?> </h3></center>-->
		<?php for($i = 1; $i < $thread_len; $i++){?>
			<div id = 'thread<?php echo $i ?>' class = 'jumbotron' style = 'background-color:white;border-radius:0px;box-shadow: 1px 1px 1px grey;margin-bottom:10px;border-bottom:solid black 1px;'>

			<div class='row'>

			<div class='col-sm-3'>

<div class = 'container' style = 'margin-top:30px;;text-align:center;'>
			<img style = 'box-shadow: 3px 3px 4px grey;border-radius:500px 500px 500px 500px;height:80px;width:80px;' src = '../images/london.jpg'><br><br>
			 <?php echo "Posted By: ".$posts[0]['first_name']."<br><br>";?>
			 <span class="fa fa-star checked"></span>
			 <span class="fa fa-star checked"></span>
			 <span class="fa fa-star checked"></span>
			 <span class="fa fa-star"></span>
			 <span class="fa fa-star"></span>
</div>

</div>

	    <div class='col-sm-9'>

			<div class = 'row'>
					 <div class='col-sm-12'>
			   		   <b><p style = 'background-color:white;color:grey;font-size:0.7em;' class = ''>Date : <?php echo $thread[$i]['thread_created_date'] ?> </p></b>
					 </div>
			 </div>
			 <div style = 'background-color:white;' class = ''>
			 <p style = 'padding:20px;padding-left:0;padding-top:0;' id ='<?php echo $i ?>' class = 'text-dark'> <?php echo $thread[$i]['thread_data'] ?></p>
			 </div>
	         <input type = 'button' style = 'margin-top:10px;margin-bottom:10px;' class = 'btn btn-primary' value = 'Comment' name = 'reply' id = 'reply<?php echo $i ?>'/>

					<?php
						 
						 
						$comments = comment_show($i);
					
              if(isset($_POST["'postReply'.$i."])){
								
								new_comm($comments,$i,$posts);
							}

						new_comm($comments,$i,$posts);
     ?>

			 <form id = 'replyForm<?php echo $i ?>' method = 'post' style = 'display:none;'>
			     <textarea placeholder = 'Comment....'  id = 'threadArea<?php echo $i ?>' rows = '3' cols = '100' name='comment' class = ''></textarea></br></br>
			     <input style = '' type = 'submit' id = 'postReply<?php echo $i ?>' name = 'postReply<?php echo $i ?>' value = 'Post' class = 'btn btn-primary' />
			 	</form>


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

						 //reply form submit using ajax

						 $("#postReply<?php echo $i ?>").click(function(){
                
                   var data = $("#replyForm<?php echo $i ?>").serializeArray();
									 data[1] = {name: "thread", value: <?php echo $i; ?>};
                   console.log(data);
							$.post("process_reply.php",data,function(res){
								     console.log(res);
							});
							
						 })

             </script>

             <?php

		}?>
		 </div>
<?php	}?>

<?php

function new_comm($comments,$i,$posts){

	if(isset($comments)){
		$count_comm = count($comments);
							for($c = 0; $c < $count_comm; $c++){?>
						<div class = "row" style = 'margin-top:20px;'>
						<div class='col-sm-2'>
								 
	<div class = 'container' style = 'text-align:center;'>
				<img style = 'box-shadow: 3px 3px 4px grey;border-radius:500px 500px 500px 500px;height:50px;width:50px;' src = '../images/scooter.jfif'><br><br>
	</div>
						</div>
						<div class='col-sm-10'>
							<div id = 'comment<?php echo $i ?>' class = jumbotron style = 'padding:10px;border-radius:0;'>
							<div class = "row">
							<div class='col-sm-9'>
								 <p style= 'font-size:0.8em;color:grey;margin-bottom:0;'><?php echo "Posted By: ".$comments[$c]['first_name']."<br><br>";?>
								<p style = 'margin:0'><?php echo $comments[$c]['comments']."<br>";?></p>
							</div>
	 
							<div class='col-sm-3'>
									<p style= 'font-size:0.8em;color:grey;'><?php echo $comments[$c]['thread_created_date'] ?></p>
							</div>
							</div>
								 </div>
								 </div>
								 </div>
							<?php }?>
	<?php }
						 }
	?>

<?php
    function comment_show($id){

			

			$db = new mysqli('localhost','londoners','London123!','Londoners');


			$query = "select member_profile.first_name,thread_comments.post_thread_id,thread_comments.comments,thread_comments.thread_created_date from member_profile INNER JOIN thread_comments
								ON thread_comments.member_id = member_profile.member_id WHERE thread_comments.post_thread_id = ".$id." ORDER BY thread_comments.thread_created_date;";
	 
		
			if($db->query($query) == true){
	 
			 $rs = $db->query($query);
				 if($rs->num_rows > 0){
					 $comment = array();
	 
						while($row = $rs->fetch_assoc()){
							 array_push($comment,$row);
						}
	
						  
	              return $comment;
				 }else{
					 return;
				 }
	 
			 }
		 }

?>

</section>

    <div class = "container" >
		<div id = 'thread".$i."' class = 'jumbotron' style = 'box-shadow: 2px 3px 3px grey;background-color:white;border-radius:5px;margin-top:10px;'>
  <form method = "post">
        <h2 class = "text-dark">Join The Conversatiion</h2>
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
