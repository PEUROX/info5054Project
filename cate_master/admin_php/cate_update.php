<?php

include 'conn.php';
$cate_id=$_POST['row_id'];
$cate_name= $_POST['cate_name'];
$cate_des= $_POST['cate_des'];
$cate_added_by= $_POST['created_by'];
$cate_datetime= date("Y-m-d H:i:s");

if($conn->connect_errno){

    $err = "Error: ".$db_conn->connect_error;
    echo $err;
    exit;
}

$sql = "UPDATE category_master SET name ='$cate_name',  description='$cate_des', created_datetime='$cate_datetime' WHERE category_id=$cate_id";

if ($conn->query($sql) === TRUE) {
   echo "data saved successfully";
} else {
   echo "failed to save data";
}



?>