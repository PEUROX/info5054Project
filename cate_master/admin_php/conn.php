<?php

//Create connection
$conn = new mysqli('localhost','londoners','London123!','Londoners');

//check connection
if($conn->connect_error){
echo "Connection failed: " . $conn->connect_error;
}

?>