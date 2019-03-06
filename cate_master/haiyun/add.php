<?php
$cate_name= $_POST['name'];
$cate_des= $_POST['description'];
$cate_added_by= $_POST['created_by'];
$cate_datetime= date("Y-m-d H:i:s");
//Database configuration
$host = 'localhost';
$username = 'haiyun';
$password = '1234';
$dbname = 'Londoners';
//Create connection
$conn = new mysqli($host, $username, $password, $dbname);

//check connection
if($conn->connect_error){
die ("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO category_master (cate_name, description, created_by,created_datetime)
VALUES ('$cate_name', '$cate_des', $cate_added_by,'$cate_datetime')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>
