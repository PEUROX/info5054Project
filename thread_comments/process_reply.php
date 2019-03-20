<?php
 session_start();



$db1= new mysqli('localhost','londoners','London123!','Londoners');

$qry = "insert into thread_comments (post_thread_id,post_id,member_id,comments) values (1,".$_POST['thread'].",".$_SESSION['id'].",'".$_POST['comment']."');";


if($db1->query($qry) !== true){
    echo $db1->error;
}


?>