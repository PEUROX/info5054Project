<?php
include 'conn.php';

$cate_name= $_POST['name'];
$cate_des= $_POST['description'];
$cate_added_by= $_POST['created_by'];
$cate_datetime= date("Y-m-d H:i:s");

if (empty(trim($cate_name))||empty(trim($cate_added_by))||empty(trim($cate_des))){
    
    $err = array("status" => "error");
	$err['status_msg'] = "Error: Category name or description can't be empty!";
	echo json_encode($err);
    exit;

}

if($conn->connect_errno){

    $err = array("status" => "error");
	$err['status_msg'] = "Error: ".$db_conn->connect_error;
	echo json_encode($books);
    exit;

}

if($cate_name){

    $sql2 = "SELECT category_id FROM category_master WHERE cate_name ='$cate_name'";

    $res =$conn->query($sql2);

    if ($res->num_rows>0){
        $err = array("status" => "error");
        $err['status_msg'] = "Category name already exists!";
        echo json_encode($err);

        exit;

    }

}
   
if($cate_name){

        $sql = "INSERT INTO category_master (name, description, created_by,created_datetime)
         VALUES ('$cate_name', '$cate_des', $cate_added_by,'$cate_datetime')";
         if ($conn->query($sql) === TRUE) {
            $err = array("status" => "ok");
            $err['status_msg'] = "Category created successfully!";
            echo json_encode($err);
        } else {
            $err = array("status" => "error");
            $err['status_msg'] = "Could not save data";
            echo json_encode($err);
        }
    }

$conn->close();


?>
